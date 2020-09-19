// import './bootstrap';

import Vue from 'vue';
import vuetify from '@/plugins/vuetify';
// import Toolkit from '@bristol-su/frontend-toolkit'

import PLogin from 'Pages/auth/PLogin.vue';
import PPortal from 'Pages/portal/PPortal.vue';
import PApp from 'Components/page/PApp.vue';
import PHeader from 'Components/page/PHeader.vue';
import PMain from 'Components/page/PMain.vue';
import PFooter from 'Components/page/PFooter.vue';

// import PLogin from 'Pages/auth/PLogin.vue';
// import PPortal from 'Pages/portal/PPortal.vue';


// COuld components be a promise? TO load later to speed up page load.
// Load components from the class

// Load them in

// let registeredComponents = getComponents();

// Object.keys(registeredComponents).forEach(name => {
//     components[name] = registeredComponents[name];
// });
//

new Vue({
    el: '#vue-root-app',
    vuetify,
    components: {
        PApp,
        PHeader,
        PMain,
        PFooter,
        PLogin,
        PPortal
    }
});


