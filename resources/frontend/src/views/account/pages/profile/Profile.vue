<template>
    <form v-if="user" v-on:submit.prevent="updateUser" class="p-10">
        <!-- Athlete Fields -->
        <template v-if="! isAthleticRecruiter()">
            <div class="bg-accent rounded-lg p-3 text-white mb-6">
                We use your information to connect you with coaches and scouts. We will never sell your personal information.
            </div>

            <!-- Profile Theme Selection -->
            <ProfileThemeSelection
                v-model="user.profile_theme_id"
                :errors="errors.profile_theme_id"
                :initial_id="user.profile_theme_id"/>

            <div class="grid grid-cols-12">
                <div class="col-span-12 lg:col-span-3">
                    <!-- Profile Image Display -->
                    <template v-if="imageAvailable">
                        <ProfileImage :src="user.profile_image"/>
                    </template>
                    <template v-else>
                        <div
                            class="profile_image bg-cover mt-4"
                            v-bind:style="{ backgroundImage: 'url(/images/design/default-user-avatar.png)'}">
                        </div>
                    </template>
                </div>
                <div class="col-span-12 lg:col-span-9">
                    <ImageUploader
                        :showPreview="false"
                        save="api/user/images/profile"
                        v-on:save="uploaded"/>
                </div>
            </div>

            <!-- General Info -->
            <div class="grid grid-cols-12 mb-8 gap-0 md:gap-4">
                <div class="col-span-12 md:col-span-6 lg:col-span-3">
                    <TextInput
                        v-model="user.first_name"
                        :required="true"
                        :errors="errors.first_name"
                        label="First Name"/>
                </div>
                <div class="col-span-12 md:col-span-6 lg:col-span-3">
                    <TextInput
                        v-model="user.last_name"
                        :required="true"
                        :errors="errors.last_name"
                        label="Last Name"/>
                </div>
                <div class="col-span-12 md:col-span-6">
                    <TextInput
                        v-model="user.email"
                        :required="true"
                        :errors="errors.email"
                        label="Email"/>
                    <span v-if="!user.email_verified_at || user.pending_email" class="italic text-sm">Email is pending verification.</span>
                </div>
                <div class="col-span-12 md:col-span-6 lg:col-span-3">
                    <PhoneInput
                        v-model="user.phone_number"
                        :errors="errors.phone_number"
                        label="Phone Number"/>
                </div>
                <div class="col-span-12 md:col-span-6 lg:col-span-3">
                    <NumberInput
                        v-model="user.age"
                        :errors="errors.age"
                        :required="true"
                        label="Age"
                        :min="16"
                        :max="100"
                    />
                </div>
                <div class="col-span-12 md:col-span-6 lg:col-span-3">
                    <DateInput
                        v-model="user.date_of_birth"
                        :errors="errors.date_of_birth"
                        label="Date Of Birth"/>
                </div>
                <div class="col-span-12 md:col-span-6 lg:col-span-3">
                    <RadioInput
                        v-model="user.sex"
                        :errors="errors.sex"
                        label="Sex"
                        :options="sex_options"/>
                </div>
                <div class="col-span-12 md:col-span-6 lg:col-span-3">
                    <LengthInput
                        v-model="user.height"
                        :errors="errors.height"
                        :required="true"
                        label="Height"/>
                </div>
                <div class="col-span-12 md:col-span-6 lg:col-span-3">
                    <NumberInput
                        v-model="user.weight"
                        :errors="errors.weight"
                        :required="true"
                        label="Weight"
                        suffix="lbs"/>
                </div>
                <div class="col-span-12">
                    <TextareaInput
                        v-model="user.profile_description"
                        :errors="errors.profile_description"
                        label="Profile Description"/>
                </div>
                <div class="col-span-12">
                    <BooleanCheckboxInput
                        v-model="user.show_info"
                        :errors="errors.show_info"
                        label="Show Information"/>
                    <p class="text-sm max-w-md">To control your information and keep it private, uncheck the checkbox. <router-link :to="{name:'your-info'}" class="accent">Learn More</router-link></p>
                </div>
            </div>
            <hr>

            <!-- Academic - College -->
            <div class="grid grid-cols-12 my-8 gap-0 md:gap-4">
                <div class="col-span-12">
                    <h3 class="text-white text-xl dm-sans capitalize">College Information</h3>
                </div>
                <div class="col-span-12">
                    <SelectInput
                        v-model="user.playing_level"
                        :errors="errors.playing_level"
                        :required="true"
                        label="Playing Level"
                        :options="playing_levels_options"
                        :field="{table_name:'playing_level'}"/>
                </div>

                <!-- If in college or pro -->
                <template v-if="user.playing_level != 4">
                    <div class="col-span-12 md:col-span-12 lg:col-span-12">
                        <CollegeSearch
                            v-model="user.college_id"
                            :errors="errors.college_id"
                            :college="user.college"
                            label="College"/>
                        <p>If you leave the college blank, your current college staff will be able to see your information.</p>
                    </div>
                    <div class="col-span-12 md:col-span-6 lg:col-span-4">
                        <SelectInput
                            v-model="user.school_year"
                            :errors="errors.school_year"
                            label="School Year"
                            :options="school_year_options"
                            prompt="Select school year"
                            :field="{table_name:'school_year'}"/>
                    </div>
                    <div class="col-span-12 md:col-span-6 lg:col-span-4">
                        <NumberInput
                            v-model="user.college_gpa"
                            :errors="errors.college_gpa"
                            label="GPA"
                            step="0.01"
                            :max="5"/>
                    </div>
                    <div class="col-span-12 md:col-span-6 lg:col-span-4">
                        <TextInput
                            v-model="user.credit_hours_completed"
                            :errors="errors.credit_hours_completed"
                            label="Credit Hours Completed"/>
                    </div>
                </template>
            </div>
            <hr>

            <!-- Academic - High School -->
            <div class="grid grid-cols-12 my-8 gap-0 md:gap-4">
                <div class="col-span-12">
                    <h3 class="text-white text-xl dm-sans capitalize">Early Education</h3>
                </div>
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <PlacesInput
                        v-model="user.hometown"
                        :errors="errors.hometown"
                        label="Hometown"/>
                </div>
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <TextInput
                        v-model="user.highschool"
                        :required="true"
                        :errors="errors.highschool"
                        label="High School"/>
                </div>

                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <NumberInput
                        v-model="user.highschool_gpa"
                        :errors="errors.highschool_gpa"
                        :required="true"
                        label="High School GPA"
                        step="0.01"
                        :max="5"/>
                </div>

                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <NumberInput
                        v-model="user.act"
                        :errors="errors.act"
                        label="ACT"
                        :min="1"
                        :max="36"
                        step="1"/>
                </div>
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <NumberInput
                        v-model="user.sat"
                        :errors="errors.sat"
                        label="SAT"
                        :min="400"
                        :max="1600"
                        step="1"/>
                </div>
            </div>
            <hr>

            <!-- Location -->
            <div class="grid grid-cols-12 my-8 gap-0 md:gap-4">
                <div class="col-span-12">
                    <h3 class="text-white text-xl dm-sans capitalize">Mailing Address</h3>
                </div>
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <TextInput
                        v-model="user.address"
                        :errors="errors.address"
                        label="Address"/>
                </div>
                <div class="col-span-12 md:col-span-6 lg:col-span-3">
                    <PlacesInput
                        v-model="user.city"
                        v-on:placeSelected="updateUserState"
                        :errors="errors.city"
                        label="City"/>
                </div>
                <div class="col-span-12 md:col-span-6 lg:col-span-2">
                    <SelectInput
                        v-model="user.state"
                        :errors="errors.state"
                        label="State"
                        :options="state_options"
                        :field="{table_name:'state_option'}"/>
                </div>
                <div class="col-span-12 md:col-span-6 lg:col-span-3">
                    <SelectInput
                        v-model="user.country"
                        :errors="errors.country"
                        label="Country"
                        :options="country_options"
                        :field="{table_name:'country'}"/>
                </div>
            </div>
            <hr>

            <!-- Social Logins -->
            <div class="grid grid-cols-12 my-8 gap-0 md:gap-4">
                <div class="col-span-12">
                    <h3 class="text-white text-xl dm-sans capitalize">Social</h3>
                </div>
                <div class="col-span-12 md:col-span-6 lg:col-span-3">
                    <TextInput
                        v-model="user.social_media_facebook"
                        :errors="errors.social_media_facebook"
                        label="Facebook"/>
                </div>
                <div class="col-span-12 md:col-span-6 lg:col-span-3">
                    <TextInput
                        v-model="user.social_media_twitter"
                        :errors="errors.social_media_twitter"
                        label="Twitter"/>
                </div>
                <div class="col-span-12 md:col-span-6 lg:col-span-3">
                    <TextInput
                        v-model="user.social_media_instagram"
                        :errors="errors.social_media_instagram"
                        label="Instagram"/>
                </div>
                <div class="col-span-12 md:col-span-6 lg:col-span-3">
                    <TextInput
                        v-model="user.social_media_linkedin"
                        :errors="errors.social_media_linkedin"
                        label="LinkedIn"/>
                </div>
            </div>
            <hr>

            <!-- Sports Analytics -->
            <div class="grid grid-cols-12 my-8 gap-0 md:gap-4">
                <div class="col-span-12">
                    <h3 class="text-white text-xl dm-sans capitalize">Sport Analytics</h3>
                    <span class="italic text-sm">Find a nearby <a href="https://rapsodo.com/locator/" target="_blank" class="text-accent">Rapsodo location</a>.</span>
                </div>
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <PdfUploader label="Rapsodo" :media="user.rapsodo_media" name="rapsodo"/>
                </div>
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <PdfUploader label="Trackman" :media="user.trackman_media" name="trackman"/>
                </div>
                <div class="col-span-12 md:col-span-6 lg:col-span-4">
                    <PdfUploader label="Blast" :media="user.blast_media" name="blast"/>
                </div>
            </div>
            <hr>

            <!-- Sport Selection -->
            <div class="grid grid-cols-12 my-8 gap-0 md:gap-4">
                <div class="col-span-12">
                    <CheckboxInput
                        v-model="user.sports_selected"
                        :options="sports"
                        :errors="errors.sports_selected"
                        :required="true"
                        label="Sports"/>
                </div>
            </div>
            <hr>

            <div class="grid grid-cols-12 my-8 gap-0 md:gap-4">
                <div class="col-span-12">
                    <CheckboxInput
                        v-model="user.notificationsettings"
                        :options="notification_options"
                        label="Notifications"/>
                </div>
            </div>
        </template>

        <!-- Coach Fields -->
        <div v-else class="grid grid-cols-12 my-8 gap-0 md:gap-4">
            <div class="col-span-12 md:col-span-6">
                <TextInput
                    v-model="user.first_name"
                    :required="true"
                    :errors="errors.first_name"
                    label="First Name"/>
            </div>
            <div class="col-span-12 md:col-span-6">
                <TextInput
                    v-model="user.last_name"
                    :required="true"
                    :errors="errors.last_name"
                    label="Last Name"/>
            </div>
            <div class="col-span-12">
                <TextInput
                    v-model="user.email"
                    :required="true"
                    :errors="errors.email"
                    label="Email"/>
                <span v-if="!user.email_verified_at || user.pending_email" class="italic text-sm">Email is pending verification.</span>
            </div>
            <div class="col-span-12">
                <ImageUploader
                    label="Profile Image"
                    :src="user.profile_image"
                    save="api/user/images/profile"/>
            </div>
            <div class="col-span-12">
                <PhoneInput
                    v-model="user.phone_number"
                    :errors="errors.phone_number"
                    label="Phone Number"/>
            </div>
            <div class="col-span-12">
                <CollegeSearch
                    v-model="user.college_id"
                    :errors="errors.college_id"
                    :college="user.college"
                    label="College"/>
            </div>
            <div class="col-span-12">
                <CheckboxInput
                    v-model="user.notificationsettings"
                    :options="notification_options"
                    :errors="errors.notificationsettings"
                    label="Notifications"/>
            </div>
        </div>
        <div class="flex w-full justify-between">
            <button type="submit">Update</button>
            <ActivationButtons v-if="! isAthleticRecruiter()"/>
        </div>
    </form>
</template>
<script>
export default {
    name:"Profile",
    data() {
        return {
            sex_options: this.sexOptions(),
            school_year_options: [],
            country_options:[],
            state_options:[],
            playing_levels_options:[],
            notification_options:[
                {
                    key:"SMS",
                    value:1
                },
                {
                    key:"Email",
                    value:2
                }
            ],
            sports:[],
            errors:[]
        }
    },
    computed: {
        user() {
            return this.$store.getters.user;
        },
        imageAvailable() {
            return (this.user && this.user.profile_image);
        }
    },
    watch: {
        user: (user) => {
            //If country is not set, default to US.
            if(!user.country) {
                user.country = "US";
            }
        }
    },
    mounted() {
        //Load enum options
        this.loadCountries();
        this.loadSchoolYear();
        this.loadSports();
        this.loadStates();
        this.loadPlayingLevels();
    },
    methods: {
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
        uploaded(image_url) {
            //Add the image url to the user object so that the default image stops showing.
            this.user.profile_image = image_url;
        },
        loadStates()
        {
            let self = this;
            axios.get("api/enums/states").then(res => {
                self.state_options = res.data;
            });
        },
        loadPlayingLevels()
        {
            let self = this;
            axios.get("api/enums/playing-levels").then(res => {
                self.playing_levels_options = res.data;
            });
        },
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
        updateUser()
        {
            let self = this;
            axios.patch("api/user/" + this.user.id, this.user).then(res => {
                self.$store.commit("setUser", res.data);
                self.$noty.success("User Updated")
            }).catch(error => {
                self.$noty.error("Oops, something went wrong!");

                if(error.response.data.errors) {
                    self.errors = error.response.data.errors;
                    this.jumpToErrors();
                }
            });
        },
        loadSports() {
            let self = this;
            axios.get("api/sport").then(res => {
                self.sports = res.data;
            });
        },
    }
}
</script>
<style scoped>
    .input-wrapper {
        margin-top:1em;
        margin-bottom:1em;
    }
</style>
