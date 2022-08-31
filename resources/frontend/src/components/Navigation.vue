<template>
    <div class="nav-wrapper" v-if="loaded">
        <div class="top-gradient"></div>

        <!-- Desktop Nav -->
        <div class="hidden lg:flex absolute w-full flex items-center justify-between py-6 px-10 z-10">
            <!-- LOGO -->
            <div class="branding">
                <router-link :to="{name: 'home'}">
                    <img
                        class="logoimage" 
                        alt="Logo" 
                        src="/images/logo/0.5x/vixory-horizontal-white@0.5x.png"/>
                </router-link>
            </div>

            <!-- Menu Items -->
            <div v-if="! logged_in" class="flex-1 flex justify-between px-10 max-w-xl">
                <template v-for="item in menu_items">
                    <router-link v-if="!item.external" :to="{ name: item.to}" :key="item.name" class="nav-item">
                        {{item.name}}
                    </router-link>
                    <a v-else class="nav-item" :href="item.to" target="_blank">{{item.name}}</a>
                </template>
            </div>

            <!-- Right Section -->
            <div>
                <template v-if="logged_in && !pendingApproval">
                    <QuickLinks/>
                </template>
                <template v-else>
                    <div class="self-center flex cursor-pointer rounded border border-accent rounded-full px-2">
                        <router-link :to="{ name: 'register-plans' }">Sign Up</router-link>
                        <span class="bg-accent mx-2" style="width:1px;"></span>
                        <router-link :to="{ name: 'login' }">Log In</router-link>
                    </div>
                </template>
            </div>
        </div>

        <!-- Mobile Nav -->
        <div class="flex lg:hidden z-10 relative">
            <div class="absolute w-full justify-between p-4 flex items-center">
                <!-- LOGO -->
                <div class="branding">
                    <router-link :to="{name: 'home'}">
                        <img
                            class="logoimage" 
                            alt="Logo" 
                            src="/images/logo/0.5x/vixory-horizontal-white@0.5x.png"/>
                    </router-link>
                </div>

                <!-- RIGHT HAND ITEMS -->
                <div class="flex items-center nav-item" v-on-clickaway="away">
                    <NotificationItem v-on:selected="setActive"/>

                    <!-- Notification Dropdown -->
                    <div class="notifications-panel-outer-wrapper w-64 mx-6 absolute right-0 bg-gray-800 rounded-md" v-if="selected === 'notifications'">
                        <NotificationPanel/>
                    </div>

                    <!-- Mobile Nav Icon -->
                    <div class="text-2xl cursor-pointer mx-2" v-on:click="toggleMenu">
                        <i class="fas fa-bars"></i>
                    </div>
                </div>
            </div>

            <!-- Mobile Nav Menu Items -->
            <div v-if="expanded" class="h-screen fixed left-0 top-0 w-full bg-black z-30 overflow-hidden">
                <div class="my-16 block relative">
                    <!-- LOGO -->
                    <div class="branding px-4 py-4">
                        <router-link :to="{name: 'home'}">
                            <img
                                class="logoimage mx-auto" 
                                alt="Logo" 
                                src="/images/logo/0.5x/vixory-horizontal-white@0.5x.png"/>
                        </router-link>
                    </div>


                    <div class="flex items-center justify-center">
                        <ul class="mx-4 my-2">
                            <!-- Logged in items -->
                            <template v-for="item in logged_in_menu_items">
                                <li v-if="logged_in && (!item.permission || userCan(item.permission))" :key="item.name" class="text-center p-4">
                                    <router-link v-if="!item.external" :to="{ name: item.to, params: item.params }" class="nav-item">
                                        {{item.name}}
                                    </router-link>

                                    <a v-else class="nav-item" :href="item.to" target="_blank">{{item.name}}</a>
                                </li>            
                            </template>

                            <!-- Logged out items -->
                            <template v-for="item in menu_items">
                                <li v-if="!logged_in" :key="item.name" class="text-center p-4">
                                    <router-link v-if="!item.external" :to="{ name: item.to }" class="nav-item">
                                        {{item.name}}
                                    </router-link>
                                    <a v-else class="nav-item" :href="item.to" target="_blank">{{item.name}}</a>
                                </li>
                            </template>

                            <li class="text-center p-4" v-if="! logged_in">
                                <router-link :to="{ name: 'register-plans' }">Sign Up</router-link>
                            </li>
                            <li class="text-center p-4" v-if="! logged_in">
                                <router-link :to="{ name: 'login' }">Log In</router-link>
                            </li>
                            <li class="text-center p-4 cursor-pointer" v-if="logged_in" v-on:click="signout()">
                                <span>Sign Out</span>
                            </li>
                            <li class="text-center p-4 text-3xl font-thin" v-on:click="toggleMenu">
                                <i class="far fa-times-circle"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</template>
<script>
import { mixin as clickaway } from 'vue-clickaway';
export default {
    name:"Navigation",
    mixins: [ clickaway ],
    computed: {
        logged_in(){
            return this.$store.state.user.logged_in;
        },
        pendingApproval: {
            get() {
                return this.$store.getters.isPendingApproval;
            },
            set() {}
        },
        user() {
            return this.$store.getters.user;
        }
    },
    mounted() {
        this.loaded = true;
    },
    data() {
        return {
            loaded:false,
            expanded:false,
            selected:"",
            logged_in_menu_items: [
                {
                    name:"Search",
                    permission:"perform_user_search",
                    to:"search",
                    active:this.isActive
                },
                {
                    name:"Account",
                    to:"profile",
                    active:this.isActive
                },
                {
                    name:"Profile",
                    to:"social-profile",
                    active:this.isActive
                },
                {
                    name:"FAQ",
                    to:"faq",
                    active: this.isActive
                },
                {
                    name:"Apparel",
                    to:"https://vixory.qbstores.com/home",
                    external: true,
                    active: this.isActive
                }
            ],
            menu_items: [
                {
                    name:"Home",
                    to:"home",
                    active: this.isActive
                },
                {
                    name:"About",
                    to:"about",
                    active: this.isActive
                },
                {
                    name:"FAQ",
                    to:"faq",
                    active: this.isActive
                },
                {
                    name:"Apparel",
                    to:"https://vixory.qbstores.com/home",
                    external: true,
                    active: this.isActive
                },
                {
                    name:"Blog",
                    to:"blog",
                    active: this.isActive
                },
                {
                    name:"Register",
                    to:"register-plans",
                    active: this.isActive
                }
            ]
        }
    },
    watch: {
        '$route' (to, from) {
            this.expanded = false;
        },
        user(user) {
            let socialIndex = this.logged_in_menu_items.findIndex(item => item.to == 'social-profile');
            this.logged_in_menu_items[socialIndex].params = {
                id: user.id 
            }
        }
    },
    methods: {
        toggleMenu() {
            this.expanded = !this.expanded;
        },
        isActive() {
            return true;
        },
        setActive(selected) {
            this.selected = selected;
        },
        away() {
            this.selected = "";
            this.expanded = false;
        }
    }
}
</script>
<style lang="scss">
.nav-item {
    @apply py-1 text-white self-center;

    padding-right:1em;
    padding-left:1em;
}
.nav-item.router-link-exact-active {
    @apply border-accent border-b-2;
}
.notifications-panel-outer-wrapper {
    top:70px;
}
</style>