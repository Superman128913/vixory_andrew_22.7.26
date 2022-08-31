<template>
    <div class="input-wrapper py-2">
        <div class="checkbox-item relative">
            <div class="float-left py-2">
                <input class="styled" type="checkbox" name="boolean-consent" v-model="consent_value"/>
            </div>
            <label class="checkbox-text inline-block mb-0 px-3 float-left" for="boolean-consent">
                <slot></slot>
            </label>
        </div>
        <span v-for="(error, errorIndex) in errors" :key="errorIndex" class="error-message italic text-red-600 text-sm">{{error}}</span>
    </div>
</template>
<script>
export default {
    name:"BooleanConsent",
    props: {
        errors: Array,
    },
    data() {
        return {
            consent_value:false,
        }
    },
    watch: {
        consent_value() {
            this.$emit('input', this.consent_value);
        }
    }
}
</script>
<style scoped>
.consent-checkbox {
    width:20px;
}
.checkbox-text {
    width:calc(100% - 34px);
}
</style>