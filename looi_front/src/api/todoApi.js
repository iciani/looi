export default axios => ({
	List: async () => {
		const response = await axios.get('/todos?per_page=1000&order=id')
		return response.data
	},
	Add: async params => {
		const response = await axios.post('/todos', params)
		return response.data
	},
	Change: async params => {
		const response = await axios.put(`/todos/${params.id}`, params)
		return response.data
	},
	Delete: async params => {
		const response = await axios.delete(`/todos/${params.id}`)
		return response.data
	},
})
