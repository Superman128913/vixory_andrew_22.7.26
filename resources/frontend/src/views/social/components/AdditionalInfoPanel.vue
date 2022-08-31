<template>
    <div class="additional-info-panel card border-gray-alt2 border" v-if="videos_loaded && articles_loaded">
        <tabs class="standard" ref="tabs">
            <tab name="Video" icon="fas fa-images" class="grid grid-cols-12">
                <template v-if="videos && videos.length > 0">
                    <div
                        v-for="video in videos" 
                        :key="video.id" 
                        class="pt-2 col-span-12 lg:col-span-6 gap-4">
                        <VideoEmbed :video="video"/>
                    </div>
                </template>
                <div v-else class="col-span-12 text-center italic">Videos Not Added</div>
            </tab>
            <tab 
                name="Articles" 
                icon="fas fa-newspaper" 
                class="grid grid-cols-12 gap-4">

                <!-- Loop through articles -->
                <template v-if="articles && articles.length > 0">
                    <div 
                        class="mb-4 col-span-12 lg:col-span-6 overflow-hidden" 
                        v-for="article in articles" 
                        :key="article.id">
                            <!-- Individual article -->
                            <img :src="article.featured_image" class="max-w-sm"/>
                            <div class="my-4">
                                <h5 class="text-lg">{{article.name}}</h5>
                                <p class="">{{article.description}}</p>
                            </div>
                            <a 
                                :href="article.link" 
                                target="_blank" 
                                class="btn inline-block">
                                View Full Article
                            </a>
                    </div>
                </template>
                <div v-else class="col-span-12 text-center italic">Articles Not Added</div>
            </tab>
        </tabs>
    </div>
</template>
<script>
export default {
    name:"AdditionalInfoPanel",
    props: {
        user:Object
    },
    data() {
        return {
            articles:null,
            videos:null,
            articles_loaded:false,
            videos_loaded:false
        }
    },
    mounted() {
        this.loadVideos();
        this.loadArticles();
    },
    methods: {
        loadVideos() {
            let self = this;
            axios.get("api/video/" + this.user.id).then(res => {
                self.videos = res.data;
                self.videos_loaded = true;
                self.calculateDefaultTab();
            });
        },
        loadArticles() {
            let self = this;
            axios.get("api/article/user/" + this.user.id).then(res => {
                self.articles = res.data;
                self.articles_loaded = true;
                self.calculateDefaultTab();
            });
        },
        calculateDefaultTab() {
            let self = this;
            this.$nextTick(() => {
                if(self.articles_loaded && self.videos_loaded) 
                {
                    if(self.videos.length > 0) {
                        self.$refs.tabs.setActive("Video");
                    }
                    else if(self.articles.length > 0) {
                        self.$refs.tabs.setActive("Articles");
                    }
                }
            });
        }
    }
}
</script>