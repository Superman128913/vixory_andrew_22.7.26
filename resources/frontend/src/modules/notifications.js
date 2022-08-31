export const notifications = {
    state: {
        notifications:[]
    },
    actions: {
        loadNotifications({commit}, user_id) {
            let self = this;
            axios.get("api/notifications/" + user_id).then(res => {
                commit("addNotifications", res.data);
            });
        },
        addNotification({commit}, notification) {
            //Restructure the object so that it's compatible with the db notifications. There are still some differences between the objects.
            commit("addNotification", {data: notification, type: notification.type});
        }
    },
    mutations: {
        addNotifications(state, notifications) {
            if(Array.isArray(notifications)) {
                var m_notifs = [
                    ...notifications,
                    ...state.notifications
                ]
                state.notifications = m_notifs.filter((v,i,a)=>a.findIndex(t=>(t.id === v.id))===i)
            }
        },
        addNotification(state, notification) {
            state.notifications.unshift(notification);
        }
    },
    getters: {
        notifications(state) {
            return state.notifications;
        }
    }
}