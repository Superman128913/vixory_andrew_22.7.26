<template>
    <DefaultInput :label="label" class="places-wrapper" :errors="errors">

    </DefaultInput>
</template>
<script>
export default {
    name:"PlacesInput",
    props: {
        value: [String, Number],
        label: String,
        errors: Array,
        field: {
            type: Object,
            default: null
        },
    },
    data() {
        return {
            instance: null,
            content: this.value,
            api_id: process.env.MIX_PLACES_APP_ID,
            api_key: process.env.MIX_PLACES_APP_KEY,
        }
    },
    mounted() {
        // make sure Vue does not know about the input
        // this way it can properly unmount
        this.input = document.createElement('input');
        if(this.value) {
            this.input.value = this.value;
        }

        this.input.className = "place-input";
        this.$el.appendChild(this.input);

        this.instance = places({
            appId: this.app_id,
            apiKey: this.api_key,
            type: 'city',
            countries:['us'],
            aroundLatLngViaIP: false,
            container: this.input,
            templates: {
                value: function(suggestion) {
                    return suggestion.name;
                }
            }
        });

        this.instance.on('change', e => {
            this.updateData(e);
        });
    },
    beforeDestroy() {
        // if you had any "this.instance.on", also call "off" here
        if(this.instance) {
            this.instance.destroy();
        }
    },
    methods: {
        updateData(e) {
            this.$emit("input", e.suggestion.name);
            this.$emit("placeSelected", {
                name:e.suggestion.name,
                state:e.suggestion.administrative
            });
        }
    }
}
</script>
<style>
    .places-wrapper span {
        color:#656565;
    }
    .places-wrapper .ap-suggestion em {
        color:#656565;
    }
    .places-wrapper .place-input {
        border-color: #525252 !important;
        height:34px;
    }
</style>