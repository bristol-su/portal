import BaseResource from './../baseresource';

export default class extends BaseResource{

    get(id) {
        return this.request('get', '/logic/' + id);
    }

    all() {
        return this.request('get', '/logic');
    }

    create(attributes) {
        return this.request('post',  '/logic', attributes);
    }

    audience(logicId) {
        return this.request('get', '/logic/' + logicId + '/audience');
    }

    update(id, attributes) {
        return this.request('patch', '/logic/' + id, attributes);
    }

    attachFilter(logicId, filterId, type) {
        return this.request('patch', '/logic/' + logicId + '/filter-instance/' + filterId, {logic_type: type});
    }

    removeFilter(logicId, filterId) {
        return this.request('delete', '/logic/' + logicId + '/filter-instance/' + filterId);
    }

    userAudience(logicId) {
        return this.request('get', '/logic/' + logicId + '/audience/user');
    }

    groupAudience(logicId) {
        return this.request('get', '/logic/' + logicId + '/audience/group');
    }

    roleAudience(logicId) {
        return this.request('get', '/logic/' + logicId + '/audience/role');
    }

    refresh(logicId) {
        return this.request('post', '/logic/' + logicId + '/refresh');
    }
}
