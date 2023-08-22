// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
// Cypress.Commands.add('login', (email, password) => { ... })
//
//
// -- This is a child command --
// Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add('dismiss', { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite('visit', (originalFn, url, options) => { ... })

const user = 'admin@looi.com'
const password = 'looi'
const urlTest = 'http://localhost:3001'

Cypress.Commands.add('getByDataCy', (selector, ...args) => {
	return cy.get(`[data-cy = ${selector}]`, ...args)
})

Cypress.Commands.add('apiInterceptors', () => {
	// Login
	cy.intercept('POST', '**/auths/login*', {
		fixture: 'login.json',
	}).as('Login')

	cy.intercept('GET', '**/todos*', {
		fixture: '/todos/todo_list.json',
	}).as('ToDoList')

	cy.intercept('PUT', '**/todos/1*', {
		fixture: '/todos/todo_edit.json',
	}).as('ToDoEdit')

	cy.intercept('DELETE', '**/todos/2*', {
		fixture: '/todos/todo_delete.json',
	}).as('ToDoDelete')
})

Cypress.Commands.add('Login', () => {
	cy.visit(urlTest)
	cy.apiInterceptors()
	cy.get('input').eq(0).clear().type(user)
	cy.get('input').eq(1).clear().type(password)
	cy.get('form').submit()
	cy.wait('@Login').its('response.statusCode').should('eq', 200)
})
