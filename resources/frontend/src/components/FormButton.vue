<template>
    <div>
        <button v-on:click="buttonClick">
            <span>{{text}}</span>
        </button>
        <div v-if="loading" class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
    </div>
</template>
<script>
export default {
    name:"FormButton",
    props: {
        text: {
            type: String,
            default: ""
        },
        loading: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        buttonClick() {
            this.$emit("buttonClick");
        }
    }
}
</script>