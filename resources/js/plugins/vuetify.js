import Vue from 'vue'

import 'vuetify/dist/vuetify.min.css'
import store from '../store'
import i18n from './i18n'
import Vuetify from 'vuetify'

Vue.use(Vuetify)

export default new Vuetify({
    lang: {
        t: (key, ...params) => i18n.t(key, params),
        current: 'en',
    },
    theme: {
        options: {
            customProperties: true,
        },
        themes: {
            light: {
                primary: store.getters.getThemeColor,
                secondary: '#424242',
                accent: '#82B1FF',
                error: '#FF5252',
                info: '#2196F3',
                success: '#4CAF50',
                warning: '#FFC107',
            },
        },
    },
})
