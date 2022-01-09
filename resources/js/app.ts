import { createApp } from 'vue';
import router from "./router";
import App from './App.vue';

import Default from './layouts/DefaultLayout.vue';
import Login from './layouts/LoginLayout.vue';

createApp(App).use(router)
    .component('default-layout', Default)
    .component('login-layout', Login)
    .mount('#app');
