import { createVue } from '@/plugins/vue';

import PLogin from 'Pages/auth/PLogin.vue';

createVue({
    name: 'Portal',
    key: 'portal',
    components: {
        PLogin
    }
})
