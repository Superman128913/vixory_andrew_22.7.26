<template>
    <div style="padding:400px 0 0 0;position:relative;">
        <iframe :src="video_src" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
    </div>
</template>
<script>
export default {
    name:"VideoEmbed",
    props:["video"],
    computed: {
        video_src() {
            return "https://player.vimeo.com/video/" + this.video.source_id + "?h=e9c99569ac&amp;badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479";
        }
    }
}
</script>
<style scoped>
.embed-container { 
    position: relative; 
    padding-bottom: 56.25%; 
    height: 0; 
    overflow: hidden; 
    max-width: 100%; 
} 
.embed-container iframe, .embed-container object, .embed-container embed { 
    position: absolute; 
    top: 0; 
    left: 0; 
    width: 100%; 
    height: 100%; 
}
</style>