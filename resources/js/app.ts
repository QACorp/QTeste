/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import {createApp} from 'vue';
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css'
import axios from "axios";
import {LoaderStore} from "@/GlobalStore/LoaderStore";
// import {PermissionStore} from "@/GlobalStore/PermissionStore";

//axios.defaults.headers.common['Authorization'] = 'Bearer ' + document.querySelector("meta[name='api-token']").getAttribute('content');
export const axiosApi = axios.create({
    headers: {
        'Authorization': 'Bearer ' + document.querySelector("meta[name='api-token']")?.getAttribute('content')
    },
    baseURL: import.meta.env.VITE_API_URL
});

axiosApi.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    LoaderStore.showLoader = false;
    return Promise.reject(error);
});
if(document.querySelector("meta[name='api-token']")?.getAttribute('content')){
     axiosApi.get('user/permissoes')
        .then((response) => {
            PermissionStore.permissions = response.data.map((item) => {
                return item.name;
            });
        }).catch((error) => {
            console.log(error);
        });
}


const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: 'mdi', // This is already the default value - only for display purposes
    },
})
/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});
app.use(vuetify);
//
//  import ExampleComponent from './../../app/Modules/GestaoProjetos/Views/Vue/components/SprintSelect.vue';
//  app.component('SprintSelect', ExampleComponent);
import Preloader from "@/components/Preloader.vue";
import {PermissionStore} from "@/GlobalStore/PermissionStore";
app.component('Preloader', Preloader);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Object.entries(import.meta.glob('./../../app/Modules/**/Views/Vue/components/*.vue', { eager: true }))
    .forEach(([path, definition]:any) => {
        app.component(path.split('/')
            .pop()
            .replace(/\.\w+$/, ''), definition.default);
});


/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#vue');
