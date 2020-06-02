import BaseResource from './../baseresource';

export default class extends BaseResource{


    create(attributes) {
        return this.request('post', 'completion-condition-instance', attributes);
    }

    update(id, attributes) {
        return this.request('patch', 'completion-condition-instance/' + id, attributes);
    }

}
