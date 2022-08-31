<template>
    <div class="p-10">
        <h1 class="account-header pb-4">Saved Searches</h1>

        <div v-if="saved_searches.length > 0" class="saved-search-wrapper grid grid-cols-12 gap-4">
            <div 
                class="saved-search col-span-6"
                v-for="search in saved_searches" 
                :key="search.id">

                <!-- Saved Search Details -->
                <div v-if="search.recent_count != undefined" class="cursor-pointer bg-gray-900 rounded text-center pt-3 px-4 border-b-2 border-accent">
                    <!-- Delete Button -->
                    <div class="text-gray-400 inline-block float-right mx-2" v-on:click="deleteSavedSearch(search.id)">
                        <i class="fas fa-times"></i>
                    </div>

                    <router-link :to="{ name: 'saved-search-view', params:{ id: search.id }}">            
                        <!-- Match Count -->
                        <div class="text-center">
                            <div class="text-accent text-lg">{{calculateNewMatches(search)}} new matches.</div>
                            <div class="italic text-white text-sm">Updated on {{formatTimestamp(search.updated_at)}}</div>
                        </div>
                        <div class="grid grid-cols-3 py-3">
                            <!-- Sport Icons -->
                            <div class="col-span-1 flex justify-center" v-if="sports.length > 0 && search.sports">
                                <div v-for="sport_id in search.sports" :key="sport_id" class="text-accent px-1">
                                    <i :class="sports.find(sport => sport.id === sport_id).icon_class"></i>
                                </div>
                            </div>

                            <!-- Total Matches -->
                            <div class="col-span-1">
                                <div class="text-accent text-sm">
                                    <i class="fas fa-user-friends"></i> 
                                    <span class="p-1">{{search.recent_count}}</span>
                                </div>
                            </div>

                            <!-- Criteria Count -->
                            <div class="col-span-1">
                                <div class="text-accent text-sm">
                                    <i class="fas fa-filter"></i>
                                    <span class="p-1">{{search.criteria_count}}</span>
                                </div>
                            </div>
                        </div>
                    </router-link> 
                </div>

                <!-- Processing Message for Recently Created Searches -->
                <div v-else class="italic bg-black rounded text-center p-6 border-b-2 border-accent">
                    Processing Saved Search
                </div>
            </div>
        </div>
        <div v-else class="nothing-message">
            0 Saved Searches
        </div>
    </div>
</template>
<script>
export default {
    name:"SavedSearch",
    data() {
        return {
            saved_searches: [],
            sports:[]
        }
    },
    mounted() {
        this.loadSavedSearches();
        this.loadSports();
    },
    methods: {
        deleteSavedSearch(saved_search_id) {
            let self = this;
            axios.delete("api/savedsearch/" + saved_search_id).then(res => {
                var deletedIndex = this.saved_searches.findIndex(ss => ss.id === res.data.id);
                this.saved_searches.splice(deletedIndex, 1);

                self.$noty.success("Saved Search Deleted");
            }).catch(error => {
                self.$noty.error("Oops, there was an unknown error.");
            });
        },
        getSportClass(sport_id) {
            var sport = this.sports.find(sport => sport.id === sport_id).icon_class;
            if(sport) {
                return sport.icon_class;
            }
            else {
                return "";
            }
        },
        loadSavedSearches() {
            let self = this;
            axios.get("api/savedsearch/").then(res => {
                self.saved_searches = res.data;
            });
        },
        calculateNewMatches(search) {
            return Math.max(0, search.recent_count - search.previous_count);
        },
        loadSports() {
            let self = this;
            axios.get("api/sport/full").then(res => {
                self.sports = res.data;
            });
        }
    }
}
</script>