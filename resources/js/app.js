import axios from 'axios';
import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue'
import AWN from "awesome-notifications";
import api from "./utilities/api/api";
import control from '@bristol-su/control-js-api-client';
import VueFormGenerator from 'vue-form-generator'
import _ from 'lodash';

import ModuleInstances from './components/portal/module_instances/ModuleInstances';
import ActivitySidebar from "./components/portal/activity/ActivitySidebar";
import Sidebar from './management/Sidebar';
import ActivityIndex from './management/activity/index/Index';
import ActivityShow from './management/activity/show/Show';
import ActivityCreate from './management/activity/create/Create';
import ModuleInstanceShow from './management/moduleinstance/show/Show';
import ModuleInstanceCreate from './management/moduleinstance/create/Create';
import LogicShow from './management/logic/show/Show';
import LogicIndex from './management/logic/index/Index';
import LogicCreate from './management/logic/create/Create';
import ActionShow from './management/action/show/Show';
import ActionCreate from './management/action/create/Create';
import Activities from './components/portal/activity/index/show/Activities';
import LogIntoResource from './components/login/LogIntoResource';
import ToggleAdminOrParticipant from './components/portal/ToggleAdminOrParticipant';
import SitePermissions from './management/sitepermissions/index/Index';
import SitePermission from './management/sitepermissions/show/Show';
import ActivityProgress from './management/progress/ActivityProgress';
import ConnectorIndex from './management/connector/index/Index';
import settingKeys from './utilities/settingKeys';
import ActivityInstanceSwitcher from './components/portal/activity/ActivityInstanceSwitcher';
import Welcome from './components/welcome/Welcome';
import Settings from './management/settings/Settings';
import SocialLogin from './components/login/social/SocialLogin';
import Clipboard from 'v-clipboard'

import ValidationErrors from './components/alerts/ValidationErrors';

window.settingKeys = settingKeys;
Vue.use(BootstrapVue);
Vue.use(VueFormGenerator);
Vue.use(Clipboard);

Vue.prototype.$http = axios;
Vue.prototype.$notify = new AWN({position: 'top-right'});
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

Vue.prototype.$api = new api(portal.API_URL, axios);
Vue.prototype.$control = new control(portal.API_URL + '/control', axios);
Vue.prototype.$csrf = token.content;

window.vueEvents = new Vue({});

new Vue({
    el: '#vue-root',

    components: {
        ModuleInstances,
        ActivitySidebar,
        Sidebar,

        ActivityIndex,
        ActivityShow,
        ActivityCreate,

        ModuleInstanceShow,
        ModuleInstanceCreate,

        LogicShow,
        LogicIndex,
        LogicCreate,

        ActionShow,
        ActionCreate,

        Activities,
        ToggleAdminOrParticipant,

        LogIntoResource,

        SitePermissions,
        SitePermission,

        ActivityInstanceSwitcher,

        ConnectorIndex,

        Welcome,
        Settings,

        SocialLogin,
        ActivityProgress

    }
});

window.Vue = Vue;
window._ = _;

window.processErrorsFromAxios = function(error) {
    if(error.response.status === 422) {
        if(error.response.data.hasOwnProperty('errors')) {
            window.vueEvents.$emit('validationErrorsSet', error.response.data);
        }
    }
};
