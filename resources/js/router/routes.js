import Dashboard from '../views/Dashboard/Dashboard.vue'
import Login from '../views/Auth/LoginView.vue'
import Register from '../views/Auth/RegisterView.vue'
import NotFound from '../views/NotFound.vue'

export default [
    {
        path: '/',
        redirect: { name: 'dashboard' }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: { requiresAuth: false }
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: { requiresAuth: false }
    },
    {
        path: "/dashboard",
        name: "dashboard",
        component: Dashboard,
        meta: { requiresAuth: true }
    },
    // catch all 404
    {
        path: '/:catchAll(.*)',
        name: 'NotFound',
        component: NotFound,
        meta: { requiresAuth: false }
    }
];

