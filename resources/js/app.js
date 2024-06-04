import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
// import PrimeVue from 'primevue/config';
// import { Icon } from '@ant-design/icons-vue';

const appName = import.meta.env.VITE_APP_NAME || 'myclass';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })


            // .component(Icon,'Icon')
            .use(plugin)
            .use(ZiggyVue)

            // .use(PrimeVue, {
            //     unstyled: true
            // }) 
            
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
