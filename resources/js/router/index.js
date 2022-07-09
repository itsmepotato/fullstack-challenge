import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';
import store from "../store/store";

Vue.use(VueRouter);

const router = new VueRouter({
    routes: routes,
    mode: 'history'
});

router.beforeEach((to, from, next) => {
    // if the route requires auth and user is not logged in
    if( to.meta.requiresAuth && !store.getters.isAuthenticated ) {
      next('/login');
    } else {
      next();
    }
})

export default router;
