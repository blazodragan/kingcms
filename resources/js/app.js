import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { autoAnimatePlugin } from "@formkit/auto-animate/vue";
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { can } from "craftable-pro/plugins/can";
import { createI18n } from "vue-i18n";
const appName = import.meta.env.VITE_APP_NAME || 'Mietwagenparadies';
axios.defaults.withCredentials = true;

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {

        const i18n = createI18n({
            locale: props.initialPage.props.locale, // user locale by props
            fallbackLocale: "en", // set fallback locale
        });

        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(autoAnimatePlugin)
            .use(ZiggyVue, Ziggy)
            .directive("can", can)
            .use(i18n)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
