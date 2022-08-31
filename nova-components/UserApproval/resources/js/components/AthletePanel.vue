<template>
    <div style="margin-bottom:3rem">
        <heading class="mb-2">Athletes</heading>
        <p class="mb-4 text-gray-300">The athletes below have selected a college not in the database. In order for their subscription to be approved you need to either create a new college from their selection or select the college they should have choosen in the event that they missed it.</p>
        <card class="flex flex-col items-center justify-center">
            <table cellpadding="0" cellspacing="0" class="table w-full">
                <thead>
                    <tr>
                        <th class="text-left">
                            {{ __('Name') }}
                        </th>
                        <th class="text-left">
                            {{ __('Email') }}
                        </th>
                        <th class="text-left">
                            {{ __('College') }}
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="user in unapproved_users">
                        <AthleteRow :user="user" :key="user.id" v-on:user-approved="removeUser" />
                    </template>
                    <tr v-if="unapproved_users.length === 0">
                        <td class="text-center" colspan="4">
                            {{ __('No athletes need approval') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </card>
    </div>
</template>
<script>
import AthleteRow from './AthleteRow';
export default {
    name:"AthletePanel", 
    data() {
        return {
            unapproved_users:[]
        }
    },
    mounted() {
        this.getUsers();
    },
    components: {
        AthleteRow
    },
    methods: {
        getUsers() {
            let self = this;
            window.axios.get("/nova-vendor/user-approval/unapproved-athletes").then(res => {
                self.unapproved_users = res.data;
            });
        },
        removeUser(user_id) {
            let user_index = this.unapproved_users.findIndex(user => user.id == user_id);
            this.unapproved_users.splice(user_index, 1);
        }
    }
}
</script>