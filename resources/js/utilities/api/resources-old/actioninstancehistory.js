import BaseResource from './../baseresource';

export default class extends BaseResource{

    forActionInstance(actionInstanceId) {
        return this.request('get', '/action-instance/' + actionInstanceId + '/history');
    }


}
