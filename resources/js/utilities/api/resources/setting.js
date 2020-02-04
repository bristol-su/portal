import BaseResource from './../baseresource';

export default class extends BaseResource{

    all() {
        return this.request('get', '/setting');
    }

    get(key, defaultValue = null) {
        return this.request('get', '/setting/' + key, {}, {default: defaultValue});
    }

    set(key, value) {
        return this.request('patch', '/setting/' + key, {
            value: value
        });
    }

}
