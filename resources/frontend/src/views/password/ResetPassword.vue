<template>
    <PageWrapper layout="boxed">
        <div class="reset-password-wrapper">
            <TextInput 
                class="my-4"
                type="email"
                v-model="form.email"
                :errors="errors.email" 
                label="Email"/>
            <TextInput 
                class="my-4"
                type="password"
                v-model="form.password"
                :errors="errors.password" 
                label="Password"/>
            <TextInput 
                class="my-4"
                type="password"
                v-model="form.password_confirmation"
                :errors="errors.password_confirmation" 
                label="Password Confirmation"/>
            <button class="my-4" v-on:click="resetPassword">Reset Password</button>
        </div>
    </PageWrapper>
</template>
<script>
export default {
    name:"ResetPassword",
    data() {
        return {
            form: {
                email:"",
                password:"",
                password_confirmation:"",
                token:this.$route.query.token,
            },
            errors:[]
        }
    },
    methods: {
        resetPassword() {
            let self = this;
            axios.post("password/reset", this.form).then(res => {
                self.$noty.success("Password Reset")
                this.$router.push({name:'login'});
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
