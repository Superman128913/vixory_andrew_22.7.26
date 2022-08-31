<template>
    <div class="newsletter-wrapper grid grid-cols-12 my-4">
        <input type="text" class="col-span-8 p-1 rounded-l rounded-r-none h-full"/>
        <button class="col-span-4 bg-accent rounded-r rounded-l-none">Send</button>
    </div>
</template>
<script>
export default {
    name:"Newsletter"
}
</script>
<style scoped>
.newsletter-wrapper > input {
    border-top-right-radius:0px;
    border-bottom-right-radius:0px;
}
</style>