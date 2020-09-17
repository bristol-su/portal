import UserPreferences from '@/utilities/UserPreferences';

export default {
    methods: {
        getUserPreference(preference) {
            return UserPreferences.get(preference)
        },
        setUserPreference(preference, value) {
            UserPreferences.set(preference, value)
        }
    }
}
