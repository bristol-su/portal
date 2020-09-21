import Vue from 'vue';
import vuetify from '@/plugins/vuetify';
import VueFormGenerator from 'vue-form-generator'
import PLogin from 'Pages/auth/PLogin';
import PRegister from 'Pages/auth/PRegister';
import PVerify from 'Pages/auth/PVerify';
import PPasswordEmailForm from 'Pages/auth/PPasswordEmailForm';
import PResetPassword from 'Pages/auth/PResetPassword';

import PActivitiesLayout from 'Pages/portal/PActivitiesLayout';
import PActivityLayout from 'Pages/portal/PActivityLayout';
import PDashboard from 'Pages/portal/PDashboard';
import PApp from 'Components/page/PApp';
import PHeader from 'Components/page/PHeader';
import axios from 'axios';
Vue.use(VueFormGenerator);

import PNavDrawerPortal from 'Components/page/navbars/PNavDrawerPortal';
import PNavDrawerActivity from 'Components/page/navbars/PNavDrawerActivity';
import PNavDrawerModule from 'Components/page/navbars/PNavDrawerModule';
import PNavDrawerSettings from 'Components/page/navbars/PNavDrawerSettings';
Vue.component('p-nav-drawer-portal', PNavDrawerPortal);
Vue.component('p-nav-drawer-activity', PNavDrawerActivity);
Vue.component('p-nav-drawer-module', PNavDrawerModule);
Vue.component('p-nav-drawer-settings', PNavDrawerSettings);

import PMain from 'Components/page/PMain';
import PFooter from 'Components/page/PFooter';
import api from '@/utilities/api/api';


axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

Vue.prototype.$api = new api(portal.API_URL, axios);

new Vue({
    el: '#vue-root-app',
    vuetify,
    components: {
        PApp,
        PHeader,
        PMain,
        PFooter,

        PLogin,
        PRegister,
        PVerify,
        PPasswordEmailForm,
        PResetPassword,

        PActivitiesLayout,
        PActivityLayout,
        PDashboard
    }
});

window.Vue = Vue;
