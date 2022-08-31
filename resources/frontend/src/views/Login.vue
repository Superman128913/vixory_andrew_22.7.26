<template>
    <PageWrapper class="login-page bg-bottom" image="/images/design/stadium_login.jpg">
        <div class="login-form-wrapper grid grid-cols-2 mx-auto max-w-4xl">
            <!-- Form -->
            <div class="form-col col-span-2 md:col-span-1 p-10 mt-8 relative rounded-lg md:rounded-l-lg md:rounded-r-none border-accent border-b-4 flex items-center">
                <div>
                    <h1 class="text-white">Log In</h1>
                    <div class="text-accent mt-2 mb-6 text-lg">Welcome back!</div>

                    <AccentMark width="100%" class="bg-gray-alt2"/>

                    <form v-on:submit.prevent="login">
                        <TextInput 
                            class="alt" 
                            label="Email" 
                            placeholder="Email" 
                            type="email" 
                            :settings="{labels:'hidden'}" 
                            v-model="email" 
                            :errors="errors.email"/>
                        <TextInput 
                            class="alt" 
                            label="Password" 
                            placeholder="Password" 
                            type="password" 
                            :settings="{labels:'hidden'}" 
                            v-model="password" 
                            :errors="errors.password"/>

                        <button type="submit">
                            Sign In
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        <router-link :to="{name: 'forgot-password'}" class="text-gray-alt1 px-4">Forgot Password?</router-link>
                    </form>
                </div>
            </div>

            <!-- Sports Player -->
            <div class="col-span-1 relative hidden md:flex">
                <img class="player-image" style="position:relative;left:-44px;" src="/images/design/basketball-login.png"/>
            </div>
        </div>
    </PageWrapper>
</template>
<script>
export default {
    name:"Login",
    data() {
        return {
            email:'',
            password:'',
            errors:[]
        }
    },
    methods: {
        login() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                var payload = {
                    email:this.email,
                    password:this.password
                }

                let self = this;
                axios.post("login", payload).then(res => {
                    self.$store.commit("login");
                    self.$router.push({name:'profile'});
                }).catch(error => {
                    self.$noty.error("Oops, something went wrong.");
                    self.errors = error.response.data.errors;
                });
            });
        }
    }
}
</script>
<style>
.login-form {
    min-height: 30em;
}
.form-col {
    background-color: rgba(0,0,0, .55);  
    backdrop-filter: blur(9px);
}
</style>