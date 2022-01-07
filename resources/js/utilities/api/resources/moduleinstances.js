import BaseResource from './../baseresource';

export default class extends BaseResource{

    create(attributes) {
        return this.request('post', '/module-instance', attributes);
    }

    update(id, attributes, name) {
        return this.request('patch', '/module-instance/' + id, attributes, {}, name);
    }

    delete(id, name) {
        return this.request('delete', 'module-instance/' + id, {}, {}, name);
    }
}
