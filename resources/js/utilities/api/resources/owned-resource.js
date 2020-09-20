import BaseResource from './../baseresource';

export default class extends BaseResource{

    get() {
        return this.request('get', '/owned-resource');
    }

}
