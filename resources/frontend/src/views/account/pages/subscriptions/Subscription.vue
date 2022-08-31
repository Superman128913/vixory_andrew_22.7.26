<template>
    <!-- Subscriptions Page Wrapper -->
    <div>
        <!-- Option A - Your a founder, other tiers are coming soon -->
        <template v-if="is_founder && ! encourage_upgrade">
            <div class="p-16">
                <p class="text-lg">Thank you for being a part of Vixory as we start our journey! As a founder, you have full access to all of the available features and will be notified as soon as additional plans and features become available.</p>
                <div class="pt-4">
                    <div>Thank You,</div>
                    <div>The Vixory Team</div>
                </div>
            </div>
        </template>

        <!-- Option B - Your a founder, but have to upgrade now -->
        <template v-else-if="is_founder && encourage_upgrade">
            <div class="p-10">
                <p>Upgrade to a paid subscription here.</p>
            </div>
        </template>

        <!-- Option C - Standard subscription -->
        <template v-if="! is_founder">
            <!-- Account Details -->
            <div class="p-10" v-if="details">
                <h1 class="account-header pb-10">Account Details</h1>
                <!-- Plans -->
                <div class="grid grid-cols-12 gap-4">
                    <div v-for="plan in details.plans" :key="plan.id" class="col-span-4">
                        <div class="bg-accent bg-opacity-50 border-2 rounded-lg border-accent text-center">
                            <div class="text-5xl uppercase norwester">{{plan.name}}</div>
                            <div class="font-bold text-lg pb-4">{{formatAsMoney(plan.cost)}}</div>
                            <hr class="border-accent border-1">
                            <button v-on:click="changePlan(plan.id)" class="plain my-2" style="margin:auto !important">{{planChangeText(plan)}}</button>
                        </div>
                    </div>
                </div>

                <hr class="mb-10 mt-12">

                <!-- Payment Methods -->
                <div v-for="method in details.payment_methods" :key="method.id" class="flex items-center">

                    <!-- Card Delete Icon -->
                    <span v-if="details.default_method != method.id && details.payment_methods.length > 2" class="text-sm cursor-pointer" v-on:click="removePaymentMethod(method)">Remove</span>

                    <!-- Card Icon -->
                    <CardIcon :brand="method.card.brand" /> 
                    <div class="p-4 flex items-center w-full max-w-lg justify-between">
                        <!-- Card Details -->
                        <div class="flex">
                            <div>
                                {{method.card.brand | capitalize}} •••• {{method.card.last4}} 
                                <p class="text-white italic tracking-widest">Expires {{method.card.exp_month + "/" + method.card.exp_year}}</p>
                            </div>
                            <div class="px-4">
                                <span v-if="details.default_method == method.id" class="tag bg-blue">Primary</span>
                            </div>
                        </div>
                        <div 
                            v-if="details.default_method != method.id" 
                            class="mx-2 lg:mx-10 text-accent tracking-widest cursor-pointer uppercase block" 
                            v-on:click="setAsPrimary(method)">
                            Make Primary >
                        </div>
                    </div>
                </div>
                <PaymentMethodForm v-on:payment-updated="updatePayment"/>
            </div>
            <hr>
            <div class="p-10">
                <!-- Invoice List -->
                <h2 class="account-header pb-4">Payments</h2>
                <div class="card-table">
                    <div class="">
                        <table>
                            <thead class="hidden">
                                <tr>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="payment in payments" :key="payment.id">
                                    <td>{{formatAsMoney(payment.total)}}</td>
                                    <td>
                                        <span v-if="payment.status == 'paid'" class="tag bg-green">Paid</span>
                                        <span v-else class="tag bg-yellow-500">Unpaid</span>
                                    </td>
                                    <td class="uppercase">{{formatUnixAsReadable(payment.period_start)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Additional Account Actions -->
                <div class="text-right">
                    <button class="my-6" v-on:click="showCancelPrompt">Cancel Account</button>
                    <Modal ref="modal" title="Are you sure you want to delete your account?" action_text="Yes I'm Sure" v-on:action-completed="cancelAccount">
                        <p>If you'd like you can switch to a free tier and enjoy all of the features included in the free tier without spending anything!</p>
                    </Modal>
                </div>
            </div>
        </template>
    </div>
</template>
<script>
export default {
    name:"Subscription",
    data() {
        return {
            change_plans:false,
            details:null,
            payments:{},
            encourage_upgrade: false, //Set to true whenever we want to transition founders to a paid role.
        }
    },
    computed: {
        is_founder() {
            return this.hasRole("founder");
        }
    },
    mounted() {
        this.getBillingInformation();
        this.getPayments();
    },
    methods: {
        cancelAccount() {
            let self = this;
            axios.delete("api/user").then(res => {
                self.$noty.success("Account deleted, redirecting to home...");
                
                //Wait for a moment and then redirect to the homepage.
                setTimeout(() => { 
                    self.$router.push({ name: 'home' });
                 }, 1000);
            }).catch(error => {
                self.$noty.error("An error occured");
            });
        },
        showCancelPrompt() {
            //Prompt the user to make sure they don't just want to switch to a free account.
            this.$refs.modal.toggleModal();
        },
        setAsPrimary(method) {
            let self = this;
            axios.post("api/billing/payment-method/primary", {payment_method:method.id})
            .then(res => {
                self.details.default_method = method.id;
                self.$noty.success("Updated");
            }).catch(error => {
                self.$noty.error("An error occured");
            });
        },
        removePaymentMethod(method) {
            let self = this;
            axios.delete("api/billing/payment-method/" + method.id)
            .then(res => {
                let paymentIndex = self.details.payment_methods.findIndex(imethod => imethod.id == method.id);
                self.details.payment_methods.splice(paymentIndex, 1);
                self.$noty.success("Payment removed");
            }).catch(error => {
                self.$noty.error("An error occured");
            });
        },
        updatePayment(payment_methods) {
            this.details.payment_methods = payment_methods;
        },
        getBillingInformation() {
            let self = this;
            axios.get("api/billing/details").then(res => {
                self.details = res.data;
            }).catch(error => {
                self.$noty.error("Could not retrieve payments.");
            });  
        },
        getPayments() {
            let self = this;
            axios.get("api/billing/payments").then(res => {
                self.payments = res.data;
            }).catch(error => {
                self.$noty.error("Could not retrieve payments.");
            });
        },
        planChangeText(plan) {
            if(this.details.active_plan.id == plan.id) {
                return "Current Plan";
            }
            else {
                return plan.cost > this.details.active_plan.cost ? "Upgrade" : "Downgrade";
            }
        },
        changePlan(plan_id) {
            //Downgrade or Upgrade the plan
            let self = this;
            axios.patch("api/billing/subscription/" + plan_id).then(res => {
                self.details.active_plan = res.data;
                self.$noty.success("Plan Updated");
            }).catch(error => {
                self.$noty.error("Something went wrong");
            });
        }
    }
}
</script>