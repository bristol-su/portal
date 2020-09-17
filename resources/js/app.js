import Vue from 'vue';
import vuetify from '@/plugins/vuetify' // path to vuetify export
import {getComponents} from '@/plugins/vue';

import PApp from 'Components/page/PApp.vue';
import PHeader from 'Components/page/PHeader.vue';
import PMain from 'Components/page/PMain.vue';
import PFooter from 'Components/page/PFooter.vue';

// import PLogin from 'Pages/auth/PLogin.vue';
// import PPortal from 'Pages/portal/PPortal.vue';


// COuld components be a promise? TO load later to speed up page load.
// Load components from the class

// Load them in

let registeredComponents = getComponents();

let components = {
    PApp,
    PHeader,
    PMain,
    PFooter
}

Object.keys(registeredComponents).forEach(name => {
    components[name] = registeredComponents[name];
});

console.log(components);

new Vue({
    el: '#vue-root-app',
    vuetify,
    components: components
});
