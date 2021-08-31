import axios from 'axios';
import Vue from 'vue';
import api from "./utilities/api/api";
import control from '@bristol-su/control-js-api-client';
import _ from 'lodash';
require('./ui-kit');

import ModuleInstances from './components/portal/module_instances/ModuleInstances';
import ActivitySidebar from "./components/portal/activity/ActivitySidebar";
import Activities from './components/portal/activity/index/show/Activities';
import LogIntoResource from './components/login/LogIntoResource';
import ToggleAdminOrParticipant from './components/portal/ToggleAdminOrParticipant';
import settingKeys from './settings';
import ActivityInstanceSwitcher from './components/portal/activity/ActivityInstanceSwitcher';
import Welcome from './components/welcome/Welcome';
import SocialLogin from './components/login/social/SocialLogin';

window.settingKeys = settingKeys;

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.prototype.$api = new api(portal.API_URL, axios);
Vue.prototype.$control = new control(portal.API_URL + '/control', axios);

window.vueEvents = new Vue({});

new Vue({
    el: '#vue-root',

    components: {
        ModuleInstances,
        ActivitySidebar,

        Activities,
        ToggleAdminOrParticipant,

        LogIntoResource,

        ActivityInstanceSwitcher,

        Welcome,
        SocialLogin,
    }
});

window.Vue = Vue;
window._ = _;
