<template>
    <DefaultInput :label="label" :errors="errors" :required="required">
        <template slot="input">
            <div class="flex items-center">
                <input 
                    type="number" 
                    v-model="content"
                    :class="{'has-suffix': suffix}" 
                    v-on:input="updateData" 
                    :step="step" 
                    :min="min" 
                    :max="max">
                <div 
                    v-if="suffix" 
                    class="suffix">
                    {{suffix}}
                </div>
            </div>
        </template>
    </DefaultInput>
</template>
<script>
export default {
    name:"NumberInput",
    props: {
        value: [Number, String],
        label: String,
        errors: Array,
        field: {
            type: Object,
            default: null
        },
        step: {
            type:String,
            default:"1"
        },
        min: {
            type:[Number, Boolean],
            default:0
        },
        max: {
            type:[Number, Boolean],
            default:false
        },
        suffix: {
            type:[String, Boolean],
            default:false
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
    beforeDestroy() {
        this.$eventHub.$off('input-change', this.addTodo)
    },
    methods: {
        updateData() {
            if(! parseFloat(this.step) % 1) {
                this.$emit("input", parseInt(this.content));
            }
            else {
                this.$emit("input", parseFloat(this.content));
            }
            
        }
    }
}
</script>