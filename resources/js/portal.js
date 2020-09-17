import {registerComponent} from '@/plugins/vue';

import PLogin from 'Pages/auth/PLogin.vue';
import PPortal from 'Pages/portal/PPortal.vue';

registerComponent('p-login', PLogin);
registerComponent('p-portal', PPortal);

// new Vue({
//     el: '#portal-vue-root',
//     vuetify,
//     components: {
//         PLogin,
//         PPortal,
//     }
// })
