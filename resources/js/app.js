import {setupInjections} from '@/plugins/vue';
import Vue from 'vue';
import vuetify from '@/plugins/vuetify' // path to vuetify export

import PApp from 'Components/page/PApp.vue';
import PHeader from 'Components/page/PHeader.vue';
import PMain from 'Components/page/PMain.vue';
import PFooter from 'Components/page/PFooter.vue';

setupInjections();

new Vue({
    name: 'App',
    el: '#vue-root-app',
    vuetify,
    components: {
        PApp,
        PHeader,
        PMain,
        PFooter
    }
});
