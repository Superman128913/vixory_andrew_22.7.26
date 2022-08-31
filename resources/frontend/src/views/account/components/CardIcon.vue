<template>
    <div>
        <img :src="icon_url" v-if="icon_number" class="cc-icon"/>
        <i class="fad fa-credit-card" v-else></i>
    </div>
</template>
<script>
export default {
    name:"CardIcon",
    props: {
        brand: {
            type:String,
            default:""
        }
    },
    computed: {
        icon_number() {
            return this.getIconNumber();
        },
        icon_url() {
            if(this.icon_number) {
                return this.getAssetUrl() + "/images/payment/Dark%20Color/" + this.getIconNumber() + ".png";
            }
        }
    },
    methods: {
        getIconNumber() {
            switch(this.brand) {
                case "amex":
                    return "22";

                case "diners":
                    return "10";

                case "discover":
                    return "14";

                case "jcb":
                    return "16";

                case "mastercard":
                    return "2";

                case "visa":
                    return "1";
                    
                default:
                    return false;
            }
        }
    }
}
</script>
<style scoped>
.cc-icon {
    width: 100px;
}
</style>