<template>
    <div class="p-10 pb-32">
        <div v-if="articles.length > 0">
            <h1 class="account-header pb-10">Articles</h1>
            <template v-for="article in articles">
                <div class="p-4 rounded-lg mb-4 bg-gray-900 border-2 border-gray-alt2">
                    <img :src="article.featured_image" v-if="article.featured_image"/>
                    <div class="mb-4 mt-4">
                        <h3 class="text-lg">{{article.name}}</h3>
                        <p class="text-gray-500">{{article.description}}</p>
                    </div>
                    <a :href="article.link" class="btn" target="_blank">View Story</a>
                    <template v-if="article.id">
                        <router-link :to="{ name: 'single-article', params: { id: article.id }}" class="btn mx-2">
                            Edit
                        </router-link>
                    </template>
                    <template v-else>
                        <router-link :to="{name:'new-article'}" class="btn mx-2">
                            Edit
                        </router-link>
                    </template>
                </div>
            </template>
        </div>
        <div v-else class="nothing-message">
            No Articles Found
        </div>
        <AccountFooter :to="{name:'new-article'}">
            <i class="far fa-plus-circle"></i>
            <span class="px-3">Add Article</span>
        </AccountFooter>
    </div>
</template>
<script>
export default {
    name:"Articles",
    data() {
        return {
            articles:[],
        }
    },
    mounted() {
        this.loadArticles();
    },
    methods: {
        loadArticles() {
            let self = this;
            axios.get("api/article").then(res => {
                self.articles = res.data;
            });
        },
    }
}
</script>