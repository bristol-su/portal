import BaseResource from './../baseresource';

export default class extends BaseResource{

    create(attributes) {
        return this.request('post', '/activity', attributes);
    }

    update(id, attributes) {
        return this.request('patch', '/activity/' + id, attributes);
    }

    progress(activityId, page=1, perPage=10) {
        return this.request('get', '/activity/' + activityId + '/progress', {}, {page: page, per_page: perPage});
    }

    delete(activityId) {
        return this.request('delete', '/activity/' + activityId);
    }
}
