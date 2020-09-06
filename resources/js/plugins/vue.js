import Vue from 'vue';
import vuetify from '@/plugins/vuetify' // path to vuetify export

export default (options) => {
    let defaults = {
        vuetify
    };

    let mergedOptions = Object.assign(defaults, options);

    return new Vue(mergedOptions);
}
