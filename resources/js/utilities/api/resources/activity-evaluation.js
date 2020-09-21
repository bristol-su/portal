import BaseResource from './../baseresource';

export default class extends BaseResource{

    forResource(activityId, userId, groupId = null, roleId = null) {
        let params = {user_id: userId};
        if(groupId !== null) {
            params.group_id = groupId;
        } if(roleId !== null) {
            params.role_id = roleId;
        }

        return this.request('get', '/activity/' + activityId + '/evaluate/resource', null, params);
    }

}
