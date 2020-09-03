import Vue from 'vue';
import vuetify from './plugins/vuetify';

// import Vuetify from 'vuetify'

import axios from 'axios';
import api from "./utilities/api/api";
import VueFormGenerator from 'vue-form-generator'

import settingKeys from './utilities/settingKeys';

window.settingKeys = settingKeys;
Vue.use(VueFormGenerator);

Vue.prototype.$http = axios;
// Vue.prototype.$notify = new AWN({position: 'top-right'});
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

Vue.prototype.$api = new api(portal.API_URL, axios);
Vue.prototype.$csrf = token.content;

new Vue({
    el: '#vue-root',
    vuetify: vuetify
});

window.Vue = Vue;

window.processErrorsFromAxios = function(error) {
    if(error.response.status === 422) {
        if(error.response.data.hasOwnProperty('errors')) {
            window.vueEvents.$emit('validationErrorsSet', error.response.data);
        }
    }
};
