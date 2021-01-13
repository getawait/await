require('./bootstrap');

import Vue from 'vue';

import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue';
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

Vue.mixin({ methods: { route } });
Vue.use(InertiaPlugin);
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
                    can: props.user ? can(props.user.permissions) : null,
                  }
                },
            },
        }),
}).$mount(app);
