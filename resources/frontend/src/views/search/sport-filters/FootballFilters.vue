<template>
    <div>
        <div class="p-10 filter-wrapper">
            <template v-for="field in fields">
                <component 
                    class="filter-field"
                    v-bind:is="getFieldsFilterComponentName(field)"
                    v-if="field.search_visible" 
                    :key="field.id"
                    :field="field" 
                    :label="field.pretty_name"
                    :options="sport.enums[field.table_name]"
                />
            </template>
        </div>
    </div>
</template>
<script>
export default {
    name:"FootballFilters",
    props: ["fields"],
    computed: {
        sport() {
            return this.$store.getters.getSport("Football");
        }
    }
}
</script>