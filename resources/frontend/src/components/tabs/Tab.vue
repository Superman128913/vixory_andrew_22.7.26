<template>
    <div class="tab" v-if="isActive">
        <slot></slot>
        <div class="inline-block w-full p-4" v-if="this.$slots.footer">
            <slot name="footer"></slot>
        </div>
    </div>
</template>
<script>
export default {
    name:"Tab",
    data() {
        return {
            isActive: false
        }
    },
    computed: {
        href() {
            return '#' + this.name.toLowerCase().replace(/ /g, '-');
        }
    },
    mounted() {
        this.isActive = this.selected;
    },
    props: {
        name: {
            type: String,
            required: true
        },
        icon: {
            type: String,
            default: null
        },
        selected: {
            default: false
        }
    }
}
</script>