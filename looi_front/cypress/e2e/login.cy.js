describe('Login Test Cypress', () => {
	const user = 'admin@looi.com'
	const password = 'looi'
	const urlTest = 'http://localhost:3001'

	beforeEach(() => {
		cy.visit(urlTest)
	})

	it('Should get into the app dashboard', () => {
		cy.viewport(1800, 1080)
		cy.apiInterceptors()
		cy.get('input').eq(0).clear().type(user)
		cy.get('input').eq(1).clear().type(password)
		cy.get('form').submit()

		cy.wait('@Login').its('response.statusCode').should('eq', 200)
		cy.location('pathname', { timeout: 1000 }).should('include', '/')
		cy.log('End of Tests Case')
	})
})
