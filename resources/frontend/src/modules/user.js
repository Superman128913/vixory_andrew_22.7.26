import fKV from '../mixins/modelsToKV'
import Vue from 'vue'

export const user = {
    state: {
        logged_in:null,
        user:null
    },
    actions: {
        logoutUser({commit}) {
            commit("logout");
        },
        checkUser({commit, state, dispatch}) {
            if(state.logged_in !== false && state.user === null) {
                dispatch("loadUser");
            }
        },
        loadUser({commit, dispatch}) {
            axios.get('/api/user').then( function( response ){
                if(response.data.id) {
                    commit('setUser', response.data);
                    commit("setupUserPositions");
                    commit('login');

                    dispatch("userNotificationWatcher");
                    dispatch("loadNotifications", response.data.id);
                }
            });
        },
        userNotificationWatcher({commit, state, dispatch}) {
            Echo.private('App.User.' + state.user.id).notification((notification) => {
                dispatch("addNotification", notification);
            });
        }
    },
    mutations: {
        setUser(state, user) {
            state.user = user;
            state.user.sports_selected = fKV(user.sports);
            state.user.notificationsettings = fKV(user.notificationsettings);
        },
        setUserToReactivated(state) {
            state.user.is_deactivated = false;
        },
        setUserToDeactivated(state) {
            state.user.is_deactivated = true;
        },
        setupUserPositions(state) {
            //Clear any sport positions set previously.
            Vue.delete(state.user, 'baseball_position');
            Vue.delete(state.user, 'basketball_position');
            Vue.delete(state.user, 'tennis_position');
            Vue.delete(state.user, 'soccer_position');
            Vue.delete(state.user, 'football_position');
            Vue.delete(state.user, 'softball_position');

            //Set the users sport fields
            for(var i = 0; i < state.user.sportpositions.length; i++) {
                let position = state.user.sportpositions[i];

                //Convert the sport_position key to a sport key by splitting the string and appending _position.
                let key_fragments = position.key.split("_");
                let sport_key = key_fragments[0] + "_position";

                if(state.user.hasOwnProperty(sport_key)) {
                    //Append position
                    state.user[sport_key].push(position.id);
                }
                else {
                    //Add new property with this position
                    state.user[sport_key] = [position.id];
                }
            }
        },
        updateUserAttribute(state, payload) {
            state.user[payload.name] = payload.value;
        },
        login(state) {
            state.logged_in = true;
        },
        logout(state) {
            state.logged_in = false;
            state.user = null;
        }
    },
    getters: {
        getAuthenticated: state => {
            return state.logged_in;
        },
        isRejected: state => {
            return state.user && !state.user.approval && !state.user.requires_approval;
        },
        isPendingApproval: state => {
            return state.user && state.user.requires_approval && !state.user.approval;
        },
        user: state => {
            return state.user;
        },
        userPositions: state => () => {
            return state.user.sportpositions;
        },
        
    }
}