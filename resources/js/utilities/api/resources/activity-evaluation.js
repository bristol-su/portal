import BaseResource from './../baseresource';

export default class extends BaseResource{

    forRole(userId, groupId, roleId, activityId) {
        return this.request('get', '/activity/' + activityId + '/evaluate/role', null, {
            user_id: userId,
            group_id: groupId,
            role_id: roleId
        });
    }

    forGroup(userId, groupId, activityId) {
        return this.request('get', '/activity/' + activityId + '/evaluate/group', null, {
            user_id: userId,
            group_id: groupId
        });
    }

    forUser(userId, activityId) {
        return this.request('get', '/activity/' + activityId + '/evaluate/user', null, {
            user_id: userId
        });
    }

    forAdminRole(userId, groupId, roleId, activityId) {
        return this.request('get', '/activity/' + activityId + '/admin/evaluate/role', null, {
            user_id: userId,
            group_id: groupId,
            role_id: roleId
        });
    }

    forAdminGroup(userId, groupId, activityId) {
        return this.request('get', '/activity/' + activityId + '/admin/evaluate/group', null, {
            user_id: userId,
            group_id: groupId
        });
    }

    forAdminUser(userId, activityId) {
        return this.request('get', '/activity/' + activityId + '/admin/evaluate/user', null, {
            user_id: userId
        });
    }

}
