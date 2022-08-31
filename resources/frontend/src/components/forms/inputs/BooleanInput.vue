<template>
    <div class="input-wrapper flex items-center w-full"> 
        <!-- Toggle Button -->
        <label :for="input_name" class="flex items-center cursor-pointer">
            <!-- toggle -->
            <div class="relative">
                <input ref="toggle" :id="input_name" type="checkbox" class="hidden" v-on:input="updateData"/>
                <!-- line --><div class="toggle__line w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div> 
                <!-- dot --><div class="toggle__dot absolute w-6 h-6 bg-white rounded-full shadow inset-y-0 left-0"></div>
            </div>

            <!-- label -->
            <div class="ml-3 text-white font-medium">
                {{label}}
            </div>
        </label>
    </div>
</template>
<script>
export default {
    name:"BooleanInput",
    props: {
        label: String,
        field: {
            type: Object,
            default: null
        },
        value: [Boolean, Number],
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
    mounted() {
        if(this.content) {
            this.$refs.toggle.checked = true;
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