<template>
    <div class="border border-gray-alt2 rounded mx-10 bg-black">
        <div class="flex justify-between items-center">
            <div class="px-4 py-3 text-accent text-2xl font-bold cursor-pointer" v-on:click="toggle">{{title}}</div>

            <div 
                class="carrot-down text-accent text-3xl px-4 py-3 cursor-pointer" 
                :class="{'rotating': expanded}"
                v-on:click="toggle">

                <i class="far fa-angle-down" v-if="expanded"></i>
            </div>
        </div>
        <hr>
        <template v-if="expanded">
            <slot></slot>
        </template>
    </div>
</template>
<script>
export default {
    name:"FieldPanel",
    props: {
        title: {
            type:String,
            default:"Title Missing"
        }
    },
    data() {
        return {
            expanded: true,
        }
    },
    methods: {
        toggle() {
            this.expanded = ! this.expanded;
        }
    }
}
</script>
<style scoped>
    .carrot-down {
        transition: transform 1s ease-in-out;
    }
    .rotating {
        transform: rotateZ(180deg);
    }
</style>