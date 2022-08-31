<template>
    <div class="input-wrapper">
        <label v-if="label && showLabels">{{label}}<span v-if="required" class="text-red-600"> *</span></label>
        <slot name="input"></slot>

        <span v-for="(error, errorIndex) in errors" :key="errorIndex" class="error-message italic text-red-600 text-sm">{{error}}</span>
    </div>
</template>
<script>
export default {
    name:"DefaultInput",
    props: {
        label: {
            type:String,
            default:""
        },
        errors: Array,
        settings: Object,
        required: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        showLabels: function() {
            if (this.settings && this.settings.labels && this.settings.labels === 'hidden') {
                return false;
            }
            return true;
        }
    }
}
</script>