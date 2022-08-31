<template>
    <div>
        <h5 class="account-header pb-2 pt-4">{{sport.name}}</h5>
        <div class="grid grid-cols-12 gap-4">
            <!-- Sport positions -->
            <SportPosition 
                class="my-2 col-span-12 lg:my-0 lg:col-span-6"
                v-if="sport.sportpositions && sport.sportpositions.length > 0" 
                :positions="sport.sportpositions"
                :sport_name="sport.name"
                :sport_id="sport.id"/>

            <!-- Normal sport data fields -->
            <slot></slot>
        </div>
    </div>
</template>
<script>
export default {
    name:"SingleSport",
    props: {
        sport: {
            type:Object,
            default:null
        }
    },
    beforeDestroy() {
        //Clear any sport positions that were added but not saved.
        this.$store.commit("setupUserPositions");
    }
}
</script>