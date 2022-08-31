<template>
    <div class="py-4">
        <template v-if="add_card">
            <PaymentForm v-on:setup="handlePaymentSetup" class="input-wrapper my-2"></PaymentForm>
        </template>
        <button class="my-2" v-on:click="handleSubmit">{{button_text}} <span class="text-accent"><i class="fal fa-plus-circle"></i></span></button>
    </div>
</template>
<script>
export default {
    name:"PaymentMethodForm",
    data() {
        return {
            add_card:false,
            stripe:null,
            card:null,
            payment_intent:null,
        }
    },
    computed: {
        button_text() {
            return this.add_card ? "Save Card" : "Add Card";
        }
    },
    methods: {
        handleSubmit() {
            if(! this.add_card) {
                this.add_card = true;
            }
            else {
                this.updatePayment();
            }
        },
        handlePaymentSetup(e) {
            this.stripe = e.stripe;
            this.card = e.card;
            this.payment_intent = e.payment_intent;
        },
        updatePayment() {
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
                //If everything went well with stripe we can now update the payment in the db.
                let payment_method = res.setupIntent.payment_method;
                axios.post("api/billing/payment-method", {payment_method:payment_method}).then(res2 => {
                    self.$emit("payment-updated", res2.data);
                    self.$noty.success("Payment method added!");
                }).catch(error => {
                    self.$noty.error("There was an error adding the card.");
                });

                self.add_card = false;
            });
        }
    }
}
</script>