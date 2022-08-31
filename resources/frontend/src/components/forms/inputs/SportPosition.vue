<template>
    <DefaultInput :label="label">
        <template slot="input">
            <!-- Selected Positions -->
            <ul class="list-disc ml-5 mb-2">
                <li v-for="position_name in selected_position_names" :key="position_name" class="flex justify-between position-item">
                    <span>{{position_name}}</span>
                    <span v-on:click="removePosition(position_name)" class="remove-position invisible text-gray-places mx-2 cursor-pointer">
                        <i class="fas fa-minus-circle"></i>
                    </span>
                </li>
            </ul>

            <!-- Position Choices -->
            <div class="flex">
                <select v-model="current_selection">
                    <option :value="undefined">Select Position</option>
                    <option v-for="option in available_positions" :value="option.id" :key="option.id">
                        {{option.name}}
                    </option>
                </select>
                <div v-on:click="addPosition" class="text-gray-places mx-2 justify-center self-center cursor-pointer">
                    <i class="fas fa-plus-circle"></i>
                </div>
            </div> 
        </template>
    </DefaultInput>
</template>
<script>
import { bus } from '../../../main'

export default {
    name:"SportPosition",
    props: {
        label: {
            type: String,
            default: "Positions"
        },
        positions: {
            type:Array,
            default:function(){ return [] }
        },
        sport_name: {
            type:String,
            default:""
        },
        sport_id: {
            type:Number,
            default:null
        }
    },
    data() {
        return {
            available_positions: Object.assign([], this.positions), //The positions the user can add based on what they've already added.
            current_selection: false,
            selected_positions: [],
        }
    },
    computed: {
        user_sport_positions() {
            return this.$store.getters.userPositions();
        },
        selected_position_names() {
            var position_names = [];
            for(var i = 0; i < this.selected_positions.length; i++) {
                var position_id = this.selected_positions[i];
                

                var position = this.positions.find(function(position){
                    return position.id === position_id
                });
                if(position) {
                    position_names.push(position.name);
                }
            }
            return position_names;
        },
        position_field_name() {
            if(this.sport_name) {
                return this.sport_name.toLowerCase() + "_position"
            }
        },
    },
    mounted() {
        this.getSelectedPositions();

        bus.$on('beforeUserUpdate', (data) => {
            this.addPosition();
        })
    },
    methods: {
        addPosition() {
            if(this.current_selection) {
                //Add to selected positions
                this.selected_positions.push(this.current_selection);

                //Remove this position from the available positions to prevent dupes
                var index = this.available_positions.findIndex(avail_position => avail_position.id == this.current_selection);
                this.available_positions.splice(index, 1);

                //Clear out the current position
                this.current_selection = false;

                //Fire off event
                this.$store.commit("updateUserAttribute", {
                    name: this.position_field_name,
                    value: this.selected_positions
                });
            }
        },
        removePosition(position_name) {
            let self = this;
            var position = this.positions.find(position => {
                return (position.name == position_name && position.sport_id == self.sport_id);
            });
            if(position) {
                //Add it back as an available choice
                this.available_positions.push(position);

                //Remove from local component
                var selectedIndex = this.selected_positions.findIndex(selected_position => selected_position == position.id);
                this.selected_positions.splice(selectedIndex, 1);

                //Fire off event to remove position
                this.$store.commit("updateUserAttribute", {
                    name: this.position_field_name,
                    value: this.selected_positions
                });
            }
        },
        getSelectedPositions() {
            var starting_positions = [];
            for(var i = 0; i < this.user_sport_positions.length; i++) {
                //If the position matches this sport
                if(this.user_sport_positions[i].sport_id == this.sport_id) {
                    var position_id = this.user_sport_positions[i].id;

                    //Add it as a position that the user has already selected
                    starting_positions.push(position_id);
                    
                    //Remove it as a position that is selectable
                    var index = this.available_positions.findIndex(avail_position => avail_position.id == position_id);
                    this.available_positions.splice(index, 1);
                }

            }
            this.selected_positions = starting_positions;
        }
    }
}
</script>
<style scoped>
.position-item:hover .remove-position {
    @apply visible;
}
</style>