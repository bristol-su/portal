import createVue from '@/plugins/vue';

import PApp from 'Components/page/PApp.vue';
import PHeader from 'Components/page/PHeader.vue';
import PMain from 'Components/page/PMain.vue';
import PFooter from 'Components/page/PFooter.vue';

let Vue = createVue({
    el: '#vue-root-app',
    components: {
        PApp,
        PHeader,
        PMain,
        PFooter
    }
});

window.Vue = Vue;
