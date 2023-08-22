import { defineStore } from 'pinia'
// import router from '@/router'
import { useRouter } from 'vue-router'
import { useUserStore } from '@/stores/user.js'
import { useApi } from '@/api/useAPI'
const axios = useApi()

export const useAuthStore = defineStore({
	id: 'auth',
	state: () =>
		JSON.parse(localStorage.getItem('AUTH_STATE')) ?? {
			email: null,
			isLoggedIn: false,
			type: null,
			jwt: null,
		},
	getters: {
		getJwtInfo: state => {
			return { type: state.type, jwt: state.jwt }
		},
		isLogged: state => {
			return state.isLoggedIn
		},
	},
	actions: {
		updateState(payload) {
			let newUserState = { ...this.$state, ...payload }
			localStorage.removeItem('AUTH_STATE')
			localStorage.setItem('AUTH_STATE', JSON.stringify(newUserState))
			this.$reset()
		},
		async login({ email, password }) {
			const user = useUserStore()
			try {
				await axios.post('/auths/login', { email, password }).then(data => {
					let { data: userData } = data
					user.storeInfo(userData)
					this.updateState({
						email,
						isLoggedIn: true,
						type: userData.authorisation.type,
						jwt: userData.authorisation.token,
					})
					// Expected output: "Success!"
				})
			} catch (error) {
				console.log('Error at login: ', error.message)
				throw error
			}
		},

		async register(props) {
			const user = useUserStore()
			try {
				await axios.post('/auths/register', props).then(data => {
					let { data: userData } = data
					user.storeInfo(userData)
					this.updateState({
						email: props.email,
						isLoggedIn: true,
						type: userData.authorisation.type,
						jwt: userData.authorisation.token,
					})
					// Expected output: "Success!"
				})
			} catch (error) {
				console.log('Error at register: ', error.message)
				throw error
			}
		},

		async logout() {
			const user = useUserStore()
			const router = useRouter()
			localStorage.clear()
			this.$reset()
			user.$reset()

			try {
				await axios.post('/auths/logout')
				await router.push({ name: 'login' })
			} catch (error) {
				window.location.pathname = '/login'
			}
		},
	},
})
