import BaseResource from './../baseresource';

export default class extends BaseResource{

    index() {
        return this.request('get', '/action');
    }

    delete(actionId, name) {
        return this.request('delete', '/action-instance/' + actionId, {}, {}, name);
    }

}
