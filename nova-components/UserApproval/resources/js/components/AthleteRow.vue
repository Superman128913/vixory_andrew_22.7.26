<template>
    <tr>
        <td>{{ user.name }}</td> <!-- Make this link to the user details page -->
        <td>{{ user.email }}</td>
        <td class="flex items-center cursor-pointer relative">
            <span v-on:click="expand">
                <div>
                    {{ college }}
                    <icon-edit height="18px" fill="#718096" class="ml-2 cursor-pointer relative"/>
                </div>
                <div v-if="overide" class="italic" style="color:#718096">
                    Original: {{ user.manual_college_entry }}
                </div>
            </span>
            <CollegeSearch v-if="expanded" :manualEntry="user.manual_college_entry" v-on-clickaway="away" v-on:override="handleOveride"/>
        </td>
        <td class="text-right">
            <span class="pl-2 pr-2 inline-flex justify-center cursor-pointer" v-on:click="approve">
                <span class="flex self-center pl-2 pr-2">Approve</span>
                <icon-healthy height="24px" />
            </span>
        </td>
    </tr>
</template>
<script>
import { mixin as clickaway } from 'vue-clickaway';
import CollegeSearch from './CollegeSearch';
export default {
    name:"AthleteRow",
    mixins: [ clickaway ],
    props: {
        user: {
            type: Object
        }
    },
    data() {
        return {
            expanded:false,
            overide: false,
            overide_id: null,
            college: this.user.manual_college_entry
        }
    },
    components: {
        CollegeSearch
    },
    methods: {
        away() {
            this.expanded = false;
        },
        approve() {
            let self = this;

            let payload = {
                "overide_id":this.overide_id
            };

            axios.post("/nova-vendor/user-approval/approve-athlete/" + this.user.id, payload).then(res => {
                self.$toasted.show('User Approved!', {type:'success'});
                self.$emit("user-approved", self.user.id);

                //Redirect to college resource page if the value wasn't overriden.
                if(! this.overide) {
                    this.$router.push("/resources/colleges/" + res.data.college.id + "/edit");
                }
            })
            .catch(error => {
                self.$toasted.show('Something went wrong, please contact an administrator.', {type:'error'});
            });
        },
        expand() {
            this.expanded = true;
            this.handleClear();
        },
        handleOveride(college) {
            this.expanded = false;
            this.overide = true;
            this.overide_id = college.id;
            this.college = college.name;
        },
        handleClear() {
            this.overide = false;
            this.overide_id = null;
        }
    }
}
</script>