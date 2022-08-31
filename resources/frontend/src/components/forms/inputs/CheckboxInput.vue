<template>
    <div class="checkbox-option input-wrapper">
        <label>{{label}}<span v-if="required" class="text-red-600"> *</span></label>
        <template v-for="option in options">
            <div :key="option.key" class="checkbox-item">
                <input 
                    class="styled"
                    v-model="content" 
                    type="checkbox" 
                    :id="input_name + option.value" 
                    :name="input_name + option.value" 
                    :value="option.value"
                    v-on:change="updateData">
                <label :for="input_name + option.value" class="inline-block pr-2 px-1">{{option.key}}</label>
            </div>
        </template>
        <span v-for="(error, errorIndex) in errors" :key="errorIndex" class="error-message italic text-red-600 text-sm">{{error}}</span>
    </div>
</template>
<script>
export default {
    name:"CheckboxInput",
    props: {
        value: {
            type:Array,
            default:function(){ return [] }
        },
        errors: Array,
        field: {
            type: Object,
            default: null
        },
        options: Array,
        label: String,
        required: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        input_name: function() {
            return this.label.toLowerCase().replace(/ /g,"_");
        }
    },
    watch: {
        value: {
            handler(value) {
                //Convert initial k/v pairs into an array which can be modified by the select.
                var ids = _.map(value, 'value');
                this.content = ids;
            },
            deep:true,
            immediate: true
        }
    },
    data() {
        return {
            content:[]
        }
    },
    methods: {
        updateData() {
            this.$emit("input", this.convertToKVs());
        },
        convertToKVs() {
            //Convert the array of ids back into a KV pair.
            var kvs = [];
            for(var i = 0; i < this.content.length; i++)
            {
                kvs.push(this.options.find(option => option.value === this.content[i]));
            }
            return kvs;
        }
    }
}
</script>
<style lang="scss">
.compact {
    .checkbox-item {
        @apply whitespace-no-wrap inline;
    }
}
</style>
