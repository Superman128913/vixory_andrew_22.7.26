<template>
    <tr>
        <td>{{ user.name }}</td> <!-- Make this link to the user details page -->
        <td>{{ user.email }}</td>
        <td v-if="role == 'coach'">{{ user.college ? user.college.name : user.manual_college_entry + " (College will be created.)" }}</td>
        <td v-else>{{ user.pro_team_name }}</td>
        <td class="text-right">
            <span class="pl-2 pr-2 inline-flex justify-center cursor-pointer" v-on:click="approveCoach">
                <span class="flex self-center pl-2 pr-2">Approve</span>
                <icon-healthy height="24px" />
            </span>

            <span class="pl-2 pr-2 inline-flex justify-center cursor-pointer" v-on:click="denyCoach">
                <span class="flex self-center pl-2 pr-2">Deny</span> 
                <icon-unhealthy height="24px" />
            </span>
        </td>
    </tr>
</template>
<script>
export default {
    name:"CoachRow",
    props: {
        user: {
            type: Object
        }
    },
    computed: {
        role(){
            var is_coach = this.user.roles.find(role => role.name == 'coach');
            return typeof is_coach !== 'undefined' ? 'coach' : 'pro_scout';
        }
    },
    methods: {
        approveCoach() {
            let self = this;
            window.axios.post("/nova-vendor/user-approval/approve-coach/" + this.user.id).then(res => {
                self.$toasted.show('User Approved!', {type:'success'});
                self.$emit("user-approved", self.user.id);
            }).catch(error => {
                self.$toasted.show('Something went wrong, please contact an administrator.', {type:'error'});
            });
        },
        denyCoach() {
            let self = this;
            window.axios.post("/nova-vendor/user-approval/reject-coach/" + this.user.id).then(res => {
                self.$toasted.show('User Rejected', {type:'success'});
                self.$emit("user-rejected", self.user.id);
            }).catch(error => {
                self.$toasted.show('Something went wrong, please contact an administrator.', {type:'error'});
            });
        }
    }
}
</script>