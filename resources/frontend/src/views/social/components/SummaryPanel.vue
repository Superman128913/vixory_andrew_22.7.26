<template>
    <div v-if="user" class="bg-black my-6 rounded border-gray-alt2 border">
        <h3 class="p-4 minor-heading">
            <span class="text-accent">
                <i class="fas fa-info-circle"></i>
            </span>
            <span class="px-2">Player Info</span>
        </h3>
        <hr>
        <p class="p-4" v-if="user.profile_description">{{user.profile_description}}</p>
        <p class="p-4 text-center italic" v-else>Description Not Set</p>
    </div>
</template>
<script>
export default {
    name:"",
    props: {
        user:Object
    },
    data() {
        return {

        }
    },
    mounted() {
        
    },
    methods: {

    }
}
</script>