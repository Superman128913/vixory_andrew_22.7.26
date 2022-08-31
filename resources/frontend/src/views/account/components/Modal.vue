<template>
    <div class="modal bg-black bg-hazy opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">

        <!-- Modal Overlay -->
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"  v-on:click="toggleModal"></div>
        
        <div class="modal-container bg-black border border-gray-alt2 w-11/12 md:max-w-lg mx-auto rounded shadow-lg z-50 overflow-y-auto">

            <!-- Escape Button -->
            <div class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50" v-on:click="toggleModal">
                <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
                <span class="text-sm">(Esc)</span>
            </div>

            <!-- Add margin if you want to see some of the overlay behind the modal-->
            <div class="modal-content p-12 text-left">
                <!--Title-->
                <div class="flex justify-between items-top pb-3">
                    <p class="text-2xl font-bold" v-if="title">{{title}}</p>

                    <!-- Modal Close -->
                    <div class="modal-close cursor-pointer z-50 px-2" v-on:click="toggleModal">
                        <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                        </svg>
                    </div>
                </div>

                <!--Body-->
                <slot></slot>

                <!--Footer-->
                <div class="inline-block w-full pt-4">
                    <button class="btn mx-2 float-right minimal" v-if="action_text" v-on:click="completeAction">{{action_text}}</button>
                    <button class="btn mx-2 float-right" v-on:click="toggleModal">Close</button>
                </div>
                
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name:"Modal",
    props: {
        title: {
            type:String,
            default:null
        },
        action_text: {
            type:String,
            default:null
        }
    },
    mounted() {
        this.watchKeypress();
    },
    methods: {
        completeAction() {
            this.$emit("action-completed");
        },
        watchKeypress() {
            let self = this;
            document.onkeydown = function(evt) {
                evt = evt || window.event
                var isEscape = false
                if ("key" in evt) {
                    isEscape = (evt.key === "Escape" || evt.key === "Esc")
                } else {
                    isEscape = (evt.keyCode === 27)
                }
                if (isEscape && document.body.classList.contains('modal-active')) {
                    self.toggleModal();
                }
            };   
        },
        toggleModal() {
            const body = document.querySelector('body')
            const modal = document.querySelector('.modal')
            modal.classList.toggle('opacity-0')
            modal.classList.toggle('pointer-events-none')
            body.classList.toggle('modal-active')
        }
    }
}
</script>
<style scoped>
.btn.minimal {
    margin:0px !important;
}
</style>