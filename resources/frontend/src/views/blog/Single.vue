<template>
    <PageWrapper v-if="blog" :image="'/images/design/soccer_background.jpg'" imageClass="bg-left-bottom" :padding="false">
        <div class="my-20 lg:my-64">
            <div v-if="blog && blog.blog_category" class="text-white text-center uppercase text-2xl font-medium norwester tracking-widest">
                {{blog.blog_category.title}}
            </div>
            <h1 class="text-center max-w-6xl mx-auto">{{blog.title}}</h1>
        </div>
        <div class="grid grid-cols-12">
            <div class="col-start-1 col-span-12 md:col-start-3 md:col-span-8 lg:col-start-3">
                <div class="grid grid-cols-12 gap-8">
                    <div class="col-span-12 lg:col-span-4">
                        <template v-if="recents.length > 0 && blog">
                            <h2 class="text-accent font-medium text-3xl ">Recent Posts</h2>
                            <div v-for="recent in recents" class="mt-3 mb-6" v-if="recent.id != blog.id">
                                <h3 class="text-white text-2xl font-medium">{{recent.title}}</h3>
                                <p>{{recent.short_description}}</p>
                                <router-link :to="{ name: 'blog-single', params: { title: getBlogPath(recent.title) }}" class="my-2 block text-lg">
                                    <span class="text-accent uppercase tracking-wider">Read More</span>
                                    <span class="px-2 text-accent">
                                        <i class="fas fa-angle-right"></i>  
                                    </span>  
                                </router-link>
                            </div>
                        </template>
                    </div>
                    <div class="col-span-12 lg:col-span-8 post-content" v-if="blog">
                        <img v-if="blog.featured_image" :src="'/storage/' + blog.featured_image" class="rounded-lg mb-3"/>
                        <div v-html="blog.content"></div>
                    </div>
                </div>
            </div>
        </div>
    </PageWrapper>
</template>
<script>
export default {
    name:"BlogSingle",
    data() {
        return {
            title:null,
            blog:null,
            recents:[]
        }
    },
    metaInfo() {
        return {
            title: this.title,
            meta: [
                { 
                    name: 'description', 
                    content: this.blog ? this.blog.meta_description : '',
                },
            ]
        }
    },
    mounted() {
        var blogTitle = this.$route.params.title;
        if(blogTitle) {
            this.title = blogTitle;
        }

        this.loadBlog();
        this.loadRecent();
    },
    watch:{
        $route (to, from){
            this.loadNewBlog(to.params.title);
        }
    },
    methods: {
        getBlogPath(title) {
            if(title.length > 40) {
				return title.substr(0,40);
			}
            return title;
        },
        loadNewBlog(title) {
            let self = this;
            axios.get("api/blogs/" + title).then(res => {
                self.blog = res.data;
            });
        },
        loadBlog() {
            let self = this;
            axios.get("api/blogs/" + this.title).then(res => {
                self.blog = res.data;
            });
        },
        loadRecent() {
            let self = this;
            axios.get("api/blogs/recent").then(res => {
                self.recents = res.data;
            });
        }
    }
}
</script>