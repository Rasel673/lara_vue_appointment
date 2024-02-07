import './bootstrap';
import 'admin-lte/plugins/jquery/jquery.min.js';
import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js';
import 'admin-lte/dist/js/adminlte.min.js';
import {createApp} from 'vue/dist/vue.esm-bundler';
import { createPinia } from 'pinia';
import router from './router/index.js';
import Login from './pages/auth/login.vue';



const pinia = createPinia();

const app=createApp({});

app.component('Login',Login);

app.use(pinia);

app.use(router).mount("#app");