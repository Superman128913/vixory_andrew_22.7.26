<template>
    <div class="p-10 pb-32">
        <div v-if="videos.length > 0">
            <h1 class="account-header pb-10">Videos</h1>
            <div v-for="video in videos" :key="video.id" class="mb-6">
                <VideoEmbed :video="video" class="rounded-lg"/>
                <!-- Actions -->
                <div v-if="video" class="mt-4 block">
                    <button v-on:click="deleteVideo(video.id)" class="btn">Delete</button>
                </div>
            </div>
        </div>
        <div v-else class="nothing-message">
            No Videos Found
        </div>
        <AccountFooter :to="{name:'new-video'}">
            <i class="far fa-plus-circle"></i>
            <span class="px-3">Add Video</span>
        </AccountFooter>
    </div>
</template>
<script>
export default {
    name:"Videos",
    data() {
        return {
            videos:[]
        }
    },
    computed: {
        user_id() {
            return this.$store.getters.user.id;
        }
    },
    mounted() {
        this.getVideos();
    },
    methods: {
        getVideos() {
            let self = this;
            axios.get("api/video").then(res => {
                self.videos = res.data;
            }).catch(error => {
                self.$noty.error("Error loading videos.");
            });
        },
        deleteVideo(video_id) {
            let self = this;
            axios.delete("api/video/" + video_id).then(res => {
                let videoIndex = self.videos.findIndex(video => video.id === video_id);
                self.videos.splice(videoIndex, 1);
                self.$noty.success("Video Deleted")
            }).catch(error => {
                self.$noty.error("There was a problem deleting the video");
            });
        }
    }
}
</script>