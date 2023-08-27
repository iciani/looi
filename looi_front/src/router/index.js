import { createRouter, createWebHistory } from 'vue-router'
import authMiddleware from './middleware/auth-middleware'

const router = createRouter({
	history: createWebHistory(import.meta.env.BASE_URL),
	routes: [
		{
			path: '/',
			name: 'home',
			component: () => import('../views/HomeView.vue'),
		},
		{
			path: '/todo',
			name: 'todo',
			component: () => import('../views/todo/TodoList.vue'),
		},
		{
			path: '/about',
			name: 'about',
			component: () => import('../views/AboutView.vue'),
		},
		{
			path: '/:pathMatch(.*)*',
			name: 'NotFound',
			component: () => import('../views/NotFoundView.vue'),
		},
		// AUTH ROUTES
		{
			name: 'login',
			path: '/login',
			component: () => import('../views/auth/Login.vue'),
			meta: { layout: 'auth' },
		},
		{
			name: 'register',
			path: '/register',
			component: () => import('../views/auth/Register.vue'),
			meta: { layout: 'auth' },
		},
	],
})

router.beforeEach(authMiddleware)

export default router
