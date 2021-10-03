import Vue from 'vue';
import VueRouter from 'vue-router';


Vue.use(VueRouter);
import Posts from '../components/Posts.vue';
import PostDetails from '../components/postDetails.vue';
import CategoryPosts from '../components/category_posts.vue';
import dashboard from '../components/dashboard/home.vue';

const router = new VueRouter({
   routes : [
    { path: '/', component: Posts, name: 'Posts' },

    { path: '/post/:slug', component: PostDetails, name: 'PostDetails' },
    { path: '/category/posts/:category', component: CategoryPosts, name: 'CategoryPosts' },
    { path: '/dashbaord/', component: dashboard, name: 'dashboard' },

    ]
});

export default router;
