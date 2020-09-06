import createVue from '@/plugins/vue';

import PLogin from 'Pages/auth/PLogin.vue';

createVue({
    el: '#vue-root-portal',
    components: {
        PLogin
    }
})
