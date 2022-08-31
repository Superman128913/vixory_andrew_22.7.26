<template>
    <div class="absolute w-full bottom-0">
        <hr>
        <div class="p-4 flex justify-center">
            <router-link :to="to" class="btn plain flex items-center">
                <slot></slot>
            </router-link>
        </div>
    </div>
</template>
<script>
export default {
    name:"AccountFooter",
    props:["to"]
}
</script>