import BaseResource from './../baseresource';

export default class extends BaseResource{

    userEvaluation(activityId, activityInstanceId, userId, groupId = null, roleId = null) {
        let params = {user_id: userId, activity_instance_id: activityInstanceId};
        if(groupId !== null) {
            params.group_id = groupId;
        }
        if(roleId !== null) {
            params.role_id = groupId;
        }
        return this.request('get', '/activity/' + activityId + '/module-instance/evaluate', null, params);
    }

    adminEvaluation(activityId, userId, groupId = null, roleId = null) {
        let params = {user_id: userId};
        if(groupId !== null) {
            params.group_id = groupId;
        }
        if(roleId !== null) {
            params.role_id = groupId;
        }
        return this.request('get', '/activity/' + activityId + '/module-instance/admin/evaluate', null, params);
    }

    create(attributes) {
        return this.request('post', '/module-instance', attributes);
    }

    update(id, attributes) {
        return this.request('patch', '/module-instance/' + id, attributes);
    }

}
