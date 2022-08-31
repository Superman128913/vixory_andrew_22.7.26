<template>
    <DefaultInput :label="label" class="radio-option" :errors="errors">
        <template slot="input">
            <span v-for="option in options" :key="option.value" class="whitespace-no-wrap">
                <input 
                    class="styled"
                    v-model="content" 
                    type="radio" 
                    :id="input_name + option.value"
                    :name="input_name + option.value" 
                    :value="option.value"
                    v-on:input="updateData(option.value)">
                <label :for="input_name + option.value" class="inline-block pr-2">{{option.description || option.key}}</label>
            </span>
        </template>
    </DefaultInput>
</template>
<script>
export default {
    name:"RadioInput",
    props: {
        value: Number,
        options: Array,
        label: String,
        errors: Array,
        field: {
            type: Object,
            default: null
        },
        defaultValue: {
            type:[Number, String],
            default:null
        }
    },
    computed: {
        input_name() {
            return this.label.toLowerCase().replace(/ /g,"_");
        },
        field_name() {
            return this.field.table_name || "";
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
            content: ""
        }
    },
    mounted() {
        //If no initial value is given, see if a default value is provided.
        if(! this.value && this.defaultValue) {
            this.content = this.defaultValue;
        }
    },
    methods: {
        updateData(value) {
            this.$emit("input", value);
            this.filterUpdate(this.field.table_name, value);

            /**
             * Event hub event for conditional rendering.
             * Note: In order for conditional rendering to function, the input must utilize the field prop.
             */
            if(this.field){
                this.$eventHub.$emit('input-change', { 
                    name: this.field.table_name,
                    value: value
                })
            }
        }
    }
}
</script>