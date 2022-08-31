<template>
    <div class="image-upload-wrapper pt-2 pb-2 my-1 md:my-4">
        <label v-show="label">{{label}}</label>

        <!-- Image Preview Area -->
        <div v-if="previewMode" class="relative max-w-xs">
            <img v-if="image_url" :src="image_url" class="rounded-lg"/>
            <span v-on:click="setPreviewMode" class="pl-2 pr-2 pt-1 pb-1 cursor-pointer rounded-lg bg-gray-900 shadow-sm absolute left-0 top-0 text-gray-700 m-4">
                <i class="fad fa-image"></i><span class="pl-2">Edit Image</span>
            </span>
        </div>

        <!-- Image Upload Area -->
        <div
            v-else 
            class="image-upload p-4 bg-gray-900 rounded-lg text-center border-2 border-gray-alt2" 
            :class="{ highlight:highlight }" 
            v-on:dragenter.prevent="highlightDrop" 
            v-on:dragover.prevent="highlightDrop" 
            v-on:dragleave.prevent="unhighlightDrop" 
            v-on:drop.prevent="handleDrop">

            <!-- Inner Wrapper Around Upload Area -->
            <div class="inner-wrapper p-4 border-white rounded-lg hover:border-gray-300 flex items-center">
                <i class="fas fa-folder-open text-accent text-5xl"></i>
                
                <!-- Upload Text -->
                <div>
                    <span class="text-accent p-2 px-6">
                        <span class="text-white">Drop your image here, or </span>
                        <label class="cursor-pointer inline text-accent font-bold text-lg" :for="_uid + 'uploader'">Browse</label>
                    </span>
                    <input ref="imageField" class="hidden" :id="_uid + 'uploader'" type="file" v-on:change="handleManualUpload" accept="image/*"/>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name:"ImageUploader",
    props: {
        save: {
            type: String,
            required: true
        },
        label: {
            type: String,
            default: null
        },
        src: {
            type: String,
            default: null
        },
        showPreview: {
            type: Boolean,
            default: true
        }
    },
    data() {
        return {
            image_url:this.src,
            highlight:false,
            previewMode: this.src ? true : false 
        }
    },
    methods: {
        setPreviewMode() {
            this.previewMode = false;
        },
        uploadFile(file) {
            //Construct request body.
            var formData = new FormData();
            formData.append('file', file);

            let settings = { headers: { 'content-type': 'multipart/form-data' } }

            //Save image.
            let self = this;
            axios.post(this.save, formData, settings).then(res => {
                self.$emit("save", res.data);

                self.image_url = res.data;

                if(self.showPreview) {
                    self.previewMode = true;
                }
            }).catch(error => {
                this.$noty.error("There was an error uploading the image.");
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