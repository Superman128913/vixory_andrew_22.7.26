<template>
    <table v-if="users.length > 0" class="p-8">
        <thead>
            <tr class="bg-transparent">
                <th></th>
                <th class="text-accent font-bold px-5">Name</th>
                <th class="text-accent font-bold px-5">Age</th>
                <th class="text-accent font-bold px-5">Sex</th>
                <th class="text-accent font-bold px-5">Height</th>
                <th class="text-accent font-bold px-5">Weight</th>
                <th class="text-accent font-bold px-5">School</th>
                <th class="text-accent font-bold px-5">Playing Level</th>
                <th class="text-accent font-bold px-5">Sport(s)</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <template v-for="user in users">
                <!-- Individual Table Rows -->
                <tr :key="'table-row-' + user.id">
                    <td>
                        <ConnectionButton 
                            :user_id="user.id"
                            :connections="connections" 
                            v-on:request-connection="requestConnection(user)"
                            :connection_total_limit="connection_total_limit"
                            :connection_frequency_limit="connection_frequency_limit"/>
                    </td>
                    <!-- Name -->
                    <td>
                        <span :class="{'fuzzy-text': !user.show_info}">{{getName(user)}}</span>
                    </td>
                    <!-- Age -->
                    <td>{{user.age | dash}}</td>
                    <!-- Sex -->
                    <td>{{ getSex(user.sex) }}</td>
                    <!-- Height -->
                    <td>
                        {{user.height | length}}
                    </td>
                    <!-- Weight -->
                    <td>
                        {{user.weight | dash}}
                    </td>
                    <!-- College -->
                    <td>
                        {{user.college ? user.college.name : "-"}}
                    </td>
                    <!-- Playing Level -->
                    <td>
                        {{user.playing_level ? getPlayingLevel(user.playing_level) : "-"}}
                    </td>
                    <!-- Sports -->
                    <td>
                        <template v-for="(sport, sport_index) in user.sports">
                            {{sport.name}}<template v-if="sport_index + 1 < user.sports.length">,</template>
                        </template>
                    </td>
                    <td v-if="user.show_info" v-on:click="togglePanel(user.id)" class="cursor-pointer text-accent uppercase">
                        See Stats
                    </td>
                    <td v-else></td>
                </tr>
                <!-- Expandable User Panel -->
                <tr v-if="opened_panel == user.id" :key="'expanded-panel-' + user.id">
                    <td colspan="12">
                        <SportsDataPanel :user="user"/>
                    </td>
                </tr>
            </template>
        </tbody>
    </table>
</template>
<script>
export default {
    name:"DesktopTable",
    props:[ 
        "users", 
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