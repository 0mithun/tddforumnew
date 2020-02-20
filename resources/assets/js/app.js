
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 import Flash from './components/Flash.vue';
 import Paginator from './components/Paginator.vue';
 import UserNotifications from './components/UserNotifications';
 import AvatarForm from './components/AvatarForm';
 import Wysiwyg from './components/Wysiwyg';
 import ThreadView from './pages/Thread.vue';

// Vue.component('flash', require('./components/Flash.vue'));
// Vue.component('paginator', require('./components/Paginator.vue'));
// Vue.component('user-notifications', require('./components/UserNotifications.vue'));
// Vue.component('avatar-form', require('./components/AvatarForm.vue'));
// Vue.component('wysiwyg', require('./components/Wysiwyg.vue'));

// Vue.component('thread-view', require('./pages/Thread.vue'));



const app = new Vue({
    el: '#app',
    components:{
        Flash,
        Paginator,
        UserNotifications,
        AvatarForm,
        Wysiwyg,
        ThreadView
    }
});
