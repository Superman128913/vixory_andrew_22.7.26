<template>
    <DefaultInput :label="label" :required="required" :errors="errors">
        <template slot="input">
            <input 
                type="text" 
                v-model="content" 
                :required="required"
                v-on:input="updateData" 
                v-mask="mask"/>
        </template>
    </DefaultInput>
</template>
<script>
export default {
    name:"LengthInput",
    props: {
        value: [String],
        label: String,
        errors: Array,
        field: {
            type: Object,
            default: null
        },
        required: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        c_field() {
            return this.field || null;
        }
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
            mask: this.lengthMask,
            show: true,
            content: ""
        }
    },
    mounted() {
        //Hide the input if the field is passed in and is dependent on another field.
        if(this.c_field && this.c_field.dependent_on) {
            this.show = false;
        }
    },
    methods: {
        lengthMask(value) {
            var numbers = value.replace(/[^0-9]/g, '');
            if (numbers.length == 3) {
                return [/\d/, "'", " ", /\d/, /\d/,"''"];
            }
            else {
                return [/\d/, "'", " ", /\d/, "''"];
            }
        },
        updateData() {
            this.$emit("input", this.removeMaskFormatting(this.content));
        }
    }
}
</script>