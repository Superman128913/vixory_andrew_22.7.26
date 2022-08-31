<template>
    <div v-if="user" class="bg-black lg:bg-transparent rounded lg:rounded-none p-4 border-gray-alt2 border lg:border-0">
        <!-- Profile Image -->
        <img v-if="user.profile_image" :src="user.profile_image" class="block border-white border-2 rounded profile-image-tag"/>
        <img v-else src="/images/design/default-user-avatar.png" class="block m-auto"/>

        <!-- Users Name (small view only) -->
        <h1 class="block lg:hidden text-center text-3xl text-white pt-4 pb-0">{{user.name}}</h1>

        <!-- Social Links -->
        <div class="social-link-wrapper my-4">
            <a target="_blank" class="standard-icon" v-if="user.social_media_facebook" :href="user.social_media_facebook">
                <i class="fab fa-facebook"></i>
            </a>
            <a target="_blank" class="standard-icon" v-if="user.social_media_twitter" :href="user.social_media_twitter">
                <i class="fab fa-twitter"></i>
            </a>
            <a target="_blank" class="standard-icon" v-if="user.social_media_linkedin" :href="user.social_media_linkedin">
                <i class="fab fa-linkedin"></i>
            </a>
            <a target="_blank" class="standard-icon" v-if="user.social_media_instagram" :href="user.social_media_instagram">
                <i class="fab fa-instagram"></i>
            </a>
        </div>

        <span class="my-4">
            <hr>
        </span>

        <!-- Quick Info -->
        <div class="my-4 flex" v-if="user.playing_level === 4 || user.college">
            <div class="text-accent">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="px-6 font-bold">
                <template v-if="user.playing_level === 4">
                    <p>{{user.highschool}}</p>
                    <p>{{user.highschool_gpa}} GPA</p>
                </template>
                <template v-else-if="user.college">
                    <p>{{user.college.name}}</p>
                    <p>{{user.college_gpa}} GPA</p>
                </template>
            </div>
        </div>

        <span class="my-4">
            <hr>
        </span>

        <!-- Weight/Height/Age -->
        <div class="quick-links grid grid-cols-3 my-4">
            <div class="item text-center">
                <span class="icon-wrapper standard-icon text-accent"><i class="fas fa-weight"></i></span>
                <span class="value font-bold">{{user.weight | dash}}</span>
            </div>
            <div class="item text-center">
                <span class="icon-wrapper standard-icon text-accent"><i class="fas fa-ruler-vertical"></i></span>
                <span class="value font-bold">{{user.height | dash}}</span>
            </div>
            <div class="item text-center">
                <span class="icon-wrapper standard-icon text-accent"><i class="fas fa-user"></i></span>
                <span class="value font-bold">{{user.age | dash}}</span>
            </div>
        </div>

        <span class="py-4">
            <hr>
        </span>

        <!-- Profile Link -->
        <div class="flex justify-center">
            <ShareLink text="Share Profile" :link="current_link"/>
        </div>
    </div>
</template>
<script>
export default {
    name:"SidePanel",
    props: {
        user:Object
    },
    data() {
        return {
            current_link: window.location.href
        }
    }
}
</script>
<style lang="scss">
    .profile-image-tag {
        max-height:400px;    
        margin-right:auto;
        margin-left:auto;
    }
    .social-link-wrapper {
        @apply text-center;
    }
    .quick-links {
        .icon-wrapper, .label, .value {
            @apply pl-1 pr-1;
        }

        .icon-wrapper {
            svg {
                width:20px;
            }
        }

        .label {
            @apply font-bold
        }
    }
</style>