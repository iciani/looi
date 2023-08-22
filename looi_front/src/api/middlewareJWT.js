import { useAuthStore } from '@/stores/auth.js'

/**
 * @param {AxiosRequestConfig} axiosconfig
 * @returns {Promise<AxiosRequestConfig>}
 */
const middlewareJWT = async axiosconfig => {
	if (axiosconfig.url != '/auths/login') {
		const auth = useAuthStore()
		if (auth.isLogged)
			return {
				...axiosconfig,
				headers: { Authorization: `Bearer ${auth.getJwtInfo.jwt}` },
			}
		else return { ...axiosconfig }
	} else {
		return { ...axiosconfig }
	}
}

export { middlewareJWT as default }
