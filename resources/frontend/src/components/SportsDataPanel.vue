<template>
    <div class="additional-info-panel-wrapper" v-if="sport_fields">
        <div 
            class="block md:flex mb-8"
            v-for="sport in active_sports" 
            :key="sport.id" :name="sport.name" 
            :icon="sport.icon_class">

            <!-- Sport -->
            <div class="sport-label text-accent font-bold uppercase px-2 lg:px-4">{{sport.name}}</div>
            
            <!-- Sport Fields -->
            <div class="">
                <div class="grid grid-cols-12">
                    <!-- Positions -->
                    <div class="col-span-12 md:col-span-6" v-if="userHasPosition(sport)">
                        <div class="lg:grid lg:grid-cols-2">
                            <span class="whitespace-no-wrap px-2 text-right font-bold">{{sport.name}} Position</span>
                            <span class="px-2 text-left border-0 lg:border-l border-gray-alt2">
                                {{ positionString(sport, user.sportpositions) }}
                            </span>
                        </div>
                    </div>

                    <!-- Standard Fields -->
                    <div v-for="sport_field in allSportFields(sport.id)" :key="sport_field.id" class="col-span-12 md:col-span-6">
                        <div class="lg:grid lg:grid-cols-2">
                            <span class="whitespace-no-wrap px-2 text-right font-bold">{{sport_field.key}}</span>
                            <span class="whitespace-no-wrap px-2 text-left border-0 lg:border-l border-gray-alt2">{{sport_field.value | dash}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name:"SportsDataPanel",
    props: {
        user:Object
    },
    data() {
        return {
            sport_fields:[]
        }
    },
    computed: {
        active_sports() {
            if(this.user) {
                return this.user.sports;
            }
        }
    },
    mounted() {
        this.loadFields();
    },
    methods: {
        userHasPosition(sport) {
            let positions = this.user.sportpositions.filter(pos => pos.sport_id == sport.id);
            if(positions && positions.length > 0) {
                return true;
            }
            return false;
        },  
        positionString(sport, sport_positions) {
            let positions = sport_positions.filter(pos => pos.sport_id == sport.id);
            var positionString = "";
            var i = 0;
            for(var i = 0; i < positions.length; i++)
            {
                positionString += positions[i].name;
                if(i+1 != positions.length) {
                    positionString += ", "
                }
            }
            return positionString;
        },
        loadFields() {
            let self = this;
            axios.get("api/sport-field/").then(res => {
                self.sport_fields = res.data;
            });
        },

        //Get a key-vaue pair array of all of the sport fields for the specified sport.
        allSportFields(sport_id) {
            let self = this;
            let fields = this.sport_fields.filter(field => {
                return (sport_id == field.sport_id)
            });

            let pairs = fields.map(field => {
                return {
                    "key" : field.pretty_name,
                    "value" : this.displayValue(field)
                }
            });

            return pairs;
        },

        //Depending on the type of field, we need to retrieve the value differently.
        displayValue(field) {
            if(! this.user.hasOwnProperty(field.table_name)) {
                return false;
            }

            let value = this.user[field.table_name];
            if(field.type == 7 || field.type == 5 || field.type == 4) {
                let sportIndex = this.active_sports.findIndex(sport => sport.id == field.sport_id);
                let options = this.active_sports[sportIndex].enums[field.table_name];
                if(options) {
                    let option = options.find(option => option.value == value);
                    if(option) {
                        return option.description;
                    }
                }
            }
            else {
                return value;
            }
        }
    }
}
</script>
<style scoped>
.sport-label {
    width:200px;
}
</style>