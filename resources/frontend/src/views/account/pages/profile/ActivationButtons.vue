<template>
    <div>
        <button 
            class="gray" 
            v-if="is_deactivated" 
            v-on:click="activateAccount">Activate</button>
        <button class="gray" 
            v-else 
            v-on:click="deactivateAccount">Deactivate Account</button>
    </div>
</template>
<script>
//Note: Very similar functionality exists in the Deactivated page.
export default {
    name:"ActivationButtons",
    computed: {
        user() {
            return this.$store.getters.user
        }
    },
    data() {
        return {
            is_deactivated:false
        }
    },
    watch: {
        user: {
            handler: function (user) {
                this.is_deactivated = user.is_deactivated;
            },
            deep: true,
            immediate: true
        },
    },
    methods: {
        deactivateAccount() {
            let self = this;
            axios.post("api/user/deactivate").then(res => {
                //Set the localStorage variable
                localStorage.setItem('deactivationPass', true);
                
                //The user object returned doesn't have relations loaded, so we need to manually update the is_deactivated flag.
                self.$store.commit('setUserToDeactivated');
            }).catch(error => {
                self.$noty.error("Unknown Error");
            });
        },
        activateAccount() {
            let self = this;
            axios.post("api/user/reactivate").then(res => {
                //Clear the localStorage variable if it exists.
                localStorage.removeItem('deactivationPass');

                //The user object returned doesn't have relations loaded, so we need to manually update the is_deactivated flag.
                self.$store.commit('setUserToReactivated');
            }).catch(error => {
                self.$noty.error("Oops, something went wrong!");
            });
        }
    }
}
</script>