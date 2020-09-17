import Vue from 'vue';
import vuetify from '@/plugins/vuetify' // path to vuetify export

import PApp from 'Components/page/PApp.vue';
import PHeader from 'Components/page/PHeader.vue';
import PMain from 'Components/page/PMain.vue';
import PFooter from 'Components/page/PFooter.vue';

// import PLogin from 'Pages/auth/PLogin.vue';
// import PPortal from 'Pages/portal/PPortal.vue';


new Vue({
    el: '#vue-root-app',
    vuetify,
    components: {
        PApp,
        PHeader,
        PMain,
        PFooter,

        // PLogin,
        // PPortal
    }
});
