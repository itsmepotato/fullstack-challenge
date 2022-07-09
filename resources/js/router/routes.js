import Dashboard from '../views/Dashboard/Dashboard.vue'
import Login from '../views/Auth/LoginView.vue'

export default [
    {
        path: '/',
        redirect: { name: 'dashboard' }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        // meta: { requiresAuth: false }
    },
    {
        path: "/dashboard",
        name: "dashboard",
        component: Dashboard
        // meta: { requiresAuth: true }
      },
];

