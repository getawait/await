require('./bootstrap');

import Vue from 'vue';

import { InertiaApp } from '@inertiajs/inertia-vue';
import { InertiaForm } from 'laravel-jetstream';
import PortalVue from 'portal-vue';
import VueHighlightJS from 'vue-highlightjs';
import { library } from '@fortawesome/fontawesome-svg-core'
import { faBook } from '@fortawesome/free-solid-svg-icons'
import { faDiscord } from '@fortawesome/free-brands-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faBook)
library.add(faDiscord)

Vue.component('FontAwesomeIcon', FontAwesomeIcon)

Vue.config.productionTip = false

Vue.use(InertiaApp);
Vue.use(InertiaForm);
Vue.use(PortalVue);
Vue.use(VueHighlightJS)

const app = document.getElementById('app');
const can = (permissions = []) => (permission) => {
  if (permissions.includes('*')) {
    return true;
  }

  return permissions.includes(permission);
}

new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
                transformProps: props => {
                  return {
                    ...props,
                    can: can(props.user.permissions),
                  }
                },
            },
        }),
}).$mount(app);
