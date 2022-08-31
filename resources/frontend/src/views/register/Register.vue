<template>
    <PageWrapper class="login-page bg-bottom" image="/images/design/stadium_login.jpg">
        <div class="card max-w-lg mx-auto">
            <div class="card-body m-10">
                <h1 class="text-white mb-4">Register</h1>
                <form v-on:submit.prevent="register">
                    <!-- Basic Personal Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <TextInput
                                class="alt"
                                label="First Name"
                                placeholder="First Name"
                                autocomplete="off"
                                v-model="form_data.first_name"
                                :errors="errors.first_name"/>
                        </div>
                        <div>
                            <TextInput
                                class="alt"
                                label="Last Name"
                                placeholder="Last Name"
                                autocomplete="off"
                                v-model="form_data.last_name"
                                :errors="errors.last_name"/>
                        </div>
                    </div>
                    <TextInput
                        class="alt"
                        label="Password"
                        placeholder="Password"
                        type="password"
                        autocomplete="new-password"
                        v-model="form_data.password"
                        :errors="errors.password"/>
                    <ul class="text-sm italic text-red-600 pb-2" v-if="errors.password">
                        <li>Eight characters</li>
                        <li>One capital letter</li>
                        <li>One number</li>
                    </ul>
                    <TextInput
                        class="alt"
                        label="Password Confirmation"
                        placeholder="Password Confirmation"
                        type="password"
                        v-model="form_data.password_confirmation"
                        :errors="errors.password_confirmation"/>
                    <TextInput
                        class="alt"
                        label="Email"
                        placeholder="Email"
                        autocomplete="username"
                        type="email"
                        v-model="form_data.email"
                        :errors="errors.email"/>

                    <!-- Subscription & Cost Information -->
                    <div class="input-wrapper my-4" v-if="plans && plans.length > 1">
                        <label>Plan</label>
                        <select v-model="form_data.plan_id" aria-label="Subscription Tier">
                            <option disabled value="" prompt="">Please select a subscription</option>
                            <option v-for="plan in plans" :value="plan.id" :key="plan.id">{{plan.name}}</option>
                        </select>
                    </div>

                    <PaymentForm v-if="require_cc" v-on:setup="handlePaymentSetup" class="input-wrapper my-4"></PaymentForm>

                    <CouponForm v-on:coupon-added="updateCoupon" v-on:remove-coupon="removeCoupon"/>

                    <BooleanConsent v-model="form_data.consent_given" :errors="errors.consent_given">
                        I agree to the <router-link class="accent" :to="{name: 'privacy-policy'}">Privacy Policy</router-link>, the <router-link class="accent" :to="{name: 'terms-of-use'}">Terms of Use</router-link>, and the <router-link class="accent" :to="{name:'fulfillment-policy'}">Fulfillment Policy</router-link>.
                    </BooleanConsent>

                    <button class="my-4" type="submit">
                        Register
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </PageWrapper>
</template>
<script>
export default {
    name:"Register",
    data() {
        return {
            plans:[],
            errors:{},
            form_data: {
                first_name:"",
                last_name:"",
                password:"",
                password_confirmation:"",
                email:"",
                plan_id:null,
                payment_method:"",
                coupons:null,
                consent_given:null
            },
            stripe:null,
            card:null,
            payment_intent:null,
            setup_intent:null,
            require_cc:false
        }
    },
    computed: {
        name: function() {
            return this.form_data.first_name + " " + this.form_data.last_name;
        }
    },
    mounted() {
        this.form_data.plan_id = parseInt(this.$route.params.planId);
        this.loadPlans();
    },
    methods: {
        updateCoupon(coupon) {
            this.form_data.coupon = coupon;
        },
        removeCoupon() {
            this.form_data.coupon = null;
        },
        handlePaymentSetup(e) {
            this.stripe = e.stripe;
            this.card = e.card;
            this.payment_intent = e.payment_intent;
        },
        register() {
            if(this.setup_intent || !this.require_cc) {
                this.continueRegistration();
            }
            else {
                //First we're going to send Stripe the card information to make sure everythings good their.
                let self = this;
                this.stripe.confirmCardSetup(
                    this.payment_intent,
                    {
                        payment_method: {
                            card: this.card,
                            billing_details: { name: this.name }
                        }
                    }
                ).then(res => {
                    self.setup_intent = res.setupIntent;
                    self.continueRegistration();
                });
            }
        },
        continueRegistration() {
            let self = this;

            //If everything went well with stripe we can now create the new user.
            if(this.require_cc) {
                this.form_data.payment_method = this.setup_intent.payment_method;
            }
            axios.post("api/register", this.form_data).then(res => {
                //Redirect to account
                self.$store.commit("login");
                self.$router.push({
                    name:"next-steps"
                });

                //Fire off GA event
                gtag('event', 'athlete_registration');
            }).catch(error => {
                self.errors = error.response.data.errors;
                self.$noty.error("Something went wrong.");
            });
        },
        loadPlans() {
            let self = this;
            axios.get("api/plan").then(res => {
                self.plans = res.data;
            });
        }
    }
}
</script>
<style scoped>
.override-margin{
    margin-bottom:0px !important;
}
</style>
