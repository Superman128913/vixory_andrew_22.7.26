<template>
    <PageWrapper :image="'/images/design/soccer_background.jpg'" imageClass="bg-left-bottom" :padding="false">
        <!-- Intro Section -->
        <div class="grid grid-cols-12 gap-4 my-20 lg:mt-64 lg:mb-48">
            <div class="col-start-1 col-span-12 md:col-start-3 md:col-span-8 lg:col-start-3 lg:col-span-4">
                <h1 class="text-white">Controlling Your Information</h1>
                <hr class="heading-hr">
                <p>At Vixory, user privacy is our priority. If you have questions about how your information is shared on Vixory, please review our Privacy Policy and contact us with any questions you may have.</p>
                <router-link :to="{name:'privacy-policy'}" class="my-4 block text-lg">
                    <router-link :to="{name:'privacy-policy'}" class="text-accent uppercase font-bold tracking-wider">Privacy Policy</router-link>
                    <span class="px-2 text-accent">
                        <i class="fas fa-angle-right"></i>  
                    </span>  
                </router-link>
            </div>
        </div>

        <div class="boxed">
            <!-- Sharing your information -->
            <div class="grid grid-cols-12 gap-4 my-16">
                <div class="col-span-12 lg:col-span-6">
                    <div class="flex flex-col self-center">
                        <h2 class="text-white text-3xl dm-sans capitalize lg:mt-16">Sharing your information.</h2>
                        <hr class="heading-hr">
                        <p>If you want to share your profile information with the other users on Vixory, check the Show Information checkbox on your profile. If you want to keep your profile information private, uncheck the Show Information checkbox on your profile.</p>
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-6">
                    <div class="p-8 border border-gray-alt2 rounded">
                        <img src="/images/design/info/profile_page.png"/>
                    </div>
                </div>
            </div>

            <!-- Search Page -->
            <div class="grid grid-cols-12 gap-4 my-16">
                <div class="col-span-12">
                    <div class="max-w-4xl">
                        <h2 class="text-white text-3xl dm-sans capitalize">Search Page</h2>
                        <hr class="heading-hr">
                        <p>When you choose to keep your personal information private by unchecking the Show Information checkbox, your name and personally identifiable details will be private. We will still show general information from your profile, so coaches can determine if they want to request a connection and access your full profile.</p>
                    </div>
                    <div class="p-8 border border-gray-alt2 rounded mt-8">
                        <img src="/images/design/info/search.png"/>
                    </div>
                </div>
            </div>

            <!-- Social Page -->
            <div class="grid grid-cols-12 gap-4 my-16">
                <div class="col-span-12">
                    <div class="max-w-4xl">
                        <h2 class="text-white text-3xl dm-sans capitalize">Profile Page</h2>
                        <hr class="heading-hr">
                        <p>Your Vixory profile page will only be fully accessible to registered users that have connected with you. If you want to share all of your profile on social networks, you will need to click the Show Information checkbox on your profile page.</p>
                    </div>
                </div>
            </div>
        </div>
    </PageWrapper>
</template>
<script>
export default {
    name:"ControllingYourInformation"
    
}
</script>