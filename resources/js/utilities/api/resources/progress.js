import BaseResource from './../baseresource';

export default class extends BaseResource{

    index(activityId, parameters) {
        return this.request('get', '/activity/' + activityId + '/progress', null, parameters);
    }

    takeSnapshot(activityId) {
        return this.request('post', '/activity/' + activityId + '/progress/snapshot');
    }

}
