<template>
    <PageWrapper layout="boxed">
        <div class="bg-gray-900 rounded border-gray-alt2 border max-w-2xl m-auto p-8 flex justify-center items-center">
            <p class="p-2">Would you like to reactivate your account?</p>
            <div class="flex p-2">
                <button class="m-2" v-on:click="reactivateAccount">Yes</button>
                <button class="m-2" v-on:click="setDeactivationCookie">No</button>
            </div>
        </div>
    </PageWrapper>
</template>
<script>
export default {
    name:"Deactivated",
    methods: {
        reactivateAccount() {
            //Reactivate the account
            let self = this;
            axios.post("api/user/reactivate").then(res => {
                //The user object returned doesn't have relations loaded, so we need to manually update the is_deactivated flag.
                self.$store.commit('setUserToReactivated');

                //Redirect
                self.$router.push({name:'profile'});
            }).catch(error => {
                self.$noty.error("Oops, something went wrong!");
            });
        },
        setDeactivationCookie() {
            localStorage.setItem('deactivationPass', true);
            this.$router.push({name:'profile'});
        }
    }
}
</script>