<template>
    <DefaultInput :label="label" class="select-option" :required="required" :errors="errors" v-if="show">
        <template slot="input">
            <select v-model="content" v-on:change="updateData($event)">
                <option :value="null">{{prompt}}</option>
                <option v-for="option in options" :value="option.value" :key="option.value">
                    {{option.description || option.key}}
                </option>
            </select>
        </template>
    </DefaultInput>
</template>
<script>
import { bus } from '../../../main';
export default {
    name:"SelectInput",
    props: {
        value: {
            type:[Number, String],
            default:undefined
        },
        errors: Array,
        field: {
            type: Object,
            default: null
        },
        options: Array,
        label: String,
        prompt: {
            type: String,
            default: "Please select an option..."
        },
        required: {
            type: Boolean,
            default: false
        },
    },
    mounted() {
        this.loadDefaults();
    
        bus.$on('clearAllInputs', (data) => {
            this.content = undefined;
        })
    },
    computed: {
        c_name() {
            return this.field ? this.field.table_name : "generic_select_input";
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
            content:null,
            show: true
        }
    },
    methods: {
        loadDefaults() {
            let fieldValue = this.$store.getters.getFilter(this.field.table_name);
            if(typeof fieldValue == 'undefined') {
                //If vuex doesn't have the value than the SelectInput is on the profile or sports page.
                this.content = this.value;
            }
            else {
                this.content = fieldValue;
            }
        },
        updateData(e) {
            //Standard event which allows v-model to bind with this component.
            this.$emit("input", e.target.value);
            this.filterUpdate(this.field.table_name, this.content);

            //Event for conditional rendering.
            let self = this;
            this.$eventHub.$emit('input-change', { 
                name: self.c_name,
                value: e.target.value
            })
        },
        setValue(val) {
            this.content = val;
        }
    }
}
</script>
