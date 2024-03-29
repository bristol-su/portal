import BaseResource from './../baseresource';

export default class extends BaseResource{

    get(id) {
        return this.request('get', '/module-instance-permission/' + id);
    }

    create(ability, logicId, moduleInstanceId) {
        return this.request('post', '/module-instance-permission', {
            ability: ability, logic_id: logicId, module_instance_id: moduleInstanceId}
        );
    }

    update(id, logicId) {
        return this.request('put', '/module-instance-permission/' + id, {logic_id: logicId});
    }

    updateMany(moduleInstanceId, data, name) {
        return this.request('put', '/module-instance/' + moduleInstanceId + '/module-instance-permission/many', {permissions: data}, {}, name)
    }

    forModuleInstance(moduleInstanceId) {
        return this.request('get', '/module-instance/' + moduleInstanceId + '/module-instance-permission')
    }

    delete(id) {
        return this.request('delete', '/module-instance-permission/' + id);
    }

}
