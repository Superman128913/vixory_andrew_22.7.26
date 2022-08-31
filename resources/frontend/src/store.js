import Vue from 'vue'
import Vuex from 'vuex'
import { user } from './modules/user.js';
import { filters } from './modules/filters.js';
import { notifications } from './modules/notifications.js';

Vue.use( Vuex );

export default new Vuex.Store({
    modules: {
        user,
        filters,
        notifications
    }
});