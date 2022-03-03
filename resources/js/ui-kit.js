import Vue from 'vue';
import Toolkit from '@bristol-su/frontend-toolkit';

global.Toolkit = Toolkit;

Vue.use(Toolkit, {
    tinyMceKey: portal.TINY_MCE_KEY
});
