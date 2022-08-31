<template>
    <div class="input-wrapper range-filter" v-if="show">
        <label>
            {{label}}
            <span v-if="field && field.suffix"> ({{field.suffix}})</span>
        </label>
        <div class="flex items-center">
                <input 
                    :class="{'has-suffix': suffix}"
                    type="number" 
                    :step="step"
                    v-model="min_value" 
                    v-on:change="updateMin" 
                    v-if="! mask"
                    :min="min"
                    :max="max"
                />
                <template v-else>
                    <input 
                        :class="{'has-suffix': suffix}"
                        type="text" 
                        v-model="min_value" 
                        v-on:change="updateMin" 
                        v-mask="mask"/>
                </template>

                <div v-if="suffix" class="suffix">{{suffix}}</div>

            <div class="range-divider"></div>

                <input 
                    :class="{'has-suffix': suffix}"
                    type="number" 
                    :step="step"
                    v-model="max_value" 
                    v-on:change="updateMax" 
                    v-if="! mask"
                    :min="min"
                    :max="max"
                />
                <template v-else>
                    <input 
                        :class="{'has-suffix': suffix}"
                        type="text" 
                        v-model="max_value" 
                        v-on:change="updateMax" 
                        v-mask="mask"/>
                </template>
                <div v-if="suffix" class="suffix">{{suffix}}</div>
        </div>
    </div>
</template>
<script>
import { bus } from '../../../main';
export default {
    name:"RangeFilter",
    props: {
        label:String,
        field: {
            type: Object,
            default: null
        },
        mask:{
            type:String,
            default:null
        },
        cleanValue: {
            type:Boolean,
            default:true
        },
        suffix: {
            type:[String, Boolean],
            default:false
        },
        min: {
            type: [Number, Boolean],
            default: false
        },
        max: {
            type: [Number, Boolean],
            default: false
        },
        step: {
            type: String,
            default: "1"
        }
    },
    data() {
        return {
            min_value: null,
            max_value: null,
            show: true
        }
    },
    mounted() {
        bus.$on('clearAllInputs', (data) => {
            this.min_value = null;
            this.max_value = null;
        })
    },
    methods: {
        loadDefaults() {
            this.min_value = this.$store.getters.getFilter(this.field.table_name + "_min");
            this.max_value = this.$store.getters.getFilter(this.field.table_name + "_max");
        },
        updateMin() {
            let value = this.min_value;

            if(this.mask) {
                value = this.removeMaskFormatting(this.min_value);
            }

            this.filterUpdate(this.field.table_name + "_min", value);
        },
        updateMax() {
            let value = this.max_value;

            if(this.mask) {
                value = this.removeMaskFormatting(this.max_value);
            }

            this.filterUpdate(this.field.table_name + "_max", value);
        }
    },
    created() {
        this.loadDefaults();
    }
}
</script>
<style lang="scss">
.range-divider {
    height:1px;
    width:30px;
    margin:10px;
    background-color:#525252;
}
</style>