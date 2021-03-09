import BaseResource from './../baseresource';

export default class extends BaseResource{

    create(attributes) {
        return this.request('post', '/module-instance', attributes);
    }

    update(id, attributes) {
        return this.request('patch', '/module-instance/' + id, attributes);
    }

    moveUp(moduleId) {
        return this.request('post', '/module-instance/' + moduleId + '/order/up');
    }

    moveDown(moduleId) {
        return this.request('post', '/module-instance/' + moduleId + '/order/down');
    }

}
