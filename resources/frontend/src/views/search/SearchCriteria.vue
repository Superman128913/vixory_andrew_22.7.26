<template>
    <form 
        id="criteria-form" 
        v-on:submit.prevent="search"
        class="search-criteria-wrapper" 
        v-if="!savedSearch || Object.keys(filters).length > 0">

        <!-- Sport Selection -->
        <div class="col-span-12">
            <div class="flex flex-wrap justify-center items-center mx-4 my-8">
                <div class="hidden md:block p-2">Sport</div>
                <div v-for="sport in sports_full" :key="sport.id" class="float-left md:float-none">
                    <label class="sport-checkbox flex md:mx-4 md:my-1">
                        <input 
                            v-model="sports_selected" 
                            type="checkbox" 
                            v-on:change="handleRemoval(sport.id)"
                            :name="sport.id" 
                            :value="sport.id">
                        <span class="checkbox-option rounded-full border border-gray-alt2 m-2 px-4 py-2 cursor-pointer">
                            <span class="mr-2 icon">
                                <i :class="sport.icon_class"></i>
                            </span>
                            {{sport.name}}
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Common Criteria Selection -->
        <div class="filter-wrapper m-4 mb-8 md:mx-8 lg:mx-32">
            <div class="col-span-12 md:col-span-6 lg:col-span-3 w-full">
                <RangeFilter 
                    label="Age"
                    class="filter-field mx-4 md:m-0"
                    :min="13"
                    :max="100"
                    :field="{table_name:'age'}"/>
            </div>
            <div class="col-span-12 md:col-span-6 lg:col-span-3">
                <RangeFilter 
                    class="col-span-4 filter-field mx-4 md:m-0"
                    :mask="'#\' ##\'\''"
                    :field="{table_name:'height'}"
                    label="Height"/>
            </div>
            <div class="col-span-12 md:col-span-6 lg:col-span-3">
                <RangeFilter
                    class="col-span-4 filter-field mx-4 md:m-0"
                    :field="{table_name:'weight'}"
                    suffix="lbs" 
                    label="Weight"/>
            </div>
            <div class="col-span-12 md:col-span-6 lg:col-span-3">
                <SelectInput 
                    label="Playing Level" 
                    class="filter-field mx-4 md:m-0"
                    :field="{table_name:'playing_level'}"
                    :options="playing_levels_options"/>
            </div>
        </div>

        <!-- Search Button -->
        <div class="flex justify-center relative">
            <button class="search" type="submit">Search</button>
        </div>
        <hr>

        <!-- Additional Actions -->
        <div class="flex flex-wrap justify-center pt-10 pb-4">
            <button v-if="savedSearch" v-on:click="updateSearch" class="minimal">
                <i class="fas fa-list-alt"></i>
                <span class="px-2">Update Saved Search</span>
            </button>
            <button v-if="!savedSearch" v-on:click="saveSearch" class="minimal">
                <span class="px-2">Save</span>
                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                    <path d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 10H2v2h12v-2zm0-4H2v2h12V6zm4 8v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zM2 16h8v-2H2v2z" fill="white"/>
                </svg>
            </button>
            <router-link tag="button" class="minimal" :to="{name:'saved-searches'}">
                <span class="px-2">View Saved Searches</span>
                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                    <path d="M0 0h24v24H0z" fill="none"/>
                    <path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z" fill="white"/>
                </svg>
            </router-link>
            <button class="border-0 bg-black m-3" v-on:click="resetFilters">Reset Filters</button>
        </div>

        <button v-on:click="showAdvanced" class="advanced-filter-btn gray text-center block bg-black relative m-auto">
            Show Advanced Filters
            <i class="fas fa-filter"></i>
        </button>

        <!-- Advanced User Fields -->
        <template v-if="show_advanced">
            <div class="bg-black py-10">
                <FieldPanel title="Player Statistics" class="mt-10">
                    <AdvancedUserFields :searchData="searchData"/>
                </FieldPanel>

                <FieldPanelDivider v-if="baseball_selected"/>
                <FieldPanel title="Baseball Stats" v-if="baseball_selected && sport_fields.baseball">
                    <BaseballFilters :fields="sport_fields.baseball.fields"/>
                </FieldPanel>

                <FieldPanelDivider v-if="basketball_selected"/>
                <FieldPanel title="Basketball Stats" v-if="basketball_selected && sport_fields.basketball">
                    <BasketballFilters :fields="sport_fields.basketball.fields"/>
                </FieldPanel>

                <FieldPanelDivider v-if="football_selected"/>
                <FieldPanel title="Football Stats" v-if="football_selected && sport_fields.football">
                    <FootballFilters :fields="sport_fields.football.fields"/>
                </FieldPanel>

                <FieldPanelDivider v-if="soccer_selected"/>
                <FieldPanel title="Soccer Stats" v-if="soccer_selected && sport_fields.soccer">
                    <SoccerFilters :fields="sport_fields.soccer.fields"/>
                </FieldPanel>

                <FieldPanelDivider v-if="softball_selected"/>
                <FieldPanel title="Softball Stats" v-if="softball_selected && sport_fields.softball">
                    <SoftballFilters :fields="sport_fields.softball.fields"/>
                </FieldPanel>
                <FieldPanelDivider v-if="tennis_selected"/>
                <FieldPanel title="Tennis Stats" class="mb-10" v-if="tennis_selected && sport_fields.tennis">
                    <TennisFilters :fields="sport_fields.tennis.fields"/>
                </FieldPanel>
            </div>
        </template>
    </form>
</template>
<script>
import { bus } from '../../main'

export default {
    name:"SearchCriteria",
    props: {
        savedSearch: {
            type: [Number, Boolean],
            default: false
        }
    },
    data() {
        return {
            loaded: false,
            search_across_sports: false, //Whether this is a single or multi sport search
            show_advanced: true, //Toggle the advanced options dropdown
            sport_id: null, //The sport selected in single sport search
            sports:[], //List of all sports
            searchData:{},
            playing_levels_options:[],
            sport_fields:[],
            input_sports_selected:[],
        }
    },
    watch: {
        search_across_sports(val) {
            //When switching from checkboxes to select, clear the array except for the first element.
            if(! val && this.sports_selected.length > 0) {
                let firstElement = this.sports_selected[0];
                this.$store.commit("setSportsSelected", [firstElement]);

                //Update the select value
                this.$refs.sport_single.setValue(firstElement["value"]);
            } 
        },
        sports_selected: {
            handler: function(val) {
                if(! this.loaded) {
                    this.loaded = true;
                    this.setupInitialSportsData();
                }
            },
            deep:true
        }
    },
    computed: {
        filters: {
            get() {
                return this.$store.getters.filters;
            },
            set(value) {}
        },
        sports_selected: {
            get() {
                return this.$store.getters.sportsSelected;
            },
            set(values) {}
        },
        sports_full() {
            return this.$store.getters.sports;
        },
        baseball_selected() {
            return this.$store.getters.baseballSelected;
        },
        basketball_selected() {
            return this.$store.getters.basketballSelected;
        },
        football_selected() {
            return this.$store.getters.footballSelected;
        },
        soccer_selected() {
            return this.$store.getters.soccerSelected;
        },
        softball_selected() {
            return this.$store.getters.softballSelected;
        },
        tennis_selected() {
            return this.$store.getters.tennisSelected;
        },
    },
    mounted() {
        this.loadSports();
        this.loadPlayingLevels();
        this.loadSportsFields();
    },
    methods: {
        resetFilters() {
            //Clear the filters in the store
            this.$store.dispatch("resetFilters");

            //Clear the inputs
            bus.$emit('clearAllInputs');
        },
        handleRemoval(val) {
            this.$store.dispatch("checkForRemoval", val);
        },
        loadSportsFields() {
            let self = this;
            axios.get("api/sport-field").then(res => {
                let fields = res.data;
                let sports = this.$store.getters.sports;
                let sport_fields = {};

                for(var i = 0; i < sports.length; i++) {
                    let sport_id = sports[i]["id"];
                    let sport_name = sports[i]["name"].toLowerCase();

                    sport_fields[sport_name] = {};
                    sport_fields[sport_name].fields = [];

                    for(var j = 0; j < fields.length; j++) {
                        if(sport_id == fields[j].sport_id) {
                            sport_fields[sport_name].fields.push(fields[j]);
                        }
                    }
                }

                self.sport_fields = sport_fields;
            });
        },
        setupInitialSportsData() {
            if(this.savedSearch) {
                var sports_selected_count = this.sports_selected.length;
                if(sports_selected_count > 1) {
                    this.search_across_sports = true;
                }
                else if(sports_selected_count == 1 && this.$refs.sport_single) {
                    this.$refs.sport_single.setValue(this.sports_selected[0]["value"]);
                }
            }
        },
        saveSearch() {
            this.$store.dispatch("saveSearch");
        },
        updateSearch() {
            this.$store.dispatch("updateSearch", this.savedSearch);
        },
        loadPlayingLevels() {
            let self = this;
            axios.get("api/enums/playing-levels").then(res => {
                self.playing_levels_options = res.data;
            });
        },
        search() {
            this.$emit("search")
        },
        showAdvanced() {
            this.show_advanced = ! this.show_advanced;
        },
        //Update sports_selected data when the single sport select changes.
        updateSelectedSport() {
            //Clear the array in case the checkbox select had been used previously.
            this.sports_selected = [];

            //Add a key value pair.
            let selected_sport = this.sports.find(sport => sport.value == this.sport_id);
            this.sports_selected.push(selected_sport);
        },
        loadSports() {
            //Load key - value pairs
            let self = this;
            axios.get("api/sport").then(res => {
                self.sports = res.data;
            });

            axios.get("api/sport/full").then(res => {
                self.$store.commit("setSports", res.data);
            });
        }
    }
}
</script>
<style>
.advanced-filter-btn {
    top:17px;
}
.sport-checkbox input {
    position:absolute;
    opacity:0;
    cursor:pointer;
}
.sport-checkbox input:checked ~ .checkbox-option {
    @apply text-white bg-accent;
}
.checkbox-option .icon {
    @apply text-accent;
}
.sport-checkbox input:checked ~ .checkbox-option .icon {
    @apply text-white;
}
</style>