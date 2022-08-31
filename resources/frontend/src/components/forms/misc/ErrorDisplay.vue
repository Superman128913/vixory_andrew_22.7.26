<template>
    <span>
        <span v-for="(error, errorIndex) in errors" :key="errorIndex" class="italic text-red-600 text-sm">{{error}}</span>
    </span>
</template>
<script>
export default {
    name:"ErrorDisplay",
    props: {
        errors: Array,
    }
}
</script>