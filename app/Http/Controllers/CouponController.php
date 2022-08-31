<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Coupons\CheckCouponValidity;
use Illuminate\Support\Facades\Http;

class CouponController extends Controller
{
    /**
     * Query Stripe to determine if the coupon is valid or not.
     * Endpoint: https://api.stripe.com/v1/coupons/25_5OFF
     */
    public function checkValidity(CheckCouponValidity $request)
    {
        $data = $request->validated();

        $stripe = new \Stripe\StripeClient(
            config('cashier.secret')
        );

        try {
            $results = $stripe->coupons->retrieve($data["coupon_code"], []);
            return response()->json(["success" => true], 200);
        }
        catch(\Exception $e) {
            return response()->json(["success" => false], 200);
        } 
    }

}
