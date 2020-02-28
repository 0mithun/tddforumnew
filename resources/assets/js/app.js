
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
import Typhaed from './components/Typehead.vue';

import TinyMCE from 'tinymce-vue-2';


Vue.component('tiny-mce', TinyMCE);



import UnscribeButton from './components/UnscribeButton';
Vue.component('unscribe-button', UnscribeButton);

import FavoriteThread from './components/FavoriteThread.vue';
Vue.component('favorite-thread',FavoriteThread);

import LikeButton from './components/LikeButton.vue';
Vue.component('like-button', LikeButton);

import NewTag from './components/NewTag.vue'
Vue.component('new-tag', NewTag);

import vSelect from 'vue-select'

Vue.component('v-select', vSelect)
import 'vue-select/dist/vue-select.css';



window.tinekey = 'l1vdc832pqx5u7o6t5umdpxns0sak10bu9mrtb0m1qbspk9g';

import * as uiv from 'uiv'

Vue.use(uiv)

import { Alert } from 'uiv'

import ChannelHead from './components/ChannelHead.vue'
Vue.component('channel-head', ChannelHead)


window.eventBus = new  Vue();
const app = new Vue({
    el: '#app',
    components:{
        Flash,
        Paginator,
        UserNotifications,
        AvatarForm,
        Wysiwyg,
        ThreadView,
        Typhaed,
        UnscribeButton,
        Alert
    }
});
