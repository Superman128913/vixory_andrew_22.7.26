<template>
    <div class="bg-black my-6 rounded border-gray-alt2 border" v-if="user.rapsodo_media || user.blast_media || user.trackman_media">
        <h3 class="p-4 minor-heading">
            <span class="text-accent">
                <i class="far fa-chart-line"></i>
            </span>
            <span class="px-2">Analytics</span>
        </h3>
        <hr>
        <div class="grid grid-cols-12 p-4 px-6">
            <div class="col-span-12 lg:col-span-4" v-if="user.rapsodo_media">
                <div>Rapsodo</div>
                <a :href="user.rapsodo_media.download_url" target="_blank">
                    <img class="rounded-lg my-2 bg-black hover:opacity-75" :src="user.rapsodo_media.thumb_url"/>
                </a>
            </div>
            <div class="col-span-12 lg:col-span-4" v-if="user.trackman_media">
                <div>Trackman</div>
                <a :href="user.trackman_media.download_url" target="_blank">
                    <img class="rounded-lg my-2 bg-black hover:opacity-75" :src="user.trackman_media.thumb_url"/>
                </a>
            </div>
            <div class="col-span-12 lg:col-span-4" v-if="user.blast_media">
                <div>Blast</div>
                <a :href="user.blast_media.download_url" target="_blank">
                    <img class="rounded-lg my-2 bg-black hover:opacity-75" :src="user.blast_media.thumb_url"/>
                </a>
            </div>
        </div>

    </div>
</template>
<script>
export default {
    name:"SportsAnalytics",
    props:['user']
}
</script>
