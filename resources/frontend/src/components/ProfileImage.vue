<template>
    <div class="relative" v-if="src">
        <div 
            class="profile_image mt-6 bg-center bg-cover rounded-lg bg-no-repeat" 
            v-bind:style="{ backgroundImage: 'url(' + src + ')'}">
        </div>
    </div>
</template>
<script>
export default {
    name:"ProfileImage",
    props:["src"]
}
</script>
<style>
.profile_image {
    margin-bottom: 1rem;
    margin-left:auto;
    margin-right:auto;
    background-image:center;
    height:180px;
    width:180px;
}
@media (min-width: 1024px) {
    .profile_image {
        height:140px;
        width:140px;
    }
}
</style>