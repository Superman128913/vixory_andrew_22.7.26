<template>
    <div class="w-full p-2" v-if="users.length > 0">

        <!-- Header -->
        <div class="flex items-center">
                <div class="w-1/12 text-accent font-bold"></div>
                <div class="w-4/12 text-accent font-bold">Name</div>
                <div class="w-2/12 text-accent font-bold">Age</div>
                <div class="w-2/12 text-accent font-bold">Height</div>
                <div class="w-3/12 text-accent font-bold">Level</div>
        </div>



        <div class="user-item py-4 border-b border-gray-alt2" v-for="user in users" :key="user.id" v-on:click="togglePanel(user.id)">
            <!-- Top of Row -->
            <div class="flex items-center">
                <!-- Open/Expand -->
                <div class="w-1/12 text-accent text-2xl">
                    <i class="fas fa-chevron-circle-down"></i>
                </div>

                <!-- Name -->
                <div class="w-4/12" :class="{'fuzzy-text': !user.show_info}">{{getName(user)}}</div>

                <!-- Age -->
                <div class="w-2/12" :class="{'fuzzy-text': !user.show_info}">{{user.age | dash}}</div>

                <!-- Height -->
                <div class="w-2/12">{{user.height | length}}</div>

                <!-- Playing Level -->
                <div class="w-3/12">{{user.playing_level ? getPlayingLevel(user.playing_level) : "-"}}</div>
            </div>

            <!-- Expanded Information -->
            <div class="expanded-information text-left py-4" v-if="opened_panel == user.id">
                <!-- Basic User Information -->
                        <!-- Name -->
                        <div :class="{'fuzzy-text': !user.show_info}">
                            <span class="font-bold px-2">Name</span>
                            {{getName(user)}}
                        </div>

                        <!-- Age -->
                        <div :class="{'fuzzy-text': !user.show_info}">
                            <span class="font-bold px-2">Age</span>
                            {{user.age | dash}}
                        </div>

                        <!-- Playing Level -->
                        <div>
                            <span class="font-bold px-2">Playing Level</span>
                            {{user.playing_level ? getPlayingLevel(user.playing_level) : "-"}}
                        </div>

                        <!-- Sex -->
                        <div>
                            <span class="font-bold px-2">Sex</span>
                            {{ getSex(user.sex) }}
                        </div>

                        <!-- Height -->
                        <div>
                            <span class="font-bold px-2">Height</span>
                            {{user.height | length}}
                        </div>

                        <!-- Weight -->
                        <div>
                            <span class="font-bold px-2">Weight</span>
                            {{user.weight}}
                        </div>

                        <!-- College -->
                        <div>
                            <span class="font-bold px-2">College</span>
                            {{user.college ? user.college.name : "-"}}
                        </div>

                        <!-- Playing Level -->
                        <div>
                            <span class="font-bold px-2">Playing Level</span>
                            {{user.playing_level ? getPlayingLevel(user.playing_level) : "-"}}
                        </div>

                        <!-- Sports -->
                        <div>
                            <span class="font-bold px-2">Sports</span>
                            <span class="px-2">
                                <template v-for="(sport, sport_index) in user.sports">
                                    {{sport.name}}<template v-if="sport_index + 1 < user.sports.length">,</template>
                                </template>
                            </span>
                        </div>

                        <!-- Connection Button -->
                        <ConnectionButton 
                            class="block mx-2 py-4"
                            :user_id="user.id"
                            :connections="connections" 
                            v-on:request-connection="requestConnection(user)"
                            :connection_total_limit="connection_total_limit"
                            :connection_frequency_limit="connection_frequency_limit"/>

                <hr class="my-4">

                <!-- Sports Data -->
                <div v-if="opened_panel == user.id" :key="'expanded-panel-' + user.id">
                    <SportsDataPanel :user="user" class="text-left"/>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name:"MobileTable",
    props:[ "users", 
            "playing_level_options",
            "connection_total_limit",
            "connection_frequency_limit",
            "connections",
            "sex_options"
    ],
    data() {
        return {
            opened_panel:null,
        }
    },
    methods: {
        getSex(sex_value) {
            if(sex_value !== null) {
                return this.sex_options.find(opt => opt.value === sex_value).key;
            }
            return "-";
        },
        getPlayingLevel(playing_level_value) {
            return this.playing_level_options.find(opt => opt.value === playing_level_value).key;
        },
        getName(user) {
            //If the name is available, return it. Otherwise return a string approximately the length of a name.
            if(user.show_info) {
                return user.first_name + " " + user.last_name;
            }
            else {
                return "John Doe";
            }
        },
        requestConnection(user) {
            let payload = {
                requested_user_id:user.id
            };

            let self = this;
            axios.post("api/connection/", payload).then(res => {
                self.$noty.success("Connection Requested");
            });
        },
        togglePanel(user_id) {
            if(this.opened_panel == user_id) {
                this.opened_panel = null;
            }
            else {
                this.opened_panel = user_id;
            }
        },
        isExpanded(user_id) {
            return (user_id == this.opened_panel);
        }
    }
}
</script>