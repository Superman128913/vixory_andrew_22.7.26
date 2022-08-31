<template>
    <DefaultInput :label="label" :errors="errors" :required="required">
        <template slot="input">
            <input type="text" v-model="content" v-on:input="updateData" v-mask="'(###) ###-####'">
        </template>
    </DefaultInput>
</template>
<script>
export default {
    name:"PhoneInput",
    props: {
        value:String,
        label:String,
        errors: Array,
        field: {
            type: Object,
            default: null
        },
        required: {
            type: Boolean,
            default: false
        },
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
            content: ""
        }
    },
    methods: {
        updateData() {
            this.$emit("input", this.content);
        }
    }
}
</script>