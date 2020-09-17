import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

import UserPreferences from '@/utilities/UserPreferences';

Vue.use(Vuetify)

const opts = {
    theme: {
        dark: UserPreferences.get('dark-mode') === 'true'
    }
}

export default new Vuetify(opts)
