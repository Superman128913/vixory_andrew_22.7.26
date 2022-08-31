<template>
    <span class="accent-mark block" v-bind:style="{
        width: width, 
        height: height,
        marginRight: marginX,
        marginLeft: marginX,
        marginTop: marginTop,
        marginBottom: marginBottom
    }"></span>
</template>
<script>
export default {
    name:"AccentMark",
    props: {
        width: {
            type: [Number, String],
            default: '64px'
        },
        height: {
            type: [Number, String],
            default: '1px'
        },
        marginX: {
            type: [Number, String],
            default: 'inherit'
        },
        marginTop: {
            type: [Number, String],
            default: '0.25rem'
        },
        marginBottom: {
            type: [Number, String],
            default: '0.5rem'
        }
    }
}
</script>