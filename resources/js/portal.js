import createVue from '@/plugins/vue';

import PLogin from 'Pages/auth/PLogin.vue';

createVue({
    name: 'Portal',
    el: '#vue-root-portal',
    components: {
        PLogin
    }
})
