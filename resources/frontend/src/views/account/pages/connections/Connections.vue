<template>
    <div class="p-10">
        <h1 class="account-header" v-if="pending_connections.length > 0 || processed_connections.length > 0">Connections</h1>

        <!-- Pending Connections -->
        <div v-if="pending_connections.length > 0">
            <div class="text-accent mt-4 text-lg font-bold">Pending Connections</div>
            <div class="grid grid-cols-12 gap-4">
                <template v-for="connection in pending_connections">
                    <template v-if="isAthleticRecruiter()">
                        <div class="col-span-12 lg:col-span-6" :key="connection.id">
                            <CoachPending :connection="connection"/>
                        </div>
                    </template>
                    <template v-else>
                        <div class="col-span-12 lg:col-span-6" :key="connection.id">
                            <AthletePending 
                                :connection="connection" 
                                v-on:accept-connection="acceptConnection" 
                                v-on:decline-connection="declineConnection"/>
                        </div>
                    </template>
                </template>
            </div>
        </div>
        
        <!-- Processed Connections -->
        <div v-if="processed_connections.length > 0">
            <div class="text-accent mt-4 mb-2 text-lg font-bold">Accepted Connections</div>
            <p class="pb-4">Vixory does not provide functionality for communication between users on our platform. After connecting with another user on Vixory, you can reach out to them directly using the contact information they listed.</p>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 lg:col-span-6" v-for="connection in processed_connections" :key="connection.id">
                    <!-- Coach View -->
                    <template v-if="isAthleticRecruiter()">
                        <CoachAccepted :connection="connection"/>
                    </template>

                    <!-- Athlete View -->
                    <template v-else>
                        <AthleteAccepted :connection="connection"/>
                    </template>
                </div>
            </div>
        </div>

        <div v-if="processed_connections.length <= 0 && pending_connections.length <= 0" class="nothing-message">
            No Connections Found
        </div>
    </div>
</template>
<script>
export default {
    name:"Connections",
    data() {
        return {
            connections:[],
        }
    },
    computed: {
        pending_connections() {
            return this.connections.filter(connection => this.getStatus(connection) === 'pending');
        },
        processed_connections() {
            //Note: Anything not pending is processed.
            return this.connections.filter(connection => this.getStatus(connection) !== 'pending');
        }
    },
    mounted() {
        this.loadConnections();
    },
    methods: {
        getStatus(connection) {
            if(connection.accepted) {
                return "accepted";
            }
            else if(connection.deleted_at) {
                return "declined";
            }
            else {
                return "pending";
            }
        },
        loadConnections() {
            let self = this;
            axios.get("api/connection").then(res => {
                self.connections = res.data;
            });
        },
        acceptConnection(connection_id) {
            let self = this;
            axios.post("api/connection/" + connection_id).then(res => {
                var connectionIndex = self.connections.findIndex(connection => connection.id === res.data.id);
                self.connections[connectionIndex].accepted = 1;
            });
        },
        declineConnection(connection_id) {
            let self = this;
            axios.delete("api/connection/" + connection_id).then(res => {
                var connectionIndex = self.connections.findIndex(connection => connection.id === res.data.id);
                self.connections[connectionIndex].accepted = 0;
            });
        }
    }
}
</script>