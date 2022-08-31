<template>
    <div>
        <div>{{label}}</div>

        <!-- PDF Preview -->
        <div v-if="d_media && !upload" class="relative inline-block pdf-wrapper cursor-pointer" v-on:click="setToUpload">
            <div class="block absolute right-0 p-4 text-lg">
                <i class="fas fa-times"></i>
            </div>
            <img class="rounded-lg my-2 bg-black hover:opacity-75" :src="d_media.thumb_url"/>
        </div>

        <!-- Upload Area -->
        <div
            v-else
            class="my-2 p-4 bg-gray-900 rounded-lg text-center border-2 border-gray-alt2"
            v-on:dragenter.prevent="highlightDrop"
            v-on:dragover.prevent="highlightDrop"
            v-on:dragleave.prevent="unhighlightDrop"
            v-on:drop.prevent="handleDrop">
            <span class="text-white p-2 px-6">
                <label class="cursor-pointer inline text-accent font-bold text-lg" :for="name">Upload</label>
            </span>
            <input ref="imageField" class="hidden" :id="name" type="file" v-on:change="handleManualUpload" accept="application/pdf"/>
        </div>

    </div>
</template>
<script>
export default {
    name:"PdfUploader",
    props:["label", "name", "media"],
    data() {
        return {
            upload:false, //This is a state variable used in instances where the media is present.
            d_media:null
        }
    },
    watch: {
        media: {
            handler(media) {
                this.d_media = media;
            },
            immediate: true
        }
    },
    methods: {
        setToUpload() {
            this.upload = true;
        },
        uploadFile(file) {
            //Construct request body.
            var formData = new FormData();
            formData.append('file', file);
            formData.append('name', this.name);

            let settings = { headers: { 'content-type': 'multipart/form-data' } }

            //Save image.
            let self = this;
            axios.post("api/user/images/reserved", formData, settings).then(res => {
                self.upload = false;
                self.media = res.data;
            }).catch(error => {
                this.$noty.error("There was an error uploading the pdf.");
            });
        },
        handleManualUpload() {
            var files = this.$refs.imageField.files;
            this.uploadFile(files[0]);
        },
        handleDrop(e) {
            this.unhighlightDrop();

            var files = e.dataTransfer.files;
            this.uploadFile(files[0]);
        },
        highlightDrop() {
            this.highlight = true;
        },
        unhighlightDrop() {
            this.highlight = false;
        }
    }
}
</script>
