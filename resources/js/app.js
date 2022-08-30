require('./bootstrap');

import Vue from 'vue';
import store from './store'
import './plugins/vuetify'
import './theme/default.sass'
import vuetify from './plugins/vuetify'
import i18n from './plugins/i18n'
import '@mdi/font/css/materialdesignicons.css'
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue';
import PortalVue from 'portal-vue';
import {Notyf} from 'notyf';
import 'notyf/notyf.min.css';
import * as filters from './filters'
import { InertiaProgress } from '@inertiajs/progress'

InertiaProgress.init({
    color: '#ff0000',
    showSpinner: true,
})

Vue.mixin({ methods: { route } });
Vue.use(InertiaPlugin);
Vue.use(PortalVue);

Object.keys(filters).forEach(key => {
    Vue.filter(key, filters[key]);
});

Vue.prototype.$toast = new Notyf();

const app = document.getElementById('app');

new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
    vuetify,
    store: store,
    i18n
}).$mount(app);
