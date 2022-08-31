<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Subscriptions\RegisterUserWithSubscription;
use App\Http\Requests\Subscriptions\UpdateSubscriptionRequest;
use App\Http\Requests\Subscriptions\CreatePaymentMethodRequest;
use App\Http\Requests\Subscriptions\DeletePaymentMethodRequest;
use App\Http\Requests\Subscriptions\MakeMethodPrimaryRequest;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewCollegeSelected;

use App\User;
use App\Models\Plan;
use App\Models\Coupon;
use App\Domain\Mailchimp\Connector;

class SubscriptionController extends Controller
{
    /**
     * Make the selected payment method the default.
     */
    public function makePaymentMethodPrimary(MakeMethodPrimaryRequest $request)
    {
        $fields = $request->validated();
        $user = \Auth::user();
        $user->updateDefaultPaymentMethod($fields['payment_method']);

        return response()->json("Payment method updated", 200);
    }

    /**
     * Add an an additional payment method to the user.
     */
    public function createPaymentMethod(CreatePaymentMethodRequest $request)
    {
        $fields = $request->validated();
        $user = \Auth::user();
        $user->addPaymentMethod($fields['payment_method']);

        $methods = $user->getPaymentMethodArray();
        return response()->json($methods, 200);
    }

    /**
     * Delete an existing payment method, assuming it's not the users only payment method.
     */
    public function deletePaymentMethod(DeletePaymentMethodRequest $request, $payment_method)
    {
        $fields = $request->validated();
        $user = \Auth::user();

        //If the user has multiple payment methods
        $methods = $user->getPaymentMethodArray();
        if($methods->count() > 1)
        {
            $paymentMethod = $user->findPaymentMethod($payment_method);
            $paymentMethod->delete();

            return response()->json($user->get, 200);
        }
        else 
        {
            return response()->json("You can not delete your only payment method.", 400);
        }

        
    }

    /**
     * Return a payment intent to the front end as a part of the stripe registration process.
     */
    public function paymentIntent()
    {
        $user = \Auth::user();
        if($user) 
        {
            $setup_intent = $user->createSetupIntent();
        }
        else 
        {
            $setup_intent = (new User())->createSetupIntent();
        }

        return response()->json($setup_intent, 200);
    }
    
    /**
     * Update the users stripe plan.
     */
    public function changeSubscription(UpdateSubscriptionRequest $request, Plan $plan)
    {
        //Retrieve the data we need
        $user = \Auth::user();
        $current_subscription_id = $user->subscriptions->first()->pluck("stripe_id");

        //Make sure this is an actual change
        if($plan->stripe_id == $current_subscription_id) {
            return response()->json("You're already on this plan.", 400);
        }

        //If moving to a free plan this is realy a cancelation.
        elseif($plan->cost <= 0) {
            $this->cancelSubscriptions();
        }

        else {
            //Update the users subscription.
            $user->subscription('default')->skipTrial()->swap($plan->stripe_id);
    
            //We return the new plan since we queried it earlier.
            return response()->json($plan, 200);
        }
    }

    /**
     * Cancel all of the users active subscriptions.
     */
    public function cancelSubscriptions()
    {
        //TODO
    }

    public function registerUserWithSubscription(RegisterUserWithSubscription $request)
    {
        $fields = $request->validated();

        //Create the user
        $user = User::create([
            'first_name'        => $fields['first_name'],
            'last_name'         => $fields['last_name'],
            'email'             => $fields['email'],
            'password'          => Hash::make($fields['password']),
            'consent_given'     => $fields['consent_given'],
            'profile_theme_id'          => config('app.default_theme_id'),
        ]);

        //If plan was selected and we are not in test mode
        if($fields["plan_id"] && ! \App::environment('local'))
        {
            //Get the appropriate plan
            $plan = Plan::where("id", $fields["plan_id"])->first();

            //If the plan has a stripe id
            if($plan->stripe_id)
            {
                $coupon_code = "";
                
                //Create coupon in backend
                if(array_key_exists("coupon", $fields)) 
                {
                    $coupon_code = $fields["coupon"];

                    $coupon = new Coupon();
                    $coupon->code = $coupon_code;
                    $coupon->user_id = $user->id;
                    $coupon->save();
                }

                //Subscribe them to a plan
                $user->newSubscription('default', $plan->stripe_id)
                    ->withCoupon($coupon_code)
                    ->trialDays($plan->trial_duration)
                    ->create($fields['payment_method']);
            }
            else
            {
                //Even if the user selected the free plan, we MAY want to still create them as a stripe user.
                if($fields['payment_method']) 
                {
                    $user->createAsStripeCustomer();
                }
            }
        }
        
        //Send the users verification email
        $user->sendEmailVerificationNotification($user->id);

        //Assign the user the correct roles
        $user->assignRole("athlete");
        if(isset($plan))
        {
            $user->assignRole($plan->role);
        }

        //Add the user to Mailchimp
        $mc_connector = new Connector();
        $mc_connector->addUser($user->email, $user->first_name, $user->last_name, "athlete");

        //Log the user in.
        \Auth::login($user);
    }

    /**
     * Return all of the users relevant billing details to be displayed on the subscription page.
     */
    public function getBillingDetails(Request $request)
    {
        $user = \Auth::user();
        $details = new \stdClass();

        //If the user is a stripe customer
        if($user->hasStripeId()) 
        {
            //Find all of the plans that the user has based on the stripe subscriptions (there's pretty much a 1-to-1 mapping between subscriptions and plans in our case).
            $subscription_ids = $user->subscriptions->pluck("stripe_plan");
            $plans = Plan::whereIn("stripe_id", $subscription_ids)->get();

            //ATM we only allow one plan, so we'll just set the first.
            $details->active_plan = $plans->first();
            $details->plans = Plan::get();

            //Add the users payment methods
            if($user->hasPaymentMethod()) 
            {
                $details->payment_methods = $user->getPaymentMethodArray();

                $default = $user->defaultPaymentMethod()->asStripePaymentMethod();
                $details->default_method = $default["id"];
            }
            else 
            {
                $details->payment_methods = null;
            }
        }

        return response()->json($details, 200);
    }

    public function getPayments(Request $request)
    {
        $user = \Auth::user();
        $invoices = array();

        //If the user is a stripe customer
        if($user->hasStripeId()) 
        {
            $invoiceObjs = $user->invoicesIncludingPending();

            foreach($invoiceObjs as $invoiceObj) 
            {
                $invoices[] = $invoiceObj->asStripeInvoice();
            }
        }

        return response()->json($invoices, 200);
    }
}
