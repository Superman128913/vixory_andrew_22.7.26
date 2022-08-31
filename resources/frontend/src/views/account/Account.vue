<template>
    <PageWrapper image="/images/design/stadium_login.jpg" layout="boxed">
        <div class="account-wrapper mt-10 mb-20 mx-2 md:mx-4">
        
            <!-- Tab Menu -->
            <div class="tab-wrapper grid grid-cols-12 gap-4">
                <div class="sub-menu col-span-12 md:col-span-4">
                    <div class="tabs rounded bg-black border-2 border-gray-alt2">
                        <div v-if="user" class="pt-8 pb-2  text-center text-accent text-2xl font-bold">
                            {{user.name}}
                        </div>

                        <!-- Share Profile Link -->
                        <div 
                            id="profile-url" 
                            v-clipboard:copy="user_profile" 
                            v-clipboard:success="onCopy"
                            class="px-2 pb-2 text-center cursor-pointer" 
                            v-if="user && user_profile && !isAthleticRecruiter()">
                            <span class="text-sm text-accent">
                                <i class="far fa-clipboard"></i>
                            </span>
                            <span class="px-2 text-gray-500 tracking-widest">
                                {{user_profile}}
                            </span>
                        </div>

                        <!-- Tabs -->
                        <ul class="m-0 py-4">
                            <router-link 
                                :to="{name: page.name}" 
                                v-for="page in pages" 
                                class="p-5 text-gray-600 cursor-pointer text-center m-0 border-t-2 border-gray-alt2"
                                tag="li" 
                                :key="page.name"
                                :class="{ 'is-active': page.selected }">

                                <template v-if="page.icon">
                                    <span class="text-accent">
                                        <i :class="page.icon"></i>
                                    </span>
                                </template>
                                <span class="ml-3 uppercase tracking-widest">
                                    {{page.label}}
                                </span>                        
                            </router-link>
                        </ul>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="tab-details relative col-span-12 md:col-span-8 bg-black rounded border-2 border-gray-alt2">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </PageWrapper>
</template>
<script>
export default {
    name:"Account",
    data() {
        return {
            athlete_menu: [
                {
                    label:"Basic Information",
                    name:"profile",
                    icon:"fas fa-user",
                    selected:true,
                },
                {
                    label:"Sports Data",
                    name:"sports-data",
                    icon:"fas fa-running",
                    selected:false
                },
                {
                    label:"Connections",
                    name:"connections",
                    icon:"fas fa-address-book",
                    selected:false
                },
                {
                    label:"Articles",
                    name:"articles",
                    icon:"fas fa-newspaper",
                    selected:false
                },
                {
                    label:"Videos",
                    name:"videos",
                    icon:"fas fa-video",
                    selected:false
                },
                {
                    label:"Subscription",
                    name:"subscription",
                    icon:"fas fa-money-check-alt",
                    selected:false
                },
            ],
            coach_menu: [
                {
                    label:"Profile Information",
                    name:"profile",
                    icon:"fas fa-id-badge"
                },
                {
                    label:"Connections",
                    name:"connections",
                    icon:"fas fa-address-book"
                },
                {
                    label:"Saved Searches",
                    name:"saved-searches",
                    icon:"fas fa-search-plus"
                }
            ],
            show_profile_link:false
        }
    },
    computed: {
        pages() {
            return this.hasRole("coach,pro_scout") ? this.coach_menu : this.athlete_menu
        },
        user() {
            return this.$store.getters.user;
        },
        user_profile() {
            return this.getBaseUrl() + "/profile/" + this.user.id
        }
    },
    watch: {
        user() {
            this.checkDeactivation();
            this.pendingApproval();
        }
    },
    mounted() {
        this.checkDeactivation();
        this.pendingApproval();
    },
    methods: {
        onCopy() {
            this.animateCSS('#profile-url', 'bounce');
        }
    }
}
</script>
<style scoped>
ul {
    max-width:100%;
}
</style>