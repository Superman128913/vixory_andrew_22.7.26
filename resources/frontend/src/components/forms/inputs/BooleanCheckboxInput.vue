<template>
    <div class="input-wrapper checkbox-option"> 
        <label>{{label}}</label>
        <input 
            class="styled"
            :id="input_name" 
            type="checkbox"
            v-model="content"
            v-on:input="updateData">
        <span v-for="(error, errorIndex) in errors" :key="errorIndex" class="error-message italic text-red-600 text-sm">{{error}}</span>
    </div>
</template>
<script>
export default {
    name:"BooleanCheckboxInput",
    props: {
        label: String,
        field: {
            type: Object,
            default: null
        },
        value: {
            type:[Boolean, Number],
            default: false,
        },
        errors: Array,
    },
    computed: {
        input_name: function() {
            return this.label.toLowerCase().replace(/ /g,"_");
        }
    },
    data() {
        return {
            content: !!this.value
        }
    },
    methods: {
        updateData() {
            this.content = ! this.content;
            this.$emit("input", this.content);
        }
    }
}
</script>