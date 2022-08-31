<template>
    <div>
        <!-- Profile Restricted -->
        <div v-if="profile_restricted" class="p">
            <PageWrapper layout="boxed">
                <div class="bg-gray-900 rounded border-gray-alt2 border max-w-4xl m-auto p-10 text-center">
                    <h1 class="text-4xl my-2">Profile Restricted</h1>
                    <p class="italic">This account has been set to private.</p>
                </div>
            </PageWrapper>
        </div>

        <!-- Profile Page -->
        <div v-else-if="user && theme.image">
            <PageWrapper :image="'/storage/' + theme.image" layout="boxed" :blur="true" :vh="50">
                <div>
                    <div class="profile-header h-64 w-full border-2 border-white hidden lg:block" :style="'background-image:url(/storage/' + theme.image + ')'">
                        <h1 class="text-white dm-sans text-4xl px-1 py-4">{{user.name}}</h1>
                    </div>

                    <div class="profile-page grid-cols-12 gap-4 mx-2 md:mx-16">
                        <!-- Side Panel -->
                        <div class="col-span-12 side-panel">
                            <SidePanel :user="user" class="side-panel lg:-my-24"/>
                        </div>

                        <div class="col-span-12 main-content">
                            <!-- User Summary -->
                            <SummaryPanel :user="user"/>

                            <!-- Sports Information -->
                            <div class="bg-black my-6 rounded border-gray-alt2 border">
                                <h3 class="p-4 minor-heading">
                                    <span class="text-accent">
                                        <i class="fas fa-running"></i>
                                    </span>
                                    <span class="px-2">Sports</span>
                                </h3>
                                <hr>
                                <SportsDataPanel v-if="sports.length > 0" :user="user" class="p-4" />
                                <div v-else class="p-4 text-center italic">Sports Not Set</div>
                            </div>

                            <!-- Sports Analytaics -->
                            <SportsAnalytics :user="user"/>

                            <!-- Additional Information -->
                            <AdditionalInfoPanel :user="user"/>
                        </div>
                    </div>
                </div>
            </PageWrapper>
        </div>
    </div>
</template>
<script>
export default {
    name:"ProfilePage",
    data() {
        return {
            theme:{},
            theme_loaded:false,
            profile_restricted:false,
            user:null,
            sports:[],
            user_id: this.$route.params.id
        }
    },
    computed: {
        authenticated_user() {
            return this.$store.getters.user;
        }
    },
    watch: {
        user: {
            immediate: true,
            handler() {
                if(! this.theme_loaded && this.user) {
                    this.loadTheme();
                    this.theme_loaded = true;
                }
            }
        }
    },
    mounted() {
        this.loadUser();
    },
    methods: {
        loadUser() {
            let self = this;
            axios.get("api/user/" + this.user_id).then(res => {
                self.user = res.data;
                self.sports = res.data.sports;
            }).catch(error => {
                self.profile_restricted = true;
            });
        },
        loadTheme() {
            let self = this;
            axios.get("api/theme/" + this.user.profile_theme_id).then(res => {
                self.theme = res.data;
            });
        }
    }
}
</script>
<style scoped>
@media (min-width: 1024px) {
    .profile-header {
        display: flex;
        align-items: flex-end;
    }
    .profile-header>h1 {
        margin-left:10em;
    }
    .side-panel {
        position:fixed;
        max-width:18em;
    }
    .main-content {
        padding-left:19em;
        width:100%;
    }
}

@media (min-width: 1024px) and (max-height: 1200px) {
    .side-panel {
        position:relative !important;
    }
    .profile-page {
        display: flex !important;
    }
    .main-content {
        padding-left:0em !important;
    }
}
</style>
