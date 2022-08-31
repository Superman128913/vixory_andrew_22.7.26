<template>
    <DefaultInput :label="label" class="date-wrapper" :errors="errors">
        <template slot="input">
            <input 
                type="date"
                v-model="content" 
                v-on:input="updateData" 
                :aria-label="label" 
                :required="required"
                class="date-input">
        </template>
    </DefaultInput>
</template>
<script>
export default {
    name:"DateInput",
    props: {
        value: {
            type:[String, Number],
            default:""
        },
        label: String,
        errors: Array,
        required: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            content: ""
        }
    },
    mounted() {
        if(this.value) {
            this.content = this.value;
        }
    },
    methods: {
        updateData() {
            this.$emit("input", this.content);
        }
    }
}
</script>
<style scoped>
.date-wrapper .date-input {
    min-height:30px;
}
</style>