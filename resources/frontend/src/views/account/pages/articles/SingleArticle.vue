<template>
    <div class="">
        <div class="p-10">
            <TextInput 
                class="my-4"
                label="Article Link" 
                :loading="article_loading"
                v-model="article.link"/>

            <!-- Featured Image -->
            <template v-if="article_loaded">
                <BooleanInput 
                    class="my-4"
                    label="Upload Custom Image" 
                    v-model="upload_image"/>
                <template v-if="upload_image">
                    <ImageUploader 
                        class="my-4"
                        label="" 
                        :save="'api/user/images/tmp'" 
                        :src="article.featured_image" 
                        v-on:save="handleImageSave"/>
                </template>
                <template v-else-if="article.featured_image">
                    <img :src="article.featured_image" class="max-w-md mt-4 mb-4">
                </template>
            </template>

            <TextInput 
                class="my-4"
                label="Title" 
                v-model="article.name"/>
            <TextareaInput 
                class="my-4"
                label="Description" 
                v-model="article.description"/>
            <button v-on:click="deleteArticle" v-if="article.id">Delete</button>
            <button v-on:click="updateArticle" class="mt-4 mx-2">{{buttonText}}</button>
        </div>
    </div>
</template>
<script>
export default {
    name:"SingleArticle",
    data() { 
        return {
            article: {
                link: "",
                name: "",
                description:"",
                featured_image:"",
            },
            upload_image: false,
            article_loading:false,
            article_loaded: false,
        } 
    },
    computed: {
        buttonText() {
            if(this.$route.params.id) {
                return "Update";
            }
            else {
                return "Save >";
            }
        },
        article_link() {
            return this.article.link;
        }
    },
    watch: {
        article_link: {
            handler: function(link) {
                let re = /https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)/;
                if(re.test(link)) {
                    let payload = {
                        "url":link
                    }
                    this.article_loading = true;

                    let self = this
                    axios.post("api/article/details", payload).then(res => {
                        self.article_loaded = true;
                        self.article_loading = false;

                        //Show the user a confirmation message letting them know they can modify the article information.
                        self.$noty.success("Article found, feel free to modify!")

                        //Add in the information we pulled
                        self.article.name = res.data.title;
                        self.article.description = res.data.description;
                        self.article.featured_image = res.data.screenshot;
                    })
                }
            }
        }
    },
    mounted() {
        if(this.$route.params.id) {
            this.article.id = this.$route.params.id;
            this.loadArticle();
        }
        else {
            this.article_loaded = true;
        }
    },
    methods: {
        loadArticle() {
            let self = this;
            axios.get("api/article/" + this.article.id).then(res => {
                this.article = res.data;
                this.article_loaded = true;
            });
        },
        deleteArticle() {
            let self = this;
            axios.delete("api/article/" + this.article.id).then(res => {
                this.$noty.success("Article Deleted");
                this.$router.push({name: 'articles'});
            }).catch(error => {
                this.$noty.error("Unable to delete the article.");
            });
        },
        handleImageSave(url) {
            this.article.featured_image = url;
        },
        clearArticle() {
            this.article.name = "";
            this.article.link = "";
            this.article.description = "";
        },
        updateArticle() {
            let self = this;
            if(this.article.id) {
                //Update existing article.
                axios.patch("api/article/" + this.article.id, this.article).then(res => {
                    self.$noty.success("Article Updated");
                }).catch(error => {
                    self.$noty.error("Oops, something went wrong!");
                });
            }
            else {
                //Create new article
                axios.post("api/article/", this.article).then(res => {
                    self.$noty.success("Article Updated");
                    this.$router.push({name: 'articles'});
                }).catch(error => {
                    self.$noty.error("Oops, something went wrong!");
                });
            }
        },
    }
}
</script>