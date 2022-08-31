import Vue from 'vue';

export const filters = {
    state: {
        sports_selected:[],
        sports:[], //key - value pairs
        filters:{},
        playing_level: false, //Dupe of filters.playing_level set so that components can be reactive
    },
    actions: {
        resetFilters({commit, state}) {
            commit("resetFilters");
        },
        checkForRemoval({commit, state}, sport_id) {
            //If this option already exists, remove it.
            if(state.sports_selected.find(sport => sport == sport_id)) {
                commit("removeSportSelected", sport_id);
            }
            else {
                commit("setSportSelected", sport_id);
            }
        },
        loadSavedSearch({commit, state}, saved_search_id) {
            return new Promise((resolve, reject) => {
                let self = this;
                axios.get("api/savedsearch/" + saved_search_id).then(res => {
                    let criteria = res.data.criteria;
                    commit("setFilters", criteria);
    
                    let sports = res.data.sports;
                    commit("setSportsSelected", sports);

                    resolve(res);
                });
            });
        },
        saveSearch({commit, state}) {
            //Create the payload
            let payload = {
                criteria: formatFilters(state.filters),
                sports: JSON.stringify(state.sports_selected)
            }

            //Send the request
            let self = this;
            axios.post("api/savedsearch", payload).then(res => {
                Vue.noty.success("Search Saved");
            });
        },
        updateSearch({commit, state}, saved_search_id) {
            //Create the payload
            let payload = {
                criteria: formatFilters(state.filters),
                sports: JSON.stringify(state.sports_selected)
            }

            //Send the request
            let self = this;
            axios.patch("api/savedsearch/" + saved_search_id, payload).then(res => {
                Vue.noty.show("Search Updated");
            });
        }
    },
    mutations: {
        removeSportSelected(state, sport_id) {
            let sportIndex = state.sports_selected.findIndex(sport => sport === sport_id);
            state.sports_selected.splice(sportIndex, 1);
        },
        setSportsSelected(state, sports) {
            state.sports_selected = sports;
        },
        setSportSelected(state, sport) {
            state.sports_selected.push(sport);
        },
        setSports(state, sports) {
            state.sports = sports;
        },
        resetFilters(state) {
            state.filters = {};
            state.sports_selected = [];
        },
        setFilters(state, filters) {
            state.filters = filters;

            //Set playing level if it's set
            if(filters.hasOwnProperty("playing_level")) {
                state.playing_level = filters.playing_level;
            }
        },
        updateFilter(state, payload) {
            let filter_name = payload.filter_name;
            state.filters[filter_name] = payload.value;

            //Set playing level
            if(payload.filter_name == "playing_level") {
                state.playing_level = payload.value;
            }
        }
    },
    getters: {
        sports: state => {return state.sports},
        sportsSelected: state => {return state.sports_selected},
        baseballSelected: state => { 
            let sport = state.sports.find(sport => sport.name === "Baseball");
            if(sport) {
                let sport_id = sport.id;
                return (state.sports_selected.filter(sport => sport == sport_id)).length > 0;
            }
        },
        basketballSelected: state => { 
            let sport = state.sports.find(sport => sport.name === "Basketball");
            if(sport) {
                let sport_id = sport.id;
                return (state.sports_selected.filter(sport => sport == sport_id)).length > 0; 
            }
        },
        footballSelected: state => { 
            let sport = state.sports.find(sport => sport.name === "Football"); 
            if(sport) {
                let sport_id = sport.id;
                return (state.sports_selected.filter(sport => sport == sport_id)).length > 0;
            }
        },
        soccerSelected: state => { 
            let sport = state.sports.find(sport => sport.name === "Soccer");
            if(sport) {
                let sport_id = sport.id;
                return (state.sports_selected.filter(sport => sport == sport_id)).length > 0; 
            }
        },
        tennisSelected: state => { 
            let sport = state.sports.find(sport => sport.name === "Tennis");
            if(sport) {
                let sport_id = sport.id;
                return (state.sports_selected.filter(sport => sport == sport_id)).length > 0; 
            }
        },

        getSport: state => sport_name => {
            return state.sports.find(sport => sport.name === sport_name);
        },
        filters: state => {
            return state.filters;
        },
        getFilter: state => filter_name => {
            return state.filters[filter_name];
        },
        playingLevel: state => {
            return state.playing_level;
        }
    }
}
function formatFilters(filters) {
    //Convert the Vue Observer to a normal object.
    let tmpFilters = JSON.parse(JSON.stringify(filters));
    //Remove any empty properties
    Object.keys(tmpFilters).forEach((key) => (tmpFilters[key] == null || tmpFilters[key] === "") && delete tmpFilters[key]);
    return JSON.stringify(tmpFilters)
}