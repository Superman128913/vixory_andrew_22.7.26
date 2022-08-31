<template>
    <!-- IMPORTANT: This is a nova component under the user approval section. End users do not use this. -->
    <card class="card-wrapper absolute p-4 shadow-lg cursor-default">
        <div class="mt-2">
            <label class="block text-gray-700 text-sm font-bold mb-2">College Search</label>
            <input v-model="query" class="w-full form-control form-input form-input-bordered" v-on:input="debounceSearch"/>

            <!-- Results -->
            <ul v-if="results.length > 0 && query.length > 1" class="college-search-results mt-2 pl-0 list-none">
                <li v-for="college in results" :key="college.id" class="p-2 py-3 cursor-pointer" v-on:click="selectCollege(college)">
                    {{college.name}}
                </li>
            </ul>
        </div>
    </card>
</template>
<script>
export default {
    name:"CollegeSearch",
    props: {
        manualEntry: {
            type:String
        }
    },
    data() {
        return {
            query:"", //The query being searched
            results:[], //List of colleges matching the query
            override: false, //Whether or not the admin is overriding the user inputted value
            override_id: null, //The college id that their submission is being overridden with
        }
    },
    methods: {
        debounceSearch: _.debounce(function (e) {
            if(e.target.value.length > 1) {
                this.search(e.target.value);
            }
        }, 600),
        search() {
            let self = this;
            window.axios.get("/nova-vendor/user-approval/search-colleges?q=" + this.query).then(res => {
                self.results = res.data;
            });
        },
        selectCollege(college) {
            //Clear the results to collapse the dropdown
            this.results = [];

            //Set the selection as the new college
            this.override = true;
            this.override_id = college.id;
            this.$emit("override", college);
        }
    }
}
</script>
<style scoped>
.card-wrapper {
    left:0;
    top: 59px;
    z-index: 1;
    width: 300px;
}
.college-search-results {
    list-style:none;
}
</style>