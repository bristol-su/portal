import BaseResource from './../baseresource';

export default class extends BaseResource{

    forRole(userId, groupId, roleId) {
        return this.request('get', '/activity/role', null, {
            user_id: userId,
            group_id: groupId,
            role_id: roleId
        });
    }

    forGroup(userId, groupId) {
        return this.request('get', '/activity/group', null, {
            user_id: userId,
            group_id: groupId
        });
    }

    forUser(userId) {
        return this.request('get', '/activity/user', null, {
            user_id: userId
        });
    }

    forAdminRole(userId, groupId, roleId) {
        return this.request('get', '/activity/admin/role', null, {
            user_id: userId,
            group_id: groupId,
            role_id: roleId
        });
    }

    forAdminGroup(userId, groupId) {
        return this.request('get', '/activity/admin/group', null, {
            user_id: userId,
            group_id: groupId
        });
    }

    forAdminUser(userId) {
        return this.request('get', '/activity/admin/user', null, {
            user_id: userId
        });
    }

}
