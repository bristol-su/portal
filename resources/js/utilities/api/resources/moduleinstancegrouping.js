import BaseResource from './../baseresource';

export default class extends BaseResource{

    getGroupings() {
        return this.request('get', '/module-instance-grouping');
    }

    addGrouping(heading) {
        return this.request('post', '/module-instance-grouping', {
            heading: heading
        })
    }

    moveGroupingUp(moduleGroupingId) {
        return this.request('post', '/module-instance-grouping/' + moduleGroupingId + '/order/up');
    }

    moveGroupingDown(moduleGroupingId) {
        return this.request('post', '/module-instance-grouping/' + moduleGroupingId + '/order/down');
    }

}
