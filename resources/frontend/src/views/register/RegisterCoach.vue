<template>
    <PageWrapper class="login-page bg-bottom" image="/images/design/stadium_login.jpg">
        <div class="card max-w-lg mx-auto">
            <div class="card-body m-10">
                <h1 class="text-white mb-4">Register</h1>
                <form v-on:submit.prevent="register">
                    <div class="input-wrapper alt">
                        <select v-model="form_data.user_type">
                            <option value="coach">Coach</option>
                            <option value="pro_scout">Pro Scout</option>
                        </select>
                    </div>

                    <CollegeSearch
                        class="alt"
                        v-if="form_data.user_type == 'coach'"
                        v-model="form_data.college"
                        label="College"/>
                    <ErrorDisplay :errors="errors.college"/>

                    <div v-if="form_data.user_type != 'coach'">
                        <TextInput
                            class="alt"
                            label="Pro Team Name"
                            placeholder=""
                            v-model="form_data.pro_team_name"
                            :errors="errors.pro_team_name"/>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-0 md:gap-4">
                        <div>
                            <TextInput
                                class="alt"
                                label="First Name"
                                placeholder="First Name"
                                v-model="form_data.first_name"
                                :errors="errors.first_name"
                                autocomplete="off"/>
                        </div>
                        <div>
                            <TextInput
                                class="alt"
                                label="Last Name"
                                placeholder="Last Name"
                                v-model="form_data.last_name"
                                :errors="errors.last_name"
                                autocomplete="off"/>
                        </div>
                    </div>

                    <TextInput
                        class="alt"
                        label="Password"
                        placeholder="Password"
                        autocomplete="new-password"
                        type="password"
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
                        autocomplete="off"
                        type="email"
                        v-model="form_data.email"
                        :errors="errors.email"/>

                    <CouponForm v-on:coupon-added="updateCoupon" v-on:remove-coupon="removeCoupon"/>

                    <BooleanConsent v-model="form_data.consent_given" :errors="errors.consent_given">
                        I agree to the <router-link class="accent" :to="{name: 'privacy-policy'}">Privacy Policy</router-link>, the <router-link class="accent" :to="{name: 'terms-of-use'}">Terms of Use</router-link>, and the <router-link class="accent" :to="{name:'fulfillment-policy'}">Fulfillment Policy</router-link>.
                    </BooleanConsent>

                    <button class="my-4" type="submit">Register</button>
                </form>
            </div>
        </div>
    </PageWrapper>
</template>
<script>
export default {
    name:"RegisterCoach",
    data() {
        return {
            errors:{},
            plans:[],
            form_data: {
                user_type:"coach",
                college:null,
                pro_team_name:"",
                first_name:"",
                last_name:"",
                password:"",
                password_confirmation:"",
                email:"",
                coupons:null,
            }
        }
    },
    computed: {
        name: function() {
            return this.form_data.first_name + " " + this.form_data.last_name;
        }
    },
    methods: {
        updateCoupon(coupon) {
            this.form_data.coupon = coupon;
        },
        removeCoupon() {
            this.form_data.coupon = null;
        },
        register() {
            //First we're going to send Stripe the card information to make sure everythings good their.
            let self = this;
            axios.post("register", this.form_data).then(res => {
                    //Redirect to account
                    self.$store.commit("login");
                    self.$router.push({
                        name:"profile"
                    })

                    //Fire off the GA event
                    gtag('event', 'coach_registration');
                }).catch(error => {
                    self.errors = error.response.data.errors;
                });
        }
    }
}
</script>
