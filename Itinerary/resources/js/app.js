require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { createStore } from 'vuex';
import { index } from './store/index.js';
import LitepieDatepicker from 'litepie-datepicker';
import Notifications from 'notiwind';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

const store = createStore({
    modules: {
        index
    }
});

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .mixin({ methods: { route } })
            .use(plugin)
            .use(store)
            .use(LitepieDatepicker)
            .use(Notifications)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
