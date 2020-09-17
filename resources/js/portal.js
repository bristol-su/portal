import Vue from 'vue';
import vuetify from '@/plugins/vuetify';

import PLogin from 'Pages/auth/PLogin.vue';
import PPortal from 'Pages/portal/PPortal.vue';

new Vue({
    el: '#portal-vue-root',
    vuetify,
    components: {
        PLogin,
        PPortal,
    }
})
