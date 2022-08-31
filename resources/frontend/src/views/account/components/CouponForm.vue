<template>
    <div class="coupon-form-wrapper">
        <label>Add Promotional Code</label>
        <div v-if="coupon_code" class="flex coupon-item">
            <span>#{{coupon_code}}</span>

            <span v-on:click="removeCoupon" class="remove-coupon text-gray-places mx-2 cursor-pointer">
                <i class="fas fa-minus-circle"></i>
            </span>
        </div>
        <div class="input-wrapper" v-else>
            <div class="flex">
                <input type="text" v-model="current_code">
                <div v-on:click="addCoupon" class="text-gray-places mx-2 justify-center self-center cursor-pointer">
                    <i class="fas fa-plus-circle"></i>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name:"CouponForm",
    data() {
        return {
            current_code:"",
            coupon_code:""
        }
    },
    methods: {
        addCoupon() {
            if(this.current_code !== this.coupon_code) {
                this.checkValidity();
            }
            else {
                this.$noty.error("Coupon code already added.");
                this.current_code = "";
            }
        },
        checkValidity() {
            //Check validity of coupon
            let self = this;
            let payload = {
                coupon_code: this.current_code,
            }
            axios.post("api/coupon/check-validity", payload).then(res => {
                if(res.data.success) {
                    //Add to coupons array
                    self.coupon_code = this.current_code;

                    //Clear text field
                    self.current_code = "";

                    //Emit event with list of coupon codes.
                    self.$emit("coupon-added", this.coupon_code);
                }
                else {
                    self.$noty.error("Invalid coupon code.");
                    self.current_code = "";
                }
            }).catch(error => {
                self.$noty.error("Oops, something went wrong!");
            });
        },
        removeCoupon() {
            //Remove coupon from list
            this.coupon_code = "";
            this.$emit("remove-coupon");
        }
    }
}
</script>
<style scoped>
    .coupon-form-wrapper {
        padding-top:0.5rem;
        padding-top:0.5rem;
    }
</style>