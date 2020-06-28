import BaseResource from './../baseresource';

export default class extends BaseResource{

    index(activityId, parameters) {
        return this.request('get', '/activity/' + activityId + '/progress', null, parameters);
    }

}
