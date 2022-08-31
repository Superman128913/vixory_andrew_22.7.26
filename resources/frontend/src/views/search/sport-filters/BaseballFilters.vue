<template>
    <div>
        <div class="p-10 filter-wrapper">
            <template v-if="sport.sportpositions.length > 0">
                <SelectInput 
                    class="filter-field"
                    label="Position"
                    :field="{
                        table_name:'baseball_positions'
                    }"
                    :options="modelsToKV(sport.sportpositions)"/>
            </template>

            <template v-for="field in fields">
                <component 
                    v-bind:is="getFieldsFilterComponentName(field)"
                    class="filter-field"
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
    name:"BaseballFilters",
    props: ["fields"],
    computed: {
        sport() {
            return this.$store.getters.getSport("Baseball");
        }
    }
}
</script>