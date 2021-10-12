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

    update(id, attributes) {
        return this.request('patch', '/logic/' + id, attributes);
    }

    attachFilter(logicId, filterId, type) {
        return this.request('patch', '/logic/' + logicId + '/filter-instance/' + filterId, {logic_type: type});
    }

    removeFilter(logicId, filterId) {
        return this.request('delete', '/logic/' + logicId + '/filter-instance/' + filterId);
    }

    audience(logicId, perPage = 10, page = 1) {
        return this.request('get', '/logic/' + logicId + '/audience', null, {per_page: perPage, page: page});
    }

    userAudience(logicId, perPage = 10, page = 1) {
        return this.request('get', '/logic/' + logicId + '/audience/user', null, {per_page: perPage, page: page});
    }

    groupAudience(logicId, perPage = 10, page = 1) {
        return this.request('get', '/logic/' + logicId + '/audience/group', null, {per_page: perPage, page: page});
    }

    roleAudience(logicId, perPage = 10, page = 1) {
        return this.request('get', '/logic/' + logicId + '/audience/role', null, {per_page: perPage, page: page});
    }
}
