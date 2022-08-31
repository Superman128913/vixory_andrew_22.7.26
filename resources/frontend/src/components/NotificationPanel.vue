<template>
    <div>
        <div class="p-3 bg-accent text-white rounded-t-md">
            <span>Notifications</span>
        </div>
        <div v-if="notifications.length > 0" class="notification-wrapper block px-4 py-4">

            <!-- Iterate through ALL notifications. -->
            <div v-for="notification in notifications" :key="notification.id" class="rounded-md p-2 my-2 bg-gray-700" :class="{'border-l-2 border-accent' : !notification.read_at}">

                <!-- Saved Search: Not included with other notifications due to param. -->
                <span class="text-accent" v-if="notification.type === 'App\\Notifications\\SavedSearchResults'">
                    <router-link :to="{name: 'saved-search-view', params:{id: notification.data.saved_search.id}}">
                        {{notification.data.broadcast_message}}
                    </router-link>
                </span>

                <!-- All other notifications -->
                <span class="text-accent" v-else>
                    <router-link :to="{name: notification.data.broadcast_route_name}">
                        {{notification.data.broadcast_message}}
                    </router-link>
                </span>

                <!-- Timestamp -->
                <span class="text-white block text-sm">{{formatTimeSince(notification.created_at)}}</span>
            </div>
        </div>
        <div v-else class="p-3">
            0 Notifications
        </div>
    </div>
</template>
<script>
export default {
    name:"NotificationPanel",
    mounted() {
        let self = this;
        axios.post("api/notifications/read/" + this.user.id);
    },
    computed: {
        user() {
            return this.$store.getters.user;
        },
        notifications() {
            return this.$store.getters.notifications;
        }
    }
}
</script>