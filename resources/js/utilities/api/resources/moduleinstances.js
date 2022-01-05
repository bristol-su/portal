import BaseResource from './../baseresource';

export default class extends BaseResource{

    create(attributes) {
        return this.request('post', '/module-instance', attributes);
    }

    update(id, attributes) {
        return this.request('patch', '/module-instance/' + id, attributes);
    }

    delete(id, name) {
        return this.request('delete', 'module-instance/' + id, {}, {}, name);
    }
}
