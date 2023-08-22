import { createRouter, createWebHistory } from 'vue-router'
import authMiddleware from './middleware/auth-middleware'

import HomeView from '../views/HomeView.vue'
import TodoList from '../views/todo/TodoList.vue'

import Login from '@/views/auth/Login.vue'
import Register from '@/views/auth/Register.vue'

const router = createRouter({
	history: createWebHistory(import.meta.env.BASE_URL),
	routes: [
		{
			path: '/',
			name: 'home',
			component: HomeView,
		},
		{
			path: '/todo',
			name: 'todo',
			component: TodoList,
		},
		{
			path: '/about',
			name: 'about',
			component: () => import('../views/AboutView.vue'),
		},

		// AUTH ROUTES
		{ name: 'login', path: '/login', component: Login, meta: { layout: 'auth' } },
		{
			name: 'register',
			path: '/register',
			component: Register,
			meta: { layout: 'auth' },
		},
	],
})

router.beforeEach(authMiddleware)

export default router
