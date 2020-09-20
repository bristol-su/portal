import BaseResource from './../baseresource';

export default class extends BaseResource{

    getBelongingToLogic(id) {
        return this.request('get', '/logic/' + id + '/filter-instance');
    }

    getAll() {
        return this.request('get', '/filter');
    }


}
