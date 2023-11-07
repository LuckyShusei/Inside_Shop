/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import mopi from './mopi';
import router from './routes';
import Vue from "vue";

window.mopi = mopi;

mopi.init({
    fields: [
        'text',
        'password',
        'textarea',
        'auto_increment',
        'upload_file',
        'select',
        'select_number',
        'checkbox',
        'toggle',
        'datepicker',
        'datetime_picker',
        'parent',
        'multiselect',
        'update_at'
    ],
    columns: [
        'text',
        'toggle',
        'thumbnail',
    ],
    components: [
        'list',
        'detail',
    ]
});
const store = mopi.store;
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    store
});
export default app;
