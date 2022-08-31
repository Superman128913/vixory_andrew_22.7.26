<template>
    <PageWrapper class="bg-center" layout="boxed" image="/images/design/search-hero-image.jpg">
        <div class="background-image"></div>
        <div class="search-page-wrapper grid grid-cols-1">
            <div class="search-panel bg-black rounded-md border border-gray-alt2 mx-3">
                <h1 class="text-center p-10">Search Vixory</h1>
                <hr>
                <SearchCriteria 
                    v-if="processing_complete" 
                    v-on:search="search" 
                    :savedSearch="savedSearch"/>
            </div>
            <div class="results">
                <ResultsGrid ref="results"/>
                <Pagination :pagination="pagination" v-on:page-change="goTo"/>
            </div>
        </div>
    </PageWrapper>
</template>
<script>
export default {
    name:"Search",
    data() {
        return {
            users:[],
            pagination: {
                current_page:1,
                last_page:null,
                total:null
            },
            processing_complete: false,
            savedSearch: false,
        }
    },
    computed: {
        sports_selected() {
            return this.$store.getters.sportsSelected;
        }
    },
    mounted() {
        //If saved search
        let param_id = parseInt(this.$route.params.id);
        if(param_id) {
            this.savedSearch = param_id;

            let self = this;
            this.$store.dispatch("loadSavedSearch", this.savedSearch).then(res => {
                self.search();
            });
        }

        this.processing_complete = true;
    },
    methods: {
        goTo(e){
            this.pagination.current_page = e;
            this.search();
        },
        search() {
            //Setup payload
            let payload = this.$store.getters.filters;
            payload.sports_selected = this.sports_selected;
            payload.page = this.pagination.current_page;

            //Make Request
            let self = this;
            axios.post("api/search", payload).then(res => {
                self.users = res.data.data;

                self.pagination = {
                    current_page: res.data.current_page,
                    last_page: res.data.last_page,
                    total: res.data.total
                }

                self.$refs.results.setUsers(self.users);
            }).catch(error => {
                this.$noty.error("There was an error with your search.");
            });
        }
    }
}
</script>