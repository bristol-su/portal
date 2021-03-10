import BaseResource from './../baseresource';

export default class extends BaseResource{

    getBelongingToActivity(id) {
        return this.request('get', '/activity/' + id + '/module-instance');
    }

    all() {
        return this.request('get', '/module');
    }

    getByAlias(alias) {
        return this.request('get', '/module/' + alias);
    }

    getGroupings() {
        return this.request('get', '/module-instance-grouping');
    }

    addGrouping(heading) {
        return this.request('post', '/module-instance-grouping', {
            heading: heading
        })
    }
}
