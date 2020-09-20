import OwnedResource from './resources/owned-resource';
import Activities from './resources/activities';
import ActivityEvaluation from './resources/activity-evaluation';

// TODO Implement Cache
export default class {
    constructor(baseUrl, axios) {
        this._http = axios.create({
            baseURL: baseUrl,
            withCredentials: true,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
        });
        this._http.interceptors.response.use(function (response) {
            return response;
        }, function (error) {
            window.processErrorsFromAxios(error);
            return Promise.reject(error);
        });
    }

    // TODO Does this always work?
    asRole(roleId) {
        this._http.interceptors.request.use(function(config) {
            config.params['role_id'] = roleId;
        }, function (error) {
            return Promise.reject(error);
        });
        return this;
    }

    ownedResource() {
        return new OwnedResource(this._http);
    }

    activities() {
        return new Activities(this._http);
    }

    activityEvaluation() {
        return new ActivityEvaluation(this._http);
    }


}
