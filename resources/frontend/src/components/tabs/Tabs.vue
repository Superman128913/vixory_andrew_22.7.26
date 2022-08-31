<template>
    <div class="tab-wrapper rounded">
        <div class="sub-menu">
            <slot name="header"></slot>

            <!-- Tabs menu items -->
            <ul class="tabs-menu flex p-4 m-0">
                <li 
                    class="tab-menu-item mr-4 my-0"
                    v-for="tab in tabs" 
                    v-on:click="selectTab(tab)"
                    :key="tab.name">
                    <a :href="tab.href">
                        <span v-if="tab.icon" class="text-accent px-1">
                            <i :class="tab.icon"></i>
                        </span>
                        <span class="minor-heading">
                            {{tab.name}}
                        </span>
                    </a>
                </li>
            </ul>
            <slot name="footer"></slot>
        </div>
        <hr>
        <div class="tab-details p-4">
            <slot></slot>
        </div>
    </div>
</template>
<script>
import tab from './Tab';
export default {
    name:"Tabs",
    components: {
        tab
    },
    data() {
        return {
            tabs:[]
        }
    },
    created() {
        this.tabs = this.$children
    },
    watch: {
        $route() {
            this.setTab();
        }
    },
    mounted() {
        this.setTab();
    },
    methods: {
        setTab() {
            let currentHash = this.$route.hash;
            this.tabs.forEach(tab => {
                tab.isActive = (tab.href == currentHash)
            });
        },
        selectTab(selectedTab) {
            this.tabs.forEach(tab => {
                tab.isActive = (tab.name == selectedTab.name)
            });
        },
        setActive(selectedTabName) {
            this.tabs.forEach(tab => {
                tab.isActive = (tab.name == selectedTabName)
            });
        }
    }
}
</script>
<style>
.tabs .router-link-exact-active {
    @apply text-white bg-gray-alt2;
}
</style>