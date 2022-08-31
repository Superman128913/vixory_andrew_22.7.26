<template>
    <div class="bg-black border border-gray-alt2 rounded-lg">
        <div class="p-4">
            <p class="text-accent text-2xl">{{connection.athlete.name}}</p>
            <a v-if="connection.athlete.phone_number" class="block" :href="'tel:' + connection.athlete.phone_number">
                <span class="standard-icon">
                    <i class="fas fa-phone"></i>
                </span>
                {{connection.athlete.phone_number}}
            </a>
            <a v-if="connection.athlete.email" class="block" :href="'mailto:' + connection.athlete.email">
                <span class="standard-icon">
                    <i class="fas fa-envelope"></i>
                </span>
                {{connection.athlete.email}}
            </a>
            <router-link :to="{name:'social-profile', params: {id: connection.athlete.id}}">
                <span class="standard-icon">
                    <i class="fas fa-address-card"></i>
                </span>
                Profile Page
            </router-link>
            <p v-if="connection.athlete.city && connection.athlete.state_name">
                <span class="standard-icon">
                    <i class="fas fa-map-marker"></i>
                </span>
                {{connection.athlete.city}}, {{connection.athlete.state_name}}
            </p>
        </div>
        <hr>
        <div class="p-4 text-center">
            <ConnectionStatus :connection="connection"/>
        </div>
    </div>
</template>
<script>
//Show this card if the user is a coach and they're viewing an athlete who accepted the request.
export default {
    name:"CoachAccepted",
    props:["connection"]
}
</script>