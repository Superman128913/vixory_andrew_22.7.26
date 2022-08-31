<template>
    <DefaultInput :label="label" :errors="errors">
        <template slot="input">
            <textarea v-model="content" rows="4" cols="50" v-on:input="updateData"></textarea>
        </template>
    </DefaultInput>
</template>
<script>
export default {
    name:"TextareaInput",
    props: {
        value: String,
        errors: Array,
        field: {
            type: Object,
            default: null
        },
        label: String
    },
    watch: {
        value: {
            handler: function(val) {
                this.content = val;
            },
            immediate: true
        }
    },
    data() {
        return {
            content:"",
        }
    },
    methods: {
        updateData() {
            this.$emit("input", this.content);
        }
    }
}
</script>