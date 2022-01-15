import BaseResource from './../baseresource';

export default class extends BaseResource{

    index(name) {
        return this.request('get', '/connection', {}, {}, name);
    }

    test(id) {
        return this.request('get', '/connection/' + id + '/test');
    }

    delete(id) {
        return this.request('delete', '/connection/' + id);
    }

    update(id, attributes) {
        return this.request('put', '/connection/' + id, attributes);
    }

    create(attributes) {
        return this.request('post', '/connection', attributes);
    }

    allForService(service) {
        return this.request('get', '/service/' + service + '/connection');
    }

}
