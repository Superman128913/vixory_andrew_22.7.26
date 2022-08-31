import store from './store'

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;
window.axios.defaults.baseURL = process.env.VUE_APP_URL + "/" || "http://c2c.test/";

window.axios.interceptors.response.use(function (response) {
    return response
}, function (error) {
    if (error.response && error.response.status == 401) {
        store.dispatch('logoutUser')
        window.location.href = '/entry'
    }
    else if (error.response && error.response.status == 503) {
        var href_string = window.location.href;
        if(!href_string.includes("maintenance-mode")) {
            store.dispatch('logoutUser')
            window.location.href = '/maintenance-mode'
        }
    }
    return Promise.reject(error)
});