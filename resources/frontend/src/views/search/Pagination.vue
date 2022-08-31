<template>
    <ul v-if="pagination.last_page" class="flex m-auto justify-center">
        <li v-on:click="previous" v-if="pagination.current_page !== 1" class="text-accent cursor-pointer">
            <i class="fas fa-chevron-left"></i>
        </li>
        <li class="text-accent cursor-pointer px-4">
            {{pagination.current_page}} of {{pagination.last_page}}
        </li>
        <li v-on:click="next" v-if="pagination.current_page !== pagination.last_page" class="text-accent cursor-pointer">
            <i class="fas fa-chevron-right"></i>
        </li>
    </ul>
</template>
<script>
export default {
    name:"Pagination",
    props: {
        pagination:{
            type:Object,
            default:null
        }
    },
    data() {
        return {}
    },
    methods: {
        previous() {
            this.$emit("page-change", this.pagination.current_page - 1);
        },
        next() {
            this.$emit("page-change", this.pagination.current_page + 1);
        }
    }
}
</script>