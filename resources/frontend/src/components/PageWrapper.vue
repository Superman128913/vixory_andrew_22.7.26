<template>
    <div :class="{'px-4 md:px-4': padding, 'px-4 md:px-0 lg:px-0': !padding}" class="page-wrapper pt-24 bg-no-repeat bg-cover block relative overflow-hidden min-h-screen">
        <div v-bind:class="{'boxed': layout === 'boxed' }" class="content">
            <slot></slot>
        </div>

        <div class="background-image" :class="imageClass" :style="'background-image:url(' + image + ');height:' + vh + 'vh;'">
            <div :class="{'blur-background': blur}"></div>
            <div class="bottom-gradient"></div>
        </div>
    </div>
</template>
<script>
export default {
    name:"PageWrapper",
    props: {
        image: String,
        layout: {
            type: String,
            default: 'full-width'
        },
        blur: {
            type: Boolean,
            default: false
        },
        vh: {
            type:Number,
            default:70
        },
        padding: {
            type: Boolean,
            default: true,
        },
        imageClass: {
            type: String,
            default: ''
        }
    },
    methods: {
        isBoxed() {
            return true;
        }
    }
}
</script>
<style>
.blur-background {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(8px);
    width: 100%;
    position: absolute;
    display: block;
    height: 100%;
}
.page-wrapper {
    padding-bottom: 273px; /* height of your footer */
}
.bottom-gradient {
    width:100%;
    height:100px;
    background: linear-gradient(180deg, rgba(0,0,0,0.4) 0%, rgba(0,0,0,1) 100%);
}
.bottom-gradient-solid {
    background-color:#000000;
    width:100%;
    height:100px;
}
.background-image {
    z-index:-2;
    background-repeat: no-repeat;
    background-size: cover;
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
}
.background-image > .bottom-gradient {
    width:100%;
    bottom:0;
    position:absolute;
    height:100px;
    background: rgb(0,0,0);
    background: linear-gradient(0deg, rgba(0,0,0,1) 0%, rgba(255,255,255,0) 100%);
}
</style>