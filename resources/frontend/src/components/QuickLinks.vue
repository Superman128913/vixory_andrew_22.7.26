<template>
    <div class="nav-item relative" v-on-clickaway="away">
        <div class="flex">
            <div class="icon-item w-auto px-4" v-if="canPerformUserSearch">
                <router-link :to="{name: 'search'}">
                    Search
                    <i class="fas fa-search"></i>
                </router-link>
            </div>
            <div class="icon-item icon-only" v-on:click="setActive('quick-links')">
                <i class="fas fa-user"></i>
            </div>
            <NotificationItem v-on:selected="setActive"/>
            <router-link :to="{name: 'faq'}">
                <div class="icon-item icon-only">
                    <i class="fas fa-question"></i>
                </div>
            </router-link>
        </div>

        <!-- Dropdown Panel -->
        <div class="rounded-md my-4 mx-1 bg-gray-800 text-white absolute right-0" v-if="expanded">
            <!-- Quick Links -->
            <div v-if="selected === 'quick-links'">
                <div class="bg-accent p-3 flex rounded-t-md items-center">
                    <div v-if="user && user.profile_image" class="block h-10 w-10 rounded-full overflow-hidden profile-image">
                        <img 
                            class="h-full w-full object-cover"
                            :src="user.profile_image"/>
                    </div>
                    <span class="text-white p-3 font-bold whitespace-no-wrap" :class="{'w-full mx-4 text-center':isAthleticRecruiter}">{{user.name}}</span>
                </div>

                <!-- Account Links -->
                <div class="py-2 text-center">

                    <div class="w-full flex items-center justify-center px-2">
                        <span class="text-accent px-2">
                            <i class="fas fa-cog"></i>
                        </span>
                        <router-link :to="{ name: 'profile' }" class="block px-2 py-2">Account</router-link>
                    </div>

                    <template v-if="! isAthleticRecruiter(user)">
                        <hr class="border-gray-900">
                        <div class="w-full flex items-center justify-center px-2">
                            <span class="text-accent px-2">
                                <i class="far fa-address-card"></i>
                            </span>
                            <router-link :to="{ name: 'social-profile', params: {id: this.user.id} }" class="block px-2 py-2">Profile</router-link>
                        </div>
                    </template>

                    <hr class="border-gray-900">
                    <div class="w-full flex items-center justify-center px-2">
                        <span class="text-accent px-2">
                            <i class="fas fa-sign-out"></i>
                        </span>
                        <a href="#" class="block px-2 py-2" v-on:click="signout()">Sign Out</a>
                    </div>


                </div>
            </div>

            <!-- Notifications Panel -->
            <div class="notifications-panel-outer-wrapper w-64" v-if="selected === 'notifications'">
                <NotificationPanel/>
            </div>
        </div>
    </div>
</template>
<script>
import { mixin as clickaway } from 'vue-clickaway';
export default {
    name:"QuickLinks",
    mixins: [ clickaway ],
    data() {
        return {
            expanded: false,
            selected: ""
      }
    },
    computed: {
        user() {
            return this.$store.getters.user;
        },
        pendingApproval: {
            get() {
                return this.$store.getters.isPendingApproval;
            },
            set(){}
        },
        canPerformUserSearch() {
            return this.userCan("perform_user_search");
        }
    },
    methods: {
        setActive(selected) {
            this.selected = selected;
            this.expanded = true;
        },
        away() {
            this.selected = "";
            this.expanded = false;
        }
    }
}
</script>
<style scoped>
.profile-image {
    min-width:40px;
}
</style>