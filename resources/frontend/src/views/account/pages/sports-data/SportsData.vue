<template>
    <div v-if="user" class="p-10">
        <template v-if="user.sports.length > 0">
            <SingleSport 
                v-for="sport in user.sports" 
                :key="sport.id" :sport="sport">
                <template v-for="field in sportFields(sport.id)">
                    <component 
                        v-bind:is="getFieldsComponentName(field)"
                        v-model="user[field.table_name]"
                        class="my-2 col-span-12 lg:my-0 lg:col-span-6"
                        :errors="errors[field.table_name]"
                        :step="field.step"
                        :suffix="field.suffix"
                        :mask="field.mask"
                        :key="field.id"
                        :field="field" 
                        :label="field.pretty_name"
                        :options="sport.enums[field.table_name]"
                    />
                </template>
            </SingleSport>

            <button v-on:click="updateSportData" class="my-6">Update</button>
        </template>
        <div v-else class="nothing-message">
            No Sports Selected
        </div>
    </div>
</template>
<script>
import { bus } from '../../../../main'

export default {
    name:"SportsData",
    data() {
        return {
            sports:[],
            sport_fields:[],
            errors:[]
        }
    },
    computed: {
        user: function() {
            return this.$store.getters.user;
        }
    },
    mounted() {
        this.loadSports();
        this.loadSportsFields();
    },
    methods: {
        updateSportData() {
            //Fire event to let components perform last minute changes to user object before it's updated.
            bus.$emit('beforeUserUpdate');

            let self = this;
            axios.patch("api/user/" + this.user.id, this.user).then(res => {
                self.$store.commit("setUser", res.data);
                self.$noty.success("User Updated");
            }).catch(error => {
                self.$noty.error("Something went wrong.");

                if(error.response.data.errors) {
                    self.errors = error.response.data.errors;
                }
            });
        },
        getEnums(field) {
            if([4,5,7].includes(field.type)) 
            {
                var sport = this.sports.find(sport => sport.id === field.sport_id);
                var enums = sport.enums[field.table_name];
            }
        },
        loadSports() {
            let self = this;
            axios.get("api/sport/full").then(res => {
                self.sports = res.data;
            });
        },
        loadSportsFields() {
            let self = this;
            axios.get("api/sport-field").then(res => {
                self.sport_fields = res.data;
            });
        },
        sportFields(sport_id) {
            var fields = [];
            for(var i = 0; i < this.sport_fields.length; i++)
            {
                if(this.sport_fields[i].sport_id == sport_id) {
                    fields.push(this.sport_fields[i]);
                }  
            }
            return fields;
        }
    }
}
</script>