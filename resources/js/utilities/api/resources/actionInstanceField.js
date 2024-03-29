import BaseResource from './../baseresource';

export default class extends BaseResource{

    create(parameters) {
        return this.request('post', '/action-instance-field', parameters);
    }

    update(id, parameters) {
        return this.request('patch', '/action-instance-field/' + id, parameters);
    }

    allThroughActionInstance(actionInstanceId) {
        return this.request('get', '/action-instance/' + actionInstanceId + '/action-instance-field');
    }

    setMany(actionInstanceId, data, name) {
        return this.request('post', 'action-instance/' + actionInstanceId + '/action-instance-fields', {data: data}, {}, name);
    }

}
