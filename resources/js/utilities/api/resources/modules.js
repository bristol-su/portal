import BaseResource from './../baseresource';

export default class extends BaseResource{

    getBelongingToActivity(id, name) {
        return this.request('get', '/activity/' + id + '/module-instance', {}, {}, name);
    }

    all() {
        return this.request('get', '/module');
    }

    getByAlias(alias) {
        return this.request('get', '/module/' + alias);
    }

    getGroupings(activityId, name) {
        return this.request('get', '/activity/' + activityId + '/module-instance-grouping', {}, {}, name);
    }

    addGrouping(heading, activityId) {
        return this.request('post', '/activity/' + activityId + '/module-instance-grouping', {
            heading: heading
        })
    }

    deleteGrouping(groupingId, name) {
        return this.request('delete', '/grouping/' + groupingId, {}, {}, name);
    }

    updateGrouping(groupingId, heading) {
        return this.request('patch', '/grouping/' + groupingId, {
            heading: heading
        })
    }

    moveGroupingUp(id, name) {
        return this.request('post', '/grouping/' + id + '/up', {}, {}, name);
    }

    moveGroupingDown(id, name) {
        return this.request('post', '/grouping/' + id + '/down', {}, {}, name);
    }

    moveUp(id, name) {
        return this.request('post', '/module-instance/' + id + '/up', {}, {}, name);
    }

    moveDown(id, name) {
        return this.request('post', '/module-instance/' + id + '/down', {}, {}, name);
    }
}
