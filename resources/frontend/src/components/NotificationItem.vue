<template>
    <div class="icon-item icon-only" v-on:click="setActive('notifications')">
        <i class="fas fa-bell"></i>
        <span v-if="unreadNotifications" class="notif-alert-badge text-white p-1 rounded-full">{{unreadNotifications.length}}</span>
    </div>
</template>
<script>
export default {
    name:"NotificationItem",
    computed: {
        unreadNotifications() {
            let notifications = this.$store.getters.notifications;
            let unread = notifications.filter(notif => !notif.read_at);
            return (unread.length > 0) ? unread : false;
        }
    },
    methods: {
        setActive(selected) {
            this.$emit('selected', 'notifications');
            this.notifications_expanded = true;
        }
    }
}
</script>