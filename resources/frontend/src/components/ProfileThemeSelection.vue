<template>
    <div class="theme-selection-wrapper">
        <!-- Selection Grid -->
        <perfect-scrollbar  v-if="expanded" class="h-64">
            <div class="grid grid-cols-12 gap-4">
                <div v-for="theme in themes" :key="theme.id" class="col-span-6">
                    <div 
                        class="theme h-48 rounded-lg cursor-pointer bg-no-repeat bg-center bg-cover"
                        :class="{'selected-theme': profile_theme_id == theme.id}"
                        v-bind:style="{ backgroundImage: 'url(/storage/' + theme.image + ')' }"
                        v-on:click="selectTheme(theme.id)">
                    </div>
                </div>
            </div>
        </perfect-scrollbar>

        <!-- Select Image Button -->
        <div v-if="!expanded && !profile_theme_id" class="h-48 rounded-lg bg-gray-900 border-2 flex justify-center" v-on:click="openSelection">
            <div class="self-center">Select header image ></div>
        </div>

        <!-- Image Preview -->
        <div v-if="!expanded && profile_theme_id && this.themes.length > 0" class="header-preview">
            <div 
                class="theme h-48 rounded-lg cursor-pointer bg-no-repeat bg-center bg-cover"
                v-bind:style="{ backgroundImage: 'url(/storage/' + getSelectedTheme() + ')' }"
                v-on:click="openSelection">

                <div class="edit-overlay invisible black-transparent uppercase h-full flex items-center justify-center">
                    <span>
                        <span class="text-lg">Edit</span>
                        <span class="px-1 text-md">
                            <i class="fas fa-pencil-alt"></i>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name:"ProfileThemeSelection",
    props:["initial_id"],
    data() {
        return {
            themes:[],
            expanded:false,
            profile_theme_id:this.initial_id || null
        }
    },
    watch: {
        profile_theme_id: function(val) {
            this.$emit('input', val);
            this.expanded = false; //Close after a new selection
        }
    },
    mounted() {
        this.loadThemes();
    },
    methods: {
        getSelectedTheme() {
            //Get the image path of the selected theme.
            var selected_theme = this.themes.find(image => image.id === this.profile_theme_id);

            if(typeof selected_theme != 'undefined') {
                return selected_theme.image;
            }
        },
        selectTheme(profile_theme_id) {
            this.profile_theme_id = profile_theme_id;

            //Update the users theme header.
            let self = this;
            axios.post("api/user/images/header/" + profile_theme_id).then(res => {
                self.$noty.success("Header Updated");
            }).catch(error => {
                self.$noty.error("Oops, something went wrong!");
            });
        },
        openSelection() {
            this.expanded = true;
        },
        loadThemes() {
            let self = this;
            axios.get("api/theme").then(res => {
                self.themes = res.data;
            });
        }
    }
}
</script>
<style scoped lang="scss">
.selected-theme {
    @apply border border-accent;
}
.header-preview:hover .edit-overlay{
    visibility:visible !important;
}
.black-transparent {
    background-color:rgba(0,0,0,0.4)
}
</style>