import BaseResource from './../baseresource';

export default class extends BaseResource{

    create(attributes) {
        return this.request('post', '/activity', attributes);
    }

    update(id, attributes) {
        return this.request('patch', '/activity/' + id, attributes);
    }

    progress(activityId) {
        return this.request('get', '/activity/' + activityId + '/progress');
    }
}
