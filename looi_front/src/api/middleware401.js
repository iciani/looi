import { useAuthStore } from '@/stores/auth.js'

/**
 * Middleware - if user lost authentication (401) it gets kicked out
 */
const middleware401 = async error => {
	const { status } = error.request
	if (status === 401 || status === 419) {
		const auth = useAuthStore()
		auth.logout()
		return Promise.reject({
			name: 'Permission denied',
			message: 'You lost your credentials - will be redirected to login page.',
		})
	}
	return Promise.reject(error)
}

export { middleware401 as default }
