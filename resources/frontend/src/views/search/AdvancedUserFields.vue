<template>
    <div class="filter-wrapper p-10 bg-black">
        <SelectInput 
            class="filter-field" 
            label="Sex" 
            :options="sex_options" 
            :field="{table_name:'sex'}"/>


        <!-- If playing level is not highschool (most likely college but could be pro) -->
        <template v-if="playing_level && playing_level != 4">
            <RangeFilter 
                class="filter-field"
                step="0.1"
                :field="{table_name:'college_gpa'}"
                label="College GPA"/>

            <SelectInput 
                class="filter-field" 
                label="School Year" 
                :options="school_year_options" 
                :field="{table_name:'school_year'}"/>
        </template>

        <!-- If playing level is high school -->
        <template v-if="playing_level && playing_level == 4">
            <RangeFilter 
                class="filter-field"
                step="0.1"
                :field="{table_name:'highschool_gpa'}"
                label="High School GPA"/>
        </template>

        <RangeFilter 
            class="filter-field"
            :field="{table_name:'sat'}"
            :min="400"
            :max="1600"
            label="SAT"/>
        <RangeFilter 
            class="filter-field"
            :field="{table_name:'act'}"
            :min="1"
            :max="36"
            label="ACT"/>
        <TextInput 
            class="filter-field" 
            label="City"
            v-model="filters.city"
            :field="{table_name:'city'}"/>
        <SelectInput 
            class="filter-field" 
            label="Country" 
            :field="{table_name:'country'}"
            :options="country_options"/>
        <TextInput 
            class="filter-field" 
            label="Hometown"
            v-model="filters.hometown"
            :field="{table_name:'hometown'}"/>
        <TextInput 
            class="filter-field" 
            label="High School"
            v-model="filters.highschool"
            v-on:input="filterUpdate('highschool', $event)"/>
        <RangeFilter 
            class="filter-field"
            label="Credit Hours"
            :field="{table_name:'credit_hours_completed'}"/>
    </div>
</template>
<script>
export default {
    name:"AdvancedUserFields",
    data() {
        return {
            country_options:[],
            sex_options: [
                {
                    value:0,
                    key:"Male"
                },
                {
                    value:1,
                    key:"Female"
                }
            ],
            school_year_options: [],
        }
    },
    computed: {
        filters: {
            get() {
                return this.$store.getters.filters;
            },
            set(value) {}
        },
        playing_level() {
            return this.$store.getters.playingLevel;
        }
    },
    mounted() {
        this.loadCountries();
        this.loadSchoolYear();
    },
    methods: {
        loadCountries()
        {
            let self = this;
            axios.get("api/enums/countries").then(res => {
                self.country_options = res.data;
            });
        },
        loadSchoolYear()
        {
            let self = this;
            axios.get("api/enums/school-year").then(res => {
                self.school_year_options = res.data;
            });
        },
    }
}
</script>