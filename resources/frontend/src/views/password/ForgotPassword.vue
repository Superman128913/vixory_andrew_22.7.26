<template>
    <PageWrapper layout="boxed">
        <div class="forgot-password-wrapper">
            <div class="input">
                <TextInput 
                    type="email"
                    v-model="email"
                    :errors="errors.email" 
                    label="Email"/>
            </div>
            <button v-on:click="resetPassword" class="mt-4">Send Password Reset Link</button>
        </div>
    </PageWrapper>
</template>
<script>
export default {
    name:"ForgotPassword",
    data() {
        return {
            email:"",
            errors:[]
        }
    },
    methods: {
        resetPassword(){
            let self = this;

            var payload = {
                email: this.email
            }
            axios.post("password/email", payload).then(res => {
                self.$noty.success("Email Sent");
            }).catch(error => {
                self.$noty.error("Oops, something went wrong!");
                if(error.response.data.errors) {
                    self.errors = error.response.data.errors;
                }
            });
        }
    }
}
</script>