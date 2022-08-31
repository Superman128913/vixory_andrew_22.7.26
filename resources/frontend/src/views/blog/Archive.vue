<template>
    <PageWrapper :image="'/images/design/soccer_background.jpg'" imageClass="bg-left-bottom" :padding="false">
        <!-- Intro Section -->
        <div class="grid grid-cols-12 gap-4 my-20 lg:my-64" v-if="featured">
            <div class="col-start-1 col-span-12 md:col-start-3 md:col-span-8 lg:col-start-3 lg:col-span-4">
                <div class="text-white text-xl font-bold uppercase">Featured Story</div>
                <h1 class="text-accent mb-3">{{featured.title}}</h1>
                <div v-html="featured.short_description"></div>
                <router-link :to="{ name: 'blog-single', params: { title: getBlogPath(featured.title) }}" class="my-4 block text-lg">
                    <span class="text-accent uppercase font-bold tracking-wider">Read More</span>
                    <span class="px-2 text-accent">
                        <i class="fas fa-angle-right"></i>  
                    </span>  
                </router-link>
            </div>
        </div>

        <!-- Blog grid list -->
        <div class="grid grid-cols-12">
            <div class="col-start-1 col-span-12 md:col-start-3 md:col-span-8 lg:col-start-3">
                <div class="grid grid-cols-12 gap-8 gap-y-12 lg:mx-auto">
                    <template v-for="blog in blogs">
                        <div class="col-span-12 lg:col-span-4">
                            <img v-if="blog.featured_image" :src="'/storage/' + blog.featured_image" class="rounded-lg mb-4"/>
                            <div v-if="blog.blog_category" class="text-white uppercase text-lg norwester tracking-widest -mb-1">
                                {{blog.blog_category.title}}
                            </div>
                            <router-link :to="{ name: 'blog-single', params: { title: getBlogPath(blog.title) }}" class="block text-lg text-4xl cursor-pointer font-medium" tag="h3">{{blog.title}}</router-link>
                            <div>{{blog.short_description}}</div>
                            <router-link :to="{ name: 'blog-single', params: { title: getBlogPath(blog.title) }}" class="my-4 block text-lg">
                                <span class="text-accent uppercase font-bold tracking-wider">Read More</span>
                                <span class="px-2 text-accent">
                                    <i class="fas fa-angle-right"></i>  
                                </span>  
                            </router-link>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center" v-if="pagination.last_page != 1">
            <div class="flex text-white text-xl cursor-pointer">
                <a v-if="pagination.prev_page_url" :href="'/blog/page/' + (pagination.current_page - 1)">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <a v-if="pagination.prev_page_url" class="mx-3 px-1" :href="'/blog/page/' + (pagination.current_page - 1)">
                    {{pagination.current_page - 1}}
                </a>
                <a class="mx-3 px-1 border-b">
                    {{pagination.current_page}}
                </a>
                <a v-if="pagination.next_page_url" class="mx-3 px-1" :href="'/blog/page/' + (pagination.current_page + 1)">
                    {{pagination.current_page + 1}}
                </a>
                <a v-if="pagination.next_page_url" :href="'/blog/page/' + (pagination.current_page + 1)">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>
    </PageWrapper>
</template>
<script>
export default {
    name:"BlogArchive",
    data() {
        return {
            featured:null,
            blogs:[],
            pagination: {
                current_page:1,
                last_page:null,
                prev_page_url:null,
                next_page_url:null
            }
        }
    },
    mounted() {
        var page = this.$route.params.pagination;
        if(page) {
            this.pagination.current_page = page;
        }

        this.loadBlogs();
        this.loadRecent();
    },
    methods: {
        getBlogPath(title) {
            if(title.length > 40) {
				return title.substr(0,40);
			}
            return title;
        },
        loadBlogs() {
            let self = this;
            axios.get("api/blogs?page=" + this.pagination.current_page).then(res => {
                self.blogs = res.data.data;

                self.pagination.current_page= res.data.current_page;
                self.pagination.last_page = res.data.last_page;
                self.pagination.prev_page_url = res.data.prev_page_url;
                self.pagination.next_page_url = res.data.next_page_url;
            }).catch(error => {
                self.$noty.error("There was an error loading the blog posts.");
            });
        },
        loadRecent() {
            let self = this;
            axios.get("api/blogs/featured").then(res => {
                self.featured = res.data;
            }).catch(error => {
                self.$noty.error("There was an error loading the featured blog.");
            });
        }
    }
}
</script>