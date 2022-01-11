import axios from 'axios';
import Vue from 'vue';
import api from "./utilities/api/api";
import Control from '@bristol-su/control-js-api-client';
import _ from 'lodash';
import ActivityProgress from './management/progress/ActivityProgress.vue';
import ActivityIndex from './management/activity/index/Index';
import ActivityShow from './management/activity/show/Show';
import ActivityCreate from './management/activity/create/Create';
import ModuleCreate from './management/moduleinstance/create/Create';
import ModuleShow from './management/moduleinstance/show/Show';

require('./ui-kit');

import settingKeys from './settings';

window.settingKeys = settingKeys;

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.prototype.$api = new api(Vue.prototype.$httpBasic);
Vue.prototype.$control = new Control(portal.API_URL + '/control', axios);

window.vueEvents = new Vue({});

new Vue({
    el: '#vue-root',
    components: {
        ActivityProgress,

        ActivityIndex,
        ActivityShow,
        ActivityCreate,

        ModuleCreate,
        ModuleShow
    }
});

window.Vue = Vue;
window._ = _;
