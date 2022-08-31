import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store.js'

import '@/styles/app.scss';

/**
 * Misc Javascript libraries
 */
window._ = require('lodash');

window.axios = require('axios');
require('./axios');

window.moment = require('moment');
window.places = require('places.js');

import VueMask from 'v-mask'
Vue.use(VueMask, {
    placeholders: {
        's':/\s/
    }
});

import VueClipboard from 'vue-clipboard2'
Vue.use(VueClipboard)

import PerfectScrollbar from 'vue2-perfect-scrollbar'
import 'vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css'
Vue.use(PerfectScrollbar)

import LottiePlayer from 'lottie-player-vue';
Vue.use(LottiePlayer);

//Configure toast library
import VueNoty from 'vuejs-noty'
Vue.use(VueNoty, {
    timeout: 3000,
    progressBar: false,
    layout: 'topCenter'
  })

//Add global functions and filters
require('./mixins/global.js');
import './filters.js'

//Event Hub
Vue.prototype.$eventHub = new Vue();

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Laravel Echo
 */
import Echo from 'laravel-echo'
window.Pusher = require('pusher-js');

window.Echo = new Echo({
	broadcaster: 'pusher',
	key: '8286479407facbbff08a',
	cluster: 'us2',
	forceTLS: true,
	authorizer: (channel, options) => {
        return {
            authorize: (socketId, callback) => {
                axios.post('/api/broadcasting/auth', {
                    socket_id: socketId,
                    channel_name: channel.name
                })
                .then(response => {
                    callback(false, response.data);
                })
                .catch(error => {
                    callback(true, error);
                });
            }
        };
    },
});

/** Add the event bus */
export const bus = new Vue();

/**
 * Add in library to handle meta info
 */
import VueMeta from 'vue-meta'
Vue.use(VueMeta)

Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
