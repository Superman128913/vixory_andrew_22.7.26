<template>
    <div class="input-wrapper relative">
        <label>College</label>
        <div class="relative">
            <input class="college-search-input" 
                v-model="input_text" 
                type="text" 
                :required="required"
                v-on:input="debounceInput" 
                v-on:focus="setFocus"
                v-on-clickaway="loseFocus"/>
                
            <div v-if="loading" class="loading-wrapper absolute">
                <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
            </div>

            <div v-show="!loading" class="border-gray-places text-gray-places college-search-icon">
                <i class="fas fa-university"></i>
            </div>

            <span class="italic text-sm" v-if="search_count > 0 && !matches_selected && !active && input_text">Your selection will be manually reviewed for accuracy since it wasn't selected from the list of colleges in our system. Try searching variations of the college's name to make sure it doesn't already exist.</span>
        </div>
        <ul v-if="choices.length > 0 && active" class="z-10 absolute bg-black px-0 rounded border border-gray-alt2 mx-0 w-full">
            <li v-for="(choice, choiceIndex) in choices" :key="choice.id" class="cursor-pointer m-0" :class="{'college-border': !(choiceIndex == choices.length - 1)}" v-on:click="selectCollege(choice)">
                <div class="py-3 px-3">
                    <span class="block text-white">{{choice.name}}</span>
                    <span class="text-sm text-white -mt-1 block">{{choice.city}}, {{choice.state_name}}</span>
                </div>
                <hr v-if="choiceIndex < choices.length - 1">
            </li>
        </ul>
    </div>
</template>
<script>
import { mixin as clickaway } from 'vue-clickaway';
export default {
    name:"CollegeProfileSearch",
    mixins: [ clickaway ],
    props: {
        college: {
            type:Object
        },
        required: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            choices:[], //The current college dropdown choices
            input_text: "", //The input fields text value
            selected_college:this.college || {}, //The selected college
            college_selected:false, //Whether a college is selected or the input just contains text
            active:false,
            search_count:0, //How many times has the backend been queried
            loading:false,
        }
    },
    computed: {
        matches_selected() {
            if(this.selected_college && this.input_text == this.selected_college.name) {
                return true;
            }
            else {
                return false;
            }
        }
    },
    mounted() {
        if(this.college) {
            this.input_text = this.college.name;
        }
    },
    watch: {
        input_text(val) {
            //Reset the selected college anytime the input text changes.
            if(val !== this.selected_college.name) {
                this.selected_college = {};
                this.$emit("input", val);
            }
        }
    },
    methods: {
        debounceInput: _.debounce(function(e) {
            this.loading = true;
            this.search(e.target.value);
        }, 600),
        search(query) {
            this.search_count++;

            let self = this;
            axios.get("api/college/search?q=" + query).then(res => {
                self.choices = res.data;
                self.active = true;
                self.loading = false
            });
        },
        selectCollege(college) {
            this.input_text = college.name;
            this.selected_college = Object.assign({}, college);
            this.college_selected = true;
            this.active = false;
            this.$emit("input", this.selected_college.id);
        },
        loseFocus() {
            this.active = false;
        },
        setFocus() {
            this.active = true;
        }
    }
}
</script>
<style scoped>
.loading-wrapper {
    right: 10px;
    bottom: 6px;
}
</style>