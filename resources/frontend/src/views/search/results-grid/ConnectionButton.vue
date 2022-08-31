<template>
    <span class="cursor-pointer">
            <span v-if="!connection_sent && !connection" v-on:click="requestConnection">
                <span class="text-accent">
                    <i class="fal fa-plus-circle"></i> 
                </span>
                <span class="px-2">Connect</span>
            </span>

            <span v-else-if="connection && connection_accepted">
                <span class="text-accent">
                    <i class="fal fa-check"></i>
                </span>
                <span class="px-2">Accepted</span>
            </span>

            <span v-else-if="connection_sent || !criteria_met">
                <span class="text-accent">
                    <i class="fal fa-clock"></i> 
                </span>
                <span class="px-2">Pending</span>
            </span>

            <span v-else v-on:click="requestConnection">
                <span class="text-accent">
                    <i class="fal fa-redo"></i> 
                </span>
                <span class="px-2">Resend</span>
            </span>
    </span>
</template>
<script>
import moment from 'moment'

export default {
    name:"ConnectionButton",
    props: ["user_id", "connections", "connection_total_limit", "connection_frequency_limit"],
    data() {
        return {
            connection_sent: false, //Used to override the normal conditional logic to show connection sent button.
            criteria_met: false
        }
    },
    computed: {
        connection() {
            return this.connections.find(connection => connection.requested_user_id === this.user_id);
        },
        connection_accepted() {
            var connection = this.connections.find(connection => connection.requested_user_id === this.user_id);
            if(connection) {
                return connection.accepted;
            }
            return false;
        }
    },
    watch: {
        connection: {
            handler(connection) {
                //Establish whether the criteria for resending a request have be met.
                if(typeof connection != 'undefined') {
                    let lastRequest = moment(this.connection.request_last_sent);
                    let daysSince = moment().diff(lastRequest, 'days');

                    //Note: diffing the results here gives a rough approximation that leans towards undercounting since it has to bee a full day of "difference" for it to count.
                    if(daysSince >= this.connection_frequency_limit && this.connection.requests_sent <= this.connection_total_limit) {
                        this.criteria_met = true;
                    }
                }
            },
            deep:true,
            immediate:true
        }
    },
    methods: {
        requestConnection() {
            this.connection_sent = true;
            this.$emit("request-connection");
        }
    }
}
</script>