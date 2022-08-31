<template>
    <div class="footer relative overflow-hidden">
        <cookie-law position="top" theme="vixory"></cookie-law>

        <AccentMark width="100%" height="4px" marginTop="0px" class="bg-accent"/>
        <div class="grid grid-cols-12 py-10 pl-10 lg:pl-20 lg:pr-40 pr-10">
            <!-- LOGO -->
            <div class="col-span-12 md:col-span-12 lg:col-span-3 px-2 flex flex-col lg:border-r lg:border-accent">
                <div>
                    <img class="footer-image mt-2 mb-8 m-auto lg:mx-0" src="/images/logo/0.5x/vixory-wordmark-white@0.5x.png"/>
                    <div class="text-accent text-2xl norwester leading-tight tracking-wider lg:mb-0 mb-8 text-center lg:text-left">
                        Connecting Athletes <br> And Recruiters
                    </div>
                </div>
            </div>

            <!-- FOOTER LINKS -->
            <div class="col-span-12 md:col-span-12 lg:col-span-3 px-2 flex flex-col justify-center">
                <div class="flex relative">
                    <ul class="block md:flex lg:inline-block m-auto"> 
                        <router-link tag="li" class="p-2 lg:p-1 text-center lg:text-left cursor-pointer text-xl text-accent norwester" :to="{name: 'about'}">About</router-link>
                        <router-link tag="li" class="p-2 lg:p-1 text-center lg:text-left cursor-pointer text-xl text-accent norwester" :to="{name: 'terms-of-use'}">Terms Of Use</router-link>
                        <router-link tag="li" class="p-2 lg:p-1 text-center lg:text-left cursor-pointer text-xl text-accent norwester" :to="{name: 'fulfillment-policy'}">Fulfillment Policy</router-link>
                        <router-link tag="li" class="p-2 lg:p-1 text-center lg:text-left cursor-pointer text-xl text-accent norwester" :to="{name: 'privacy-policy'}">Privacy Policy</router-link>
                        <router-link tag="li" class="p-2 lg:p-1 text-center lg:text-left cursor-pointer text-xl text-accent norwester" :to="{name: 'faq'}">FAQ</router-link>
                        <li class="p-2 lg:p-1 text-center lg:text-left cursor-pointer text-xl text-accent norwester">
                            <a href="https://vixory.qbstores.com/home" target="_blank">Apparel</a>
                        </li>
                    </ul>
                </div>

                <hr class="lg:hidden my-8">
            </div>

            <!-- FOOTER INFO -->
            <div class="col-span-12 md:col-span-12 lg:col-span-4 px-2 flex flex-col lg:border-l lg:border-accent">
                <div class="mx-12">
                    <div class="px-2 pt-0 pb-6">
                        <div>2733 East Battlefield</div>
                        <div>Ste. 126, Springfield, Missouri 65804</div>
                    </div>
                    <a class="px-2" href="tel:877-516-0213">
                        <span class="text-accent pr-1"><i class="fas fa-phone-alt"></i></span>
                        877-516-0213
                    </a>
                    <br>
                    <a class="px-2 pb-6" href="mailto:info@vixory.com">
                        <span class="text-accent pr-1"><i class="fas fa-envelope"></i></span>
                        info@vixory.com
                    </a>
                    <div class="text-sm italic px-2 pb-0 pt-6">© Vixory 2021</div>
                </div>
            </div>
        </div>

        <!-- Accent in bottom right -->
        <div class="triangle-accent"></div>
    </div>
</template>
<script>
import CookieLaw from 'vue-cookie-law'
export default {
    name:"Footer",
    components: { CookieLaw }
}
</script>
<style>
.footer-image {
    max-width:14rem;
}
.footer {
    background: linear-gradient(180deg, rgba(35,31,32,1) 0%, rgba(0,0,0,1) 100%);
    bottom: 0;
    width: 100%;
}
.triangle-accent {
    right:0;
    bottom:0;
    position:absolute;
    transform: rotate(-45deg) scale(4);
    width: 0;
    height: 0;
    margin-right:-100px;
    margin-bottom:-50px;
    border-bottom: 140px solid rgba(222,174,83,0.22);
    border-left: 70px solid transparent;
    border-right: 70px solid transparent;
}
</style>