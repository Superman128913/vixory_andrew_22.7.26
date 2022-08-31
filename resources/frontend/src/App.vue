<template>
    <div class="relative">
        <div>
        
            <!-- Canvas Layout -->
            <div v-if="layout === 'canvas'">
                <div class="branding">
                    <router-link :to="{name: 'home'}"></router-link>
                </div>
                <div>
                    <router-view></router-view>
                </div>
            </div>

            <!-- Standard Page Layout -->
            <div v-if="layout === 'default'">

                <!-- MENU -->
                <Navigation v-if="layout !== 'canvas'" />

                <!-- PAGE -->
                <router-view></router-view>

                <!-- FOOTER -->
                <Footer v-if="layout !== 'canvas'"/>
            </div>

        </div>
    </div>
</template>
<script>
    import Navigation from './components/Navigation';
    export default {
        watch: {
            '$route' (to, from) {
                this.layout = this.$route.meta.layout || "default"
            }
        },
        components: {
            Navigation
        },
        metaInfo() {
        return {
            title: "Vixory | Connecting Athletes And Recruiters",
            meta: [
                    { 
                        name: 'description', 
                        content: 'Connecting athletes and coaches/recruiters by equipping coaches with high powered search criteria and giving athletes a place to showcase their skillset.',
                    },
                ]
            }
        },
        data() {
            return {
                layout: this.$route.meta.layout || "default"
            }
        }
    }
</script>
<style>
.logoimage {
    max-width:12rem;
}
.nav-wrapper {
    background: rgb(0,0,0);
    background: linear-gradient(180deg, rgba(0,0,0,1) 0%, rgba(102,102,102,0) 80%, rgba(255,255,255,0) 100%);
}
</style>