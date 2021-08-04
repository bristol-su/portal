import BaseResource from './../baseresource';

export default class extends BaseResource{

    get(key) {
        return this.request('get', '/setting/' + key);
    }

    set(key, value) {
        return this.request('patch', '/setting/' + key, {
            value: value
        });
    }

}
