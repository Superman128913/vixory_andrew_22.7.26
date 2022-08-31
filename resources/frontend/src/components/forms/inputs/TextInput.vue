<template>
    <DefaultInput :label="label" :errors="errors" :settings="settings" :required="required" class="relative">
        <template slot="input">
            <input 
                :type="type"
                v-model="content" 
                v-on:input="updateData" 
                :aria-label="label" 
                :placeholder="placeholder" 
                :required="required"
                :autocomplete="autocomplete">
            <div class="loading-wrapper absolute" v-if="loading">
                <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
            </div>
        </template>
    </DefaultInput>
</template>
<script>
import { bus } from '../../../main';
export default {
    name:"TextInput",
    props: {
        value: [String, Number],
        label: String,
        placeholder: String,
        settings: Object,
        errors: Array,
        field: {
            type: Object,
            default: null
        },
        type: {
            type: String,
            default: "text"
        },
        loading: {
            type: Boolean,
            default: false
        },
        required: {
            type: Boolean,
            default: false
        },
        autocomplete: {
            type: String,
            default: ''
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
        bus.$on('clearAllInputs', (data) => {
            this.content = null;
        })
    },
    methods: {
        updateData() {
            this.$emit("input", this.content);
        }
    }
}
</script>
<style scoped>
.loading-wrapper {
    right: 10px;
    bottom: 6px;
    background-color: rgba(0,0,0,0.8);
}
</style>