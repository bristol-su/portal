import Vue from 'vue'
import vuetify from '@/plugins/vuetify' // path to vuetify export

new Vue({
    el: '#portal-vue-root',
    vuetify,
})

// This is used so module components can register their own components here...
window.Vue = Vue;

