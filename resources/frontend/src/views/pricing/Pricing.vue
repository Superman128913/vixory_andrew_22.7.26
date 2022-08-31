<template>
    <PageWrapper class="pricing-page bg-bottom" image="/images/design/track-lines.jpg" layout="boxed">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 lg:col-span-6 bg-gray-900 rounded border-gray-alt2 border" v-for="plan in plans">
                <div class="flex justify-between px-8 py-6">
                    <div class="flex items-center">
                        <div>
                            <h2 class="dm-sans capitalize text-white text-2xl leading-none">Athletes</h2>            
                            <span class="uppercase text-gray-alt3 text-sm">{{plan.name}}</span>
                        </div>
                    </div>
                    <div class="flex items-end" v-if="plan.cost">
                        <div class="flex">
                            <span class="text-accent text-3xl font-bold self-start">$</span>
                            <span class="text-accent leading-none pl-1 text-6xl font-bold">{{plan.cost | dollar}}</span>
                            <span class="text-accent text-xl self-end">/mo</span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="p-8">
                    <div id="athleteBox" class="max-height">
                        <p class="pb-2">{{plan.description}}</p>
                        <p>Vixory is designed to give you control over your personal information. You can decide what information to include on your profile and whether you want to make that information public. Your information will never show to your current college. <router-link :to="{name:'your-info'}" class="accent">Learn More</router-link></p>
                        <div v-on:click="removeExpand('#athleteBox')" class="block md:hidden expand text-center pt-2">
                            <span class="text text-accent cursor-pointer"><i class="fas fa-chevron-down"></i> Expand</span>
                        </div>
                    </div>
                    <ul class="w-full max-w-full grid grid-cols-12 py-6">
                        <li v-for="feature in plan.featured_list" :key="feature" class="col-span-12 lg:col-span-4 my-2">
                            <span class="text-accent">
                                <i class="fas fa-check-circle"></i>
                            </span>
                            <span class="px-2">{{feature}}</span>
                        </li>
                    </ul>
                    <button class="self-bottom" v-on:click="goToRegister(plan.id)">
                        Create Account
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <!-- Coach Plan -->
            <div class="col-span-12 lg:col-span-6 bg-gray-900 rounded border-gray-alt2 border flex flex-col">
                <div class="flex justify-between px-8 py-6">
                    <div class="flex items-center">
                        <div>
                            <h2 class="dm-sans capitalize text-white text-2xl leading-none">Coaches & Scouts</h2>
                            <span class="text-sm spacing invisible">.</span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="p-8 flex-grow relative">
                    <p class="pb-2">Create your free account to find athletes who match the criteria you're looking for to complete your team. Watch player videos, read articles about the athletes, and review their stats. Save your search criteria to find new players as they become available.</p>
                    <router-link class="lg:absolute lg:bottom-0 lg:my-8" tag="button" :to="{name:'coach-register'}">
                        Create Account
                        <i class="fas fa-chevron-right"></i>
                    </router-link>
                </div>
            </div>

        </div>
    </PageWrapper>
</template>
<script>
export default {
    name:"Pricing",
    data() {
        return {
            loaded:false,
            plans:[]
        }
    },
    mounted() {
        this.loadPlans();
    },
    methods: {
        removeExpand(expandSelector) {
            //Remove the expand text
            document.querySelector(expandSelector + " .expand").remove();

            //Remove the overflow class
            document.querySelector(expandSelector).classList.remove("max-height");
        },
        loadPlans() {
            let self = this;
            axios.get("api/plan").then(res => {
                self.plans = res.data;
                self.loaded = true;
            });
        },
        goToRegister(planId) {
            this.$router.push({
                name:"register",
                params: {
                    planId:planId
                }
            });
        }
    }
}
</script>