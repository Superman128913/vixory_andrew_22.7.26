<template>
    <PageWrapper :image="'/images/design/soccer_background.jpg'" imageClass="bg-left-bottom" :padding="true">
        <!-- Hero Image -->
        <div class="grid grid-cols-12 gap-4 my-20 lg:my-64">
            <div class="col-start-1 col-span-12 md:col-start-3 md:col-span-8 lg:col-start-3 lg:col-span-4">
                <h1 class="text-white">Connecting Athletes to Coaches & Recruiters</h1>
                <hr class="heading-hr">
                <p>Created by athletes, Vixory lets talented college players get recognized by registered coaches and scouts. Sign up for your free account and make your next big play with Vixory.</p>
                <router-link :to="{name:'register-plans'}" class="my-4 block text-lg">
                    <router-link :to="{name:'register-plans'}" class="text-accent uppercase font-bold tracking-wider">Get Started</router-link>
                    <span class="px-2 text-accent">
                        <i class="fas fa-angle-right"></i>  
                    </span>  
                </router-link>
            </div>
        </div>

        <!-- Sports Gallery -->
        <div class="grid grid-cols-5">
            <div class="sport-item soccer-background">
               <span class="inner-text hidden md:block">Soccer</span>
               <div class="sport-gradient"></div>
            </div>
            <div class="sport-item tennis-background">
                <span class="inner-text hidden md:block">Tennis</span>
                <div class="sport-gradient"></div>
            </div>
            <div class="sport-item football-background">
                <span class="inner-text hidden md:block">Football</span>
                <div class="sport-gradient"></div>
            </div>
            <div class="sport-item basketball-background">
                <span class="inner-text hidden md:block">Basketball</span>
                <div class="sport-gradient"></div>
            </div>
            <div class="sport-item baseball-background">
                <span class="inner-text hidden md:block">Baseball</span>
                <div class="sport-gradient"></div>
            </div>
        </div>
        
        <!-- Second Section -->
        <div class="grid grid-cols-12 second-section my-20 lg:my-64">
            <div style="background-image:url('/images/design/logo_mark_faded.png')" class="flex bg-no-repeat bg-contain bg-left-top col-start-1 col-span-12 md:col-start-3 lg:col-start-3 md:col-span-5 lg:col-span-5 md:pr-20 lg:pr-32">
                <div class="flex flex-col self-center">
                    <h2 class="text-white text-3xl dm-sans capitalize">College Transfers</h2>
                    <hr class="heading-hr">
                    <p>More playing time. Better coaches. A program that fits your needs. Higher levels of access to pro scouts. A better education. Moving closer to home. Whatever your reasons, transferring to another school to continue your athletic career should be in your control.</p>
                    <br>
                    <p>Established players can privately market themselves to their dream college without disrupting their all-star career at their current institution. We designed Vixory, so coaches only see athletes from other schools that wish to transfer. In other words, your current coach cannot see your transfer request by keeping your information anonymous.</p>
                </div>
            </div>
            <div class="col-span-12 md:col-span-5">
                <img class="about-image image-coach-kneeling ml-auto" src="/images/design/homepage/vixory-football-player.png"/>
            </div>
        </div>

        <!-- Third Section -->
        <div class="grid grid-cols-12 my-20 lg:my-64">
            <!-- Desktop Image, to allow for reversing order without flexbox -->
            <div class="hidden md:block col-span-12 md:col-span-5">
                <img class="about-image image-slam-dunk" src="/images/design/homepage/vixory-man-playing-tennis.png"/>
            </div>

            <div class="col-span-12 md:col-span-5 lg:col-span-5 flex flex-col self-center md:pl-20 lg:pl-32">
                <h2 class="text-white text-3xl dm-sans capitalize">How Vixory Works</h2>
                <hr class="heading-hr">
                <p>Vixory makes your transfer easy, so you can build your athletic career where YOU want to be. Our platform gives you total control over your transfer process by letting you post stats, highlight reels, skills, news articles, and what type of institution you’re looking to transfer to. Then coaches can see your stats and reach out.</p>
            </div>
        </div>

        <!-- Section - Register Today-->
        <div class="register-background py-40 text-center">
            <h3 class="text-6xl uppercase norwester">Register Today</h3>
            <hr class="heading-hr mx-auto">
            <p class="max-w-3xl mx-auto">Created by athletes, Vixory showcases talented college players so they can get recognized by registered coaches and scouts. Sign up for your free account and make your next big play with Vixory.</p>
            <router-link :to="{name:'register-plans'}" tag="button" class="mt-10 mb-6">
                Register Today
            </router-link>
        </div>
    </PageWrapper>
</template>
<script>
export default {
    name:"Home",
    metaInfo: {
        title: '',
        meta: [
            { 
                name: 'description', 
                content:  ''},
        ]
    }
}
</script>
<style lang="scss" scoped>
    @supports (-webkit-touch-callout: none) {
        #homepage {
            padding-top:1.5rem !important;
            padding-bottom:6rem !important;
        }
        #homepage img {
            padding:0.4rem !important;
        }
        #homepage h1 {
            padding-top:1rem !important;
            padding-bottom:1rem !important;
        }
    }
    .sport-gradient {
        width:100%;
        height:100%;
        position:absolute;
        bottom:0px;
        background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.6) 100%);
        z-index:10;
    }
    .page-wrapper {
        padding-bottom:0px !important;
    }
    .sport-item {
        @apply mx-2 flex flex-row rounded-lg relative bg-no-repeat bg-center bg-cover;
        min-height:200px;
    }
    .sport-item .inner-text {
        @apply text-lg self-end px-4 py-2 uppercase;
        z-index:100
    }
    .register-background {
        background-image:url('/images/design/homepage/basketball-court-blurry.png');
    }
    .soccer-background {
        background-image:url('/images/design/homepage/soccer.png'),
    }
    .tennis-background {
        background-image:url('/images/design/homepage/tennis.png');
    }
    .football-background {
        background-image:url('/images/design/homepage/football.png');
    }
    .basketball-background {
        background-image:url('/images/design/homepage/basketball.png');
    }
    .baseball-background {
        background-image:url('/images/design/homepage/baseball.png');
    }
</style>