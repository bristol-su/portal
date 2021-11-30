import axios from 'axios';
import Vue from 'vue';
import api from "./utilities/api/api";
import Control from '@bristol-su/control-js-api-client';
import _ from 'lodash';
import ActivityProgress from './management/progress/ActivityProgress.vue';
require('./ui-kit');

import settingKeys from './settings';

window.settingKeys = settingKeys;

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.prototype.$api = new api(portal.API_URL, axios);
Vue.prototype.$control = new Control(portal.API_URL + '/control', axios);

window.vueEvents = new Vue({});

new Vue({
    el: '#vue-root',
    components: {ActivityProgress}
});

window.Vue = Vue;
window._ = _;
