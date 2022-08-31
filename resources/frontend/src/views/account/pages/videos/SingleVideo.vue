<template>
    <div v-if="video_loaded" :class="{'p-10':!inline}">
        <div v-if="!fail_safe && !disable_upload">
            <div :class="{'alt':inline, 'my-4':!inline}">
                <label for="videoUpload"></label>
                <input 
                    :class="{'alt':inline}"
                    ref="videoInput" 
                    type="file" 
                    id="videoUpload">
            </div>
            <TextInput 
                :class="{'alt':inline, 'my-4':!inline}"
                v-model="video.title" 
                label="Title"/>
            <TextareaInput 
                :class="{'alt':inline, 'my-4':!inline}"
                v-model="video.description" 
                label="Description"/>
            
            <FormButton :text="buttonText" v-bind:loading="uploading" v-on:buttonClick="uploadVideo" class="mt-4"/>
        </div>
        <div v-else>
            <p class="text-red-600" v-if="!disable_upload">Unfortunately we were unable to upload your video to Vimeo. Feel free to upload your video to YouTube directly and paste the link in here.</p>
            <TextInput 
                :class="{'alt':inline, 'my-4':!inline}"
                v-model="video.url" 
                label="Url"/>
            <p v-if="video.source_id">{{video.source_id}}</p>

            <TextInput 
                :class="{'alt':inline, 'my-4':!inline}"
                v-model="video.title" 
                label="Title"/>

            <TextareaInput 
                :class="{'alt':inline, 'my-4':!inline}"
                v-model="video.description" 
                label="Description"/>

            <button v-on:click="uploadVideoByReference" class="mt-4">
                {{buttonText}}
            </button>
        </div>
    </div>
</template>
<script>
export default {
    name:"SingleVideo",
    props: {
        inline: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            video_id: this.$route.params.id,
            video: {
                url:"",
                source_id:"",
                title:"",
                description:"",
            },
            video_loaded:false,
            fail_safe:false,
            disable_upload:false, //Set to true if the video should default to manual entry.
            uploading:false
        }
    },
    watch: {
        'video.url'() {
            this.video.source_id = this.idFromYoutube();
        }
    },
    computed: {
        buttonText() {
            if(this.$route.params.id) {
                return "Update";
            }
            else {
                return "Upload";
            }
        }
    },
    mounted() {
        if(this.video_id) {
            this.loadVideo();
        }
        else {
            this.video_loaded = true;
        }
    },
    methods: {
        uploadVideoByReference() {
            let data = this.video;

            axios.post("api/video/byreference", data).then(res => {
                self.$noty.success("Video Uploaded");
                if(!this.inline) {
                    self.$router.push({name: 'videos'});
                }
            }).catch(errors => {
                this.$noty.error("Error uploading video.");
            });
        },
        idFromYoutube() {
            //e.g. https://www.youtube.com/watch?v=8DvywoWv6fI
            var video_id = this.video.url.split('v=')[1];
            var ampersandPosition = video_id.indexOf('&');
            if(ampersandPosition != -1) {
                video_id = video_id.substring(0, ampersandPosition);
            }
            return video_id;
        },
        uploadVideo(file) {
            let files = this.$refs.videoInput.files
            var formBody = this.createBody(files[0]);
            let settings = { headers: { 'content-type': 'multipart/form-data' } };

            this.uploading = true;

            let self = this;
            axios.post("api/video", formBody, settings)
            .then(res => {
                self.uploading = false;
                self.video = res.data;
                self.$noty.success("Video Uploading");
                self.$router.push({name: 'videos'});
            }).catch(error => {
                self.uploading = false;
                self.fail_safe = true;
                self.$noty.error("There was a problem");
            });
        },
        createBody(file) {
            var formData = new FormData();
            formData.append('file', file);
            formData.append('title', this.video.title);
            formData.append('description', this.video.description);
            return formData;
        },
        loadVideo() {
            self = this;
            axios.get("api/video/" + this.video_id).then(res => {
                self.video = res.data;
                self.video_loaded = true;
            }).catch(error => {
                this.$noty.error("Error loading video.");
            });
        }
    }
}
</script>