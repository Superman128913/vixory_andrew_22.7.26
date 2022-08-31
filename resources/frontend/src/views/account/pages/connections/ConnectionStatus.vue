<template>
    <div>
        <span class="font-bold" v-if="checkStatus(connection) == 'accepted'">
            <i class="fas fa-check"></i>
            <span class="px-1">Accepted</span>
        </span>
        <span class="font-bold" v-else-if="checkStatus(connection) == 'declined'">
            <i class="fas fa-times"></i>
            <span class="px-1">Declined</span>
        </span>
        <span class="font-bold" v-else-if="checkStatus(connection) == 'pending'">
            <i class="fas fa-question"></i>
            <span class="px-1">Pending</span>
        </span>
    </div>
</template>
<script>
export default {
    name:"ConnectionStatus",
    props: {
        connection: Object
    },
    methods: {
        checkStatus(connection) {
            if(connection.accepted) {
                return "accepted";
            }
            else if(connection.deleted_at) {
                return "declined";
            }
            else {
                return "pending";
            }
        },
    }
}
</script>