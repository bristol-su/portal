import 'bootstrap';
import ValidationErrors from './components/alerts/ValidationErrors';
import Breadcrumbs from './components/breadcrumbs/Breadcrumbs';

new Vue({
    el: '#header-vue-root',

    components: {
        ValidationErrors,
        Breadcrumbs
    }
});
