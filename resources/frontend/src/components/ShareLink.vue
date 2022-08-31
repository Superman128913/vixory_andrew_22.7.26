<template>
    <div class="m-4 w-full">
        <div class="share-dialog z-10 bg-gray-900 border-gray-alt2 rounded shadow block lg:absolute left-0 w-full" :class="{'block': is_open, 'hidden': !is_open}">
            <header>
                <h3 class="dialog-title text-white">Share this page</h3>
                <button class="close-button mx-2" v-on:click="closeShare">
                    <svg id="close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line><line x1="15" y1="9" x2="9" y2="15"></line></svg>
                </button>
            </header>
            <div class="targets">
                <a class="social-link" :href="'https://www.facebook.com/sharer/sharer.php?u=' + link" target="_blank">
                    <span class="ml-0 mr-0 inline-block">
                        <svg id="facebook" viewBox="0 0 24 24" fill="#DEAE53" stroke="#DEAE53" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                    </span>
                </a>
                <a class="social-link" :href="'https://twitter.com/intent/tweet?text=' + link" target="_blank">
                    <span class="ml-0 mr-0 inline-block">
                        <svg id="twitter" viewBox="0 0 24 24" fill="#DEAE53" stroke="#DEAE53" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                    </span>
                </a>
                <a class="social-link" :href="'https://www.linkedin.com/shareArticle?mini=true&url=' + link + '&title=Check%20out%20my%20Vixory%20profile!&summary=&source='" target="_blank">
                    <span class="ml-0 mr-0 inline-block">
                        <svg id="linkedin" viewBox="0 0 24 24" fill="#DEAE53" stroke="#DEAE53" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-linkedin"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                    </span>
                </a>
                <a class="social-link" :href="'mailto:?subject=Check%20out%20my%20Vixory%20profile!&body=' + link" target="_blank">
                    <span class="ml-0 mr-0 inline-block text-accent">
                        <i class="fas fa-envelope"></i>
                    </span>
                </a>
            </div>
        </div>
        <button class="share-button" type="button" title="Share this article" v-on:click="openShare" :class="{'hidden': is_open, 'block': !is_open}">
            <span>{{text}}</span>
        </button>
    </div>
</template>
<script>
export default {
    name:"ShareLink",
    props: {
        link: {
            type:String,
            default:""
        },
        text: {
            type:String,
            default:"Share"
        }
    },
    data() {
        return {
            is_open:false
        }
    },
    methods: {
        openShare() {
            if (navigator.share) {
                navigator.share({
                    title: 'Vixory Profile Page',
                    url: this.link
                });
            } else {
                this.is_open = true;
            }
        },
        closeShare() {
            this.is_open = false;
        }
    }
}
</script>
<style scoped>
.social-link {
    @apply text-center rounded border-accent border p-2 cursor-pointer;
    height:40px;
}
svg {
  width: 20px;
  height: 20px;
}
.share-button, .copy-link {
  padding-left: 10px;
  padding-right: 10px;
}
.share-dialog {
  box-shadow: 0 8px 16px rgba(0,0,0,.15);
  padding: 20px;
}
header {
  display: flex;
  justify-content: space-between;
  margin-bottom: 20px;
}
.targets {
  display: grid;
  grid-template-rows: 1fr 1fr;
  grid-template-columns: 1fr 1fr;
  grid-gap: 20px;
  margin-bottom: 20px;
}
.close-button {
  background-color: transparent;
  border: none;
  padding: 0;
}
.close-button svg {
  margin-right: 0;
}
.link {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 10px;
  border-radius: 4px;
}
.pen-url {
  margin-right: 15px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
</style>