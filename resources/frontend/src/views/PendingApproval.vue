<template>
    <PageWrapper layout="boxed">
        <div class="bg-gray-900 rounded border-gray-alt2 border max-w-2xl m-auto">
            <template v-if="!isRejected">
                <h1 class="p-8 dm-sans capitalize text-white text-2xl leading-none">Under Review</h1>
                <hr>
                <p class="p-8">Coach registrations are manually reviewed by our staff to ensure accuracy. If you haven’t been notified within 48 hours, or if you have any other questions, please contact <a href="mailto:info@vixory.com">info@vixory.com</a></p>
            </template>
            <template v-else>
                <h1 class="p-8 dm-sans capitalize text-white text-2xl leading-none">Registration Declined</h1>
                <hr>
                <p class="p-8">Your registration was rejected. If you believe this decision was made in error, please contact us at <a href="mailto:info@vixory.com">info@vixory.com</a></p>
            </template>
        </div>
    </PageWrapper>
</template>
<script>
export default {
    name:"PendingApproval",
    mounted() {
        this.pendingApproval();
    },
    computed: {
        isRejected() {
            return this.$store.getters.isRejected;
        }
    }
}
</script>