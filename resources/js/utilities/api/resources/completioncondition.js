import BaseResource from './../baseresource';

export default class extends BaseResource{


    getByAlias(moduleAlias, conditionAlias) {
        return this.request('get', 'module/' + moduleAlias + '/completion-condition/' + conditionAlias);
    }

    allForModule(moduleAlias) {
        return this.request('get', 'module/' + moduleAlias + '/completion-condition');
    }

}
