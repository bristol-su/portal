import {registerComponent, getComponents} from '@/plugins/vue';
import Vue from 'vue';
import vuetify from '@/plugins/vuetify' // path to vuetify export

import PApp from 'Components/page/PApp.vue';
import PHeader from 'Components/page/PHeader.vue';
import PMain from 'Components/page/PMain.vue';
import PFooter from 'Components/page/PFooter.vue';

registerComponent('p-app', PApp);
registerComponent('p-header', PHeader);
registerComponent('p-main', PMain);
registerComponent('p-footer', PFooter);

new Vue({
    name: 'App',
    el: '#vue-root-app',
    vuetify,
    components: getComponents()
});
