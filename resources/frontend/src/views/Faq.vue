<template>
    <PageWrapper :image="'/images/design/soccer_background.jpg'" imageClass="bg-left-bottom" :padding="false">
        <!-- Intro Section -->
        <div class="grid grid-cols-12 gap-4 my-20 lg:my-64">
            <div class="col-start-1 col-span-12 md:col-start-3 md:col-span-8 lg:col-start-3 lg:col-span-4">
                <h1 class="text-white">FAQ</h1>
                <hr class="heading-hr">
                <p>Have a question not listed here? Reach out to us at <a class="accent" href="mailto:info@vixory.com">info@vixory.com</a> and we'll respond as soon as possible.</p>
            </div>
        </div>
        <div class="grid grid-cols-12 gap-4">
            <div class="col-start-1 col-span-12 md:col-start-3 md:col-span-8">
                <div class="my-4" v-for="faq in faqs">
                    <div class="text-accent text-2xl">{{faq.question}}</div>
                    <div class="text-white">{{faq.answer}}</div>
                </div>
            </div>
        </div>
    </PageWrapper>
</template>
<script>
export default {
    name:"FAQ",
    data() {
        return {
            faqs:false
        }
    },
    mounted() {
        this.loadFAQs();
    },
    methods: {
        loadFAQs() {
            let self = this;
            axios.get("api/faqs").then(res => {
                self.faqs = res.data;
            }).catch(error => {
                self.$noty.error("There was an error loading the FAQs.");
            });
        }
    }
}
</script>