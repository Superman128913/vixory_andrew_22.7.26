import Vue from 'vue';

Vue.filter('capitalize', value => {
    return value.toUpperCase();
});

Vue.filter('dollar', value => {
    return value / 100;
});

Vue.filter('length', value => {
    if(!value) {
        return "-"
    }

    if(value.length > 1) {
        return value[0] + "' " + value.substr(1) + "''"
    }
    else {
        return value + "'"
    }
});
Vue.filter('dash', value => {
    if(!value) {
        return "-"
    }
    return value;
});