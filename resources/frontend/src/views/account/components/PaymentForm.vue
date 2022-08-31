<template>
    <div class="form-row">
        <label for="card-element">
        Credit or debit card
        </label>
        <div id="card-element">
            <!-- A Stripe Element will be inserted here. -->
        </div>

        <!-- Used to display form errors. -->
        <div id="card-errors" role="alert"></div>
    </div>
</template>
<script>
export default {
    name:"PaymentForm",
    data() {
        return {
            stripe:null,
            card:null,
            payment_intent:null,
            stripe_key: process.env.VUE_APP_STRIPE_KEY || ""
        }
    },
    mounted() {
        //Load the stripe script. Check for a script with an id set to prevent loading the same script multiple times.
        if(! document.querySelector("#stripeScript")) {
            
            let stripeScript = document.createElement('script');
            stripeScript.setAttribute('src', 'https://js.stripe.com/v3/');
            stripeScript.setAttribute('id', 'stripeScript');
            document.head.appendChild(stripeScript);
        
            //Setup the payment field after it's loaded
            let self = this;
            stripeScript.onload = () => {
                self.getPaymentIntent();
            };
        }
        else {
            this.getPaymentIntent();
        }
    },
    methods: {
        getPaymentIntent() {
            let self = this;
            axios.get("api/payment-intent").then(res => {
                self.payment_intent = res.data.client_secret;
            }).then(res => {
                self.setupPaymentField();
            });
        },
        setupPaymentField() {
            // Create a Stripe client.
            this.stripe = Stripe(this.stripe_key);

            // Create an instance of Elements.
            var elements = this.stripe.elements();

            // Custom styling can be passed to options when creating an Element.
            var style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                    color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };

            // Create an instance of the card Element.
            this.card = elements.create('card', {style: style});

            // Add an instance of the card Element into the `card-element` <div>.
            this.card.mount('#card-element');

            //Handle real-time validation errors from the card Element
            this.card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            var eventPayload = {
                payment_intent: this.payment_intent,
                stripe: this.stripe,
                card: this.card
            };
            this.$emit('setup', eventPayload);
        }
    }
}
</script>
<style scoped>
/**
 * The CSS shown here will not be introduced in the Quickstart guide, but shows
 * how you can use CSS to style your Element's container.
 */
.StripeElement {
  box-sizing: border-box;

  height: 40px;

  padding: 10px 12px;

  border: 1px solid transparent;
  border-radius: 4px;
  background-color: white;

  box-shadow: 0 1px 3px 0 #e6ebf1;
  -webkit-transition: box-shadow 150ms ease;
  transition: box-shadow 150ms ease;
}

.StripeElement--focus {
  box-shadow: 0 1px 3px 0 #cfd7df;
}

.StripeElement--invalid {
  border-color: #fa755a;
}

.StripeElement--webkit-autofill {
  background-color: #fefde5 !important;
}
</style>