/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('global-home', require('./components/GlobalHome.vue').default);
Vue.component('posts', require('./components/Posts.vue').default);
Vue.component('post', require('./components/postDetails.vue').default);
Vue.component('categories',require('./components/Categories.vue').default);
Vue.component('category_posts', require('./components/category_posts.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('login',require('./components/auth/login.vue').default);
Vue.component('register',require('./components/auth/register.vue').default);
Vue.component('navbar', require('./components/layouts/nav.vue').default);
Vue.component('dashboard', require('./components/dashboard/home.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Vuex from 'vuex';
import Axios from 'axios';
import router from './routes/router';
const store = new Vuex.Store({
    state: {
        userToken: null,
        Admin:null,
    },
    getters:{
        isLogged(state){
            return !!state.userToken;
        },
        isAdmin(state) {
                return state.Admin;
        }

    },
    mutations: {

        setUserToken(state, userToken) {
            state.userToken = userToken;
            localStorage.setItem('userToken', JSON.stringify(userToken));
            axios.defaults.headers.common.Authorization = `Bearer ${userToken}`;
        },
        removeUserToken(state) {
            state.Admin = null;
            state.userToken = null;
            localStorage.removeItem('userToken');
        },
        setAdmin(state) {
             axios.get('api/isAdmin').then(res=>{
                 console.log(res);
                let resoponse = res.data;
            state.Admin = resoponse;

                }).then(err=>{
                   console.log(err);
               });
        }
    },
    actions:{
        registerUser({ commit,getters }, payload) {
            if (!getters.isLogged) {
                axios.post('/api/register', payload).then(res => {
                    commit('setUserToken', res.data.token.accessToken);
                }).catch(err => {
                    console.log(err);
                });
            }
        },
               loginUser({ commit,getters }, payload) {

                   if (!getters.isLogged) {
                axios.post('/api/login', payload).then(res =>{
                console.log(res.data.token.accessToken);
                commit('setUserToken', res.data.token.accessToken);
                    commit('setAdmin');
            }).catch(err => {
                console.log(err);
            });

          }
        },
    }

});
const app = new Vue({
    el: '#app',
    router,
    store:store,
});
