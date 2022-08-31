<template>
    <div class="my-4 p-4 bg-black border border-gray-alt2 rounded-lg flex flex-col justify-between items-center">
        <div>
            {{connection.sender.name}} <span v-if="connection.sender.college">with {{connection.sender.college.name}}</span> wants to connect with you.
        </div>
        <div class="pb-2 pt-4">
            <button class="mx-2" v-on:click="acceptConnection(connection.id)">Accept</button>
            <button class="mx-2" v-on:click="declineConnection(connection.id)">Deny</button>
        </div>
    </div>
</template>
<script>
//Show this card if the active user is an athlete and they're viewing a connection that they haven't accepted yet.
export default {
    name:"AthletePending",
    props:["connection"],
    methods: {
        acceptConnection(connection_id) {
            this.$emit("accept-connection", connection_id);
        },
        declineConnection(connection_id) {
            this.$emit("decline-connection", connection_id);
        }
    }
}
</script>