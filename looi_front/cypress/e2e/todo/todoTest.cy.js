describe('Looi ToDo Test', () => {
	const urlTest = 'http://localhost:3001'

	beforeEach(() => {
		cy.visit(urlTest)
	})

	it('Should get into ToDo List, and retrieve the data.', () => {
		cy.viewport(1800, 1080)
		cy.Login()
		cy.getByDataCy('todoBtn').should('be.visible').click()
		cy.wait('@ToDoList').its('response.statusCode').should('eq', 200)
		cy.log('End of Tests Case')
	})

	it('Should get into ToDo List, retrieve the data, select the first element, and edit the Title.', () => {
		cy.viewport(1800, 1080)
		cy.Login()
		cy.getByDataCy('todoBtn').should('be.visible').click()
		cy.wait('@ToDoList').its('response.statusCode').should('eq', 200)
		cy.getByDataCy('edit_action_1').click({ force: true })
		cy.getByDataCy('title')
			.find('input')
			.clear({ force: true })
			.type('THIS IS AN EDITION TEST')

		cy.get('form').submit()
		cy.wait('@ToDoEdit').its('response.statusCode').should('eq', 200)
		cy.log('End of Tests Case')
	})

	it('Should get into ToDo List, select line 2, and delete it.', () => {
		cy.viewport(1800, 1080)
		cy.Login()
		cy.getByDataCy('todoBtn').should('be.visible').click()
		cy.getByDataCy('delete_action_2').click({ force: true })
		cy.get('form').submit()
		cy.wait('@ToDoDelete').its('response.statusCode').should('eq', 200)
		cy.wait('@ToDoList').its('response.statusCode').should('eq', 200)
		cy.log('End of Tests Case')
	})
})
