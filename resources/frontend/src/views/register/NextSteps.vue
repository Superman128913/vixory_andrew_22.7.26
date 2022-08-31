<template>
    <PageWrapper class="login-page bg-bottom" image="/images/design/stadium_login.jpg">
        <div class="card max-w-lg mx-auto">
            <div class="card-body m-10" v-if="user">
                <h1 class="text-white mb-4">Register</h1>

                <!-- Step One:Height & Weight & Age & Date of Birth -->
                <form v-show="step == 1" v-on:submit="nextStep($event)">
                    <LengthInput
                        class="alt"
                        v-model="user.height"
                        :errors="errors.height"
                        :required="true"
                        label="Height"/>
                    <NumberInput
                        class="alt"
                        v-model="user.weight"
                        :errors="errors.weight"
                        :required="true"
                        label="Weight"
                        suffix="lbs"/>
                    <NumberInput
                        class="alt"
                        v-model="user.age"
                        :errors="errors.age"
                        :required="true"
                        label="Age"
                        :min="16"
                        :max="100"/>
                    <DateInput
                        class="alt"
                        v-model="user.date_of_birth"
                        :errors="errors.date_of_birth"
                        label="Date Of Birth"/>
                    <div class="w-full flex justify-end mt-3">
                        <button>Next</button>
                    </div>
                </form>

                <!-- Step Two:Sport -->
                <form v-show="step == 2" v-on:submit="nextStep($event)">
                    <CheckboxInput
                        class="alt"
                        v-model="user.sports_selected"
                        :options="sports"
                        :errors="errors.sports_selected"
                        :required="true"
                        label="Sports"/>

                    <div class="w-full flex justify-end mt-3">
                        <button>Next</button>
                    </div>
                </form>

                <!-- Step Three:Sport -->
                <form v-show="step == 3" v-on:submit="nextStep($event)">
                    <div v-for="sport in user.sports" :key="sport.id" :sport="sport">
                        <SportPosition 
                            class="alt my-2 col-span-12 lg:my-0 lg:col-span-6"
                            v-if="sport.sportpositions && sport.sportpositions.length > 0"
                            :label="sport.name + ' Positions'"
                            :positions="sport.sportpositions"
                            :sport_name="sport.name"
                            :sport_id="sport.id"/>
                    </div>

                    <div class="w-full flex justify-end mt-3">
                        <button>Next</button>
                    </div>
                </form>

                <!-- Step Four:Playing Level & College/High School Info -->
                <form v-show="step == 4" v-on:submit="nextStep($event)">
                    <SelectInput
                        class="alt"
                        v-model="user.playing_level"
                        :errors="errors.playing_level"
                        :required="true"
                        label="Playing Level"
                        :options="playing_levels_options"
                        :field="{table_name:'playing_level'}"/>
                    <template v-if="user.playing_level != 4">
                        <CollegeSearch
                            class="alt"
                            v-model="user.college_id"
                            :errors="errors.college_id"
                            :college="user.college"
                            :required="true"
                            label="College"/>
                        <SelectInput
                            class="alt"
                            v-model="user.school_year"
                            :errors="errors.school_year"
                            label="School Year"
                            :options="school_year_options"
                            prompt="Select school year"
                            :field="{table_name:'school_year'}"/>
                        <NumberInput
                            class="alt"
                            v-model="user.college_gpa"
                            :errors="errors.college_gpa"
                            label="GPA"
                            step="0.01"
                            :max="5"/>
                        <TextInput
                            class="alt"
                            v-model="user.credit_hours_completed"
                            :errors="errors.credit_hours_completed"
                            label="Credit Hours Completed"/>
                    </template>

                    <div class="w-full flex justify-end mt-3">
                        <button>Next</button>
                    </div>
                </form>

                <!-- Step Five:Early Education -->
                <form v-show="step == 5" v-on:submit="nextStep($event)">
                    <TextInput
                        class="alt"
                        v-model="user.highschool"
                        :required="true"
                        :errors="errors.highschool"
                        label="High School"/>
                    <NumberInput
                        class="alt"
                        v-model="user.highschool_gpa"
                        :errors="errors.highschool_gpa"
                        :required="true"
                        label="High School GPA"
                        step="0.01"
                        :max="5"/>
                    <NumberInput
                        class="alt"
                        v-model="user.act"
                        :errors="errors.act"
                        label="ACT"
                        :min="1"
                        :max="36"
                        step="1"/>
                    <NumberInput
                        class="alt"
                        v-model="user.sat"
                        :errors="errors.sat"
                        label="SAT"
                        :min="400"
                        :max="1600"
                        step="1"/>
                    <div class="w-full flex justify-between mt-3">
                        <a class="text-accent cursor-pointer" v-on:click="skipAndContinue()">Skip, and finish later</a>
                        <button>Next</button>
                    </div>
                </form>

                <!-- Step Six:Video Upload -->
                <div v-show="step == 6">
                    <label>Video Upload</label>
                    <SingleVideo :inline="true"/>
                    <div class="w-full flex justify-between mt-6">
                        <a class="text-accent cursor-pointer" v-on:click="skipAndContinue()">Skip, and finish later</a>
                        <button v-on:click="nextStep($event)">Next</button>
                    </div>
                </div>

                <!-- Step Seven:Address -->
                <form v-show="step == 7" v-on:submit="nextStep($event)">
                    <TextInput
                        class="alt"
                        v-model="user.address"
                        :errors="errors.address"
                        label="Address"/>

                    <PlacesInput
                        class="alt"
                        v-model="user.city"
                        v-on:placeSelected="updateUserState"
                        :errors="errors.city"
                        label="City"/>

                    <SelectInput
                        class="alt"
                        v-model="user.state"
                        :errors="errors.state"
                        label="State"
                        :options="state_options"
                        :field="{table_name:'state_option'}"/>

                    <SelectInput
                        class="alt"
                        v-model="user.country"
                        :errors="errors.country"
                        label="Country"
                        :options="country_options"
                        :field="{table_name:'country'}"/>

                    <div class="w-full flex justify-between mt-3">
                        <a class="text-accent cursor-pointer" v-on:click="skipAndContinue()">Skip, and finish later</a>
                        <button>Next</button>
                    </div>
                </form>

                <!-- Step Eight:Social -->
                <form v-show="step == 8" v-on:submit="nextStep($event)">
                    <TextInput
                        class="alt"
                        v-model="user.social_media_facebook"
                        :errors="errors.social_media_facebook"
                        label="Facebook"/>

                    <TextInput
                        class="alt"
                        v-model="user.social_media_twitter"
                        :errors="errors.social_media_twitter"
                        label="Twitter"/>

                    <TextInput
                        class="alt"
                        v-model="user.social_media_instagram"
                        :errors="errors.social_media_instagram"
                        label="Instagram"/>

                    <TextInput
                        class="alt"
                        v-model="user.social_media_linkedin"
                        :errors="errors.social_media_linkedin"
                        label="LinkedIn"/>
                    <div class="w-full flex justify-end mt-3">
                        <button v-on:click="nextStep()">Finish</button>
                    </div>
                </form>
            </div>
        </div>
    </PageWrapper>
</template>
<script>
export default {
    name:"NextSteps",
    data() {
        return {
            step: 1,
            errors:[],
            sports:[],
            playing_levels_options:[],
            school_year_options: [],
            country_options:[],
            state_options:[]
        }
    },
    computed: {
        user() {
            return this.$store.getters.user;
        }
    },
    mounted() {
        this.loadCountries();
        this.loadSports();
        this.loadStates();
        this.loadPlayingLevels();
        this.loadSchoolYear();
    },
    methods: {
        skipAndContinue() {
            this.$router.push({name:'profile'});
        },
        handleUpload(e) {
            e.preventDefault();
            console.log("Handle upload");
        },  
        updateUserState(places_obj) {
            //Convert state name to state code.
            var stateCode = this.stateNameToCode(places_obj.state, 'abbr');
            var stateInteger = this.state_options.find(option => option.key === stateCode);

            if(stateInteger) {
                this.$store.commit("updateUserAttribute", {
                    name: "state",
                    value: stateInteger.value
                });
            }
        },
        nextStep(e) {
            e.preventDefault();

            let self = this;
            axios.patch("api/user/partial/" + this.user.id, this.user).then(res => {
                if(self.step == 2) {
                    self.$store.commit("setUser", res.data);
                }
                if(self.step == 8) {
                    self.$store.commit("setUser", res.data);
                    self.$router.push({name:'profile'});
                }

                self.step++;
            }).catch(error => {
                self.$noty.error("Oops, something went wrong!");

                if(error.response.data.errors) {
                    self.errors = error.response.data.errors;
                }
            });
        },
        loadSchoolYear()
        {
            let self = this;
            axios.get("api/enums/school-year").then(res => {
                self.school_year_options = res.data;
            });
        },
        loadSports() {
            let self = this;
            axios.get("api/sport").then(res => {
                self.sports = res.data;
            });
        },
        loadPlayingLevels()
        {
            let self = this;
            axios.get("api/enums/playing-levels").then(res => {
                self.playing_levels_options = res.data;
            });
        },
        loadStates()
        {
            let self = this;
            axios.get("api/enums/states").then(res => {
                self.state_options = res.data;
            });
        },
        loadCountries()
        {
            let self = this;
            axios.get("api/enums/countries").then(res => {
                self.country_options = res.data;
            });
        }
    }
}
</script>