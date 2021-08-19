import 'bootstrap';
import ValidationErrors from './components/alerts/ValidationErrors';
import Breadcrumbs from './components/breadcrumbs/Breadcrumbs';
require('./ui-kit');

new Vue({
    el: '#header-vue-root',

    components: {
        ValidationErrors,
        Breadcrumbs
    }
});
