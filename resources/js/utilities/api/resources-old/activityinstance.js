import BaseResource from './../baseresource';

export default class extends BaseResource{

    create(attributes) {
        return this.request('post', '/activity-instance', attributes);
    }

    search(activityId, query) {
        return this.request('post', '/activity/' + activityId + '/activity-instance/search', {
            query: query
        })
    }

    progress(activityInstanceId) {
        return this.request('get', '/progress/activity-instance/' + activityInstanceId);
    }
}
