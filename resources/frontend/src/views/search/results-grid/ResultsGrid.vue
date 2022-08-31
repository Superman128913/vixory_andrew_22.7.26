<template>
    <div v-if="visible" class="bg-black rounded text-center mt-6">
        <media :query="{maxWidth: 768}">
            <MobileTable 
                :users="filtered_users"
                :playing_level_options="playing_level_options"
                :connection_total_limit="connection_total_limit"
                :connection_frequency_limit="connection_frequency_limit"
                :connections="connections"
                :sex_options="sex_options"/>
        </media>
        <media :query="{minWidth: 768}">
            <DesktopTable 
                :users="filtered_users"
                :playing_level_options="playing_level_options"
                :connection_total_limit="connection_total_limit"
                :connection_frequency_limit="connection_frequency_limit"
                :connections="connections"
                :sex_options="sex_options"/>    
        </media>
        <div v-if="users.length <= 0" class="italic">
            No Users Found
        </div>
    </div>
</template>
<script>
import Media from 'vue-media'
export default {
    name:"ResultsGrid",
    components: {
        Media
    },
    computed: {
        filtered_users() {
            return this.users.filter(user => user.age && user.weight);
        }
    },
    data() {
        return {
            sex_options: this.sexOptions(),
            connections: [],
            visible:false,
            users:null,
            connection_total_limit: 0, //Calculated on results grid for performance reasons
            connection_frequency_limit: 0, //Calculated on results grid for performance reasons
            playing_level_options: [
                {
                    value:0,
                    key:"D1"
                },
                {
                    value:1,
                    key:"D2"
                },
                {
                    value:2,
                    key:"D3"
                },
                {
                    value:3,
                    key:"JUCO"
                },
                {
                    value:4,
                    key:"High School"
                },
                {
                    value:5,
                    key:"Professional"
                }
            ],
        }
    },
    mounted() {
        this.setupConnectionLimits();
        this.getAllConnections();
    },
    methods: {
        setupConnectionLimits() {
            //Load connection limit variables from env, and handle values.
            let types = ['null', 'undefined'];

            let ctl = process.env.VUE_APP_CONNECTION_TOTAL_LIMIT;
            this.connection_total_limit = types.includes(typeof ctl) ? 0 : ctl;

            let cfl = process.env.VUE_APP_CONNECTION_FREQUENCY_LIMIT;
            this.connection_frequency_limit = types.includes(typeof cfl) ? 0 : cfl;
        },
        setUsers(users) {
            this.users = users;
            this.visible = true;
        },
        getAllConnections() {
            let self = this;
            axios.get("api/connection").then(res => {
                self.connections = res.data;
            });
        }
    }
}
</script>
<style>
.fuzzy-text{
    text-shadow: 0px 0px 9px white;
    color: transparent;
}
</style>