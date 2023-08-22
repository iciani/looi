import { defineStore } from 'pinia'

export const useUserStore = defineStore({
	id: 'user',

	state: () =>
		JSON.parse(localStorage.getItem('USER_INFO')) ?? {
			id: null,
			name: 'guest',
			email: null,
		},

	actions: {
		updateState(payload) {
			let newUserState = { ...this.state, ...payload }
			localStorage.removeItem('USER_INFO')
			localStorage.setItem('USER_INFO', JSON.stringify(newUserState))
			this.$reset()
		},

		async storeInfo(userInfo) {
			localStorage.setItem('USER_INFO', JSON.stringify(userInfo.user))
			this.$reset()
		},
	},
})
