import vuetify from '@/plugins/vuetify' // path to vuetify export

let createVue = (options) => {

    let defaults = {
        vuetify,
        template: '<div><slot></slot></div>'
    };

    let mergedOptions = Object.assign(defaults, options);

    window.injector.inject(mergedOptions);
}

let setupInjections = () => {
    window.injector = new VueConfigInjector();
}

class VueConfigInjector {

    constructor() {
        this._callback = null;
        this._config = null;
    }

    inject(config) {
        this._config = config;
        if(this._callback !== null) {
            this._callback(config);
        }
    }

    hasConfig() {
        return this._config !== null;
    }

    get() {
        return this._config;
    }

    onModified(callback) {
        this._callback = callback;
    }

}

export {createVue, VueConfigInjector, setupInjections}
