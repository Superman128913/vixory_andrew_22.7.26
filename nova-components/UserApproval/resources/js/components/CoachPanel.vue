<template>
    <div>
        <heading class="mb-6">Coaches</heading>
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
                            {{ __('College/Team') }}
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="user in unapproved_users">
                        <CoachRow :user="user" v-on:user-approved="removeUser" v-on:user-rejected="removeUser"/>
                    </template>
                    <tr v-if="unapproved_users.length === 0">
                        <td class="text-center" colspan="4">
                            {{ __('No users need approval') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </card>
    </div>
</template>
<script>
import CoachRow from './CoachRow';

export default {
    name:"CoachPanel",
    data() {
        return {
            unapproved_users:[]
        }
    },
    mounted() {
        this.getUsers();
    },
    components: {
        CoachRow,
    },
    methods: {
        getUsers() {
            let self = this;
            window.axios.get("/nova-vendor/user-approval/unapproved-coaches").then(res => {
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