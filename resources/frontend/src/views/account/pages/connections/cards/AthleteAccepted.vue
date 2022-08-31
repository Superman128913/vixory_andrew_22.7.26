<template>
    <div class="bg-black border border-gray-alt2 rounded-lg">
        <div class="p-4">
            <p class="text-accent text-2xl">{{connection.sender.name}}</p>
            <a  v-if="connection.sender.email" class="block" :href="'mailto:' + connection.sender.email">
                <span class="standard-icon">
                    <i class="fas fa-envelope"></i>
                </span>
                {{connection.sender.email}}
            </a>
            <a v-if="connection.sender.phone_number" class="block" :href="'tel:' + connection.sender.phone_number">
                <span class="standard-icon">
                    <i class="fas fa-phone"></i>
                </span>
                {{connection.sender.phone_number}}
            </a>
            <p v-if="userHasRole({specifiedRoles:'pro_scout', user: connection.sender})">
                <span class="standard-icon">
                    <i class="fas fa-trophy"></i>
                </span>
                {{connection.sender.pro_team_name}}
            </p>
            <p v-else-if="userHasRole({specifiedRoles:'coach', user: connection.sender}) && connection.sender.college">
                <span class="standard-icon">
                    <i class="fas fa-university"></i>
                </span>
                {{connection.sender.college.name}}
            </p>
        </div>
        <hr>
        <div class="p-4 text-center">
            <ConnectionStatus :connection="connection"/>
        </div>
    </div>
</template>
<script>
//Show this card if the active user is an athlete and they're viewing a sender that they accepted.
export default {
    name:"AthleteAccepted",
    props:["connection"]
}
</script>