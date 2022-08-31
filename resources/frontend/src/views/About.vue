<template>
    <PageWrapper :image="'/images/design/soccer_background.jpg'" imageClass="bg-left-bottom" :padding="false">
        <!-- Intro Section -->
        <div class="grid grid-cols-12 gap-4 my-20 lg:my-64">
            <div class="col-start-1 col-span-12 md:col-start-3 md:col-span-8 lg:col-start-3 lg:col-span-4">
                <h1 class="text-white">About Vixory</h1>
                <hr class="heading-hr">
                <p>At Vixory, we understand how "old school" the process of transferring schools can be. Our mission is to help athletes find a school to fit their needs and talents. We know that student athletes need a little help, and we strive to provide the best online platform to make your transfer easy, so you can build your athletic career where YOU want to.</p>
                <router-link :to="{name:'register-plans'}" class="my-4 block text-lg">
                    <router-link :to="{name:'register-plans'}" class="text-accent uppercase font-bold tracking-wider">Get Started</router-link>
                    <span class="px-2 text-accent">
                        <i class="fas fa-angle-right"></i>  
                    </span>  
                </router-link>
            </div>
        </div>

        <!-- Second Section -->
        <div class="grid grid-cols-12 second-section my-20 lg:my-64">
            <div style="background-image:url('/images/design/logo_mark_faded.png')" class="flex bg-no-repeat bg-contain bg-left-top col-start-1 col-span-12 md:col-start-3 lg:col-start-3 md:col-span-5 lg:col-span-5 md:pr-20 lg:pr-32">
                <div class="flex flex-col self-center">
                    <h2 class="text-white text-3xl dm-sans capitalize">Accelerate Your Game</h2>
                    <hr class="heading-hr">
                    <p>With Vixory, young guns can build their online portfolios, show off their stats, boast their highlights, and get recognized for their skill. Established players can privately market themselves to their dream college without disrupting their all-star career at their current institution. Coaches and recruiters who need to fill critical positions on their teams can scout for their next MVP, filtering their searches for the talents they need most.</p>
                </div>
            </div>
            <div class="col-span-12 md:col-span-5">
                <img class="about-image image-coach-kneeling ml-auto" src="/images/design/coach_kneeling.png"/>
            </div>
        </div>

        <!-- Third Section -->
        <div class="grid grid-cols-12 my-20 lg:my-64">
            <!-- Desktop Image, to allow for reversing order without flexbox -->
            <div class="hidden md:block col-span-12 md:col-span-5">
                <img class="about-image image-slam-dunk" src="/images/design/slam_dunk.png"/>
            </div>

            <div class="col-span-12 md:col-span-5 lg:col-span-5 flex flex-col self-center md:pl-20 lg:pl-32">
                <h2 class="text-white text-3xl dm-sans capitalize">Excellence Above All</h2>
                <hr class="heading-hr">
                <p>With connectivity at its forefront, Vixory provides a level playing field where community comes first and excellence is rewarded. For your next big win, choose Vixory.</p>
            </div>

            <!-- Mobile Image -->
            <div class="display:block md:hidden col-span-12 md:col-span-5">
                <img class="about-image image-slam-dunk" src="/images/design/slam_dunk.png"/>
            </div>
        </div>

    </PageWrapper>
</template>
<script>
export default {
    name:"About"
}
</script>
<style scoped>
    @media (min-width: 768px) {
        .second-section {
            margin-top:24rem;
        }
    }
</style>