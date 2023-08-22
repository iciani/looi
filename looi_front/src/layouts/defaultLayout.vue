<template>
	<v-app>
		<v-app-bar app color="primary" dark>
			<v-toolbar-title>Looi App</v-toolbar-title>
			<RouterLink to="/">
				<v-btn class="nav-bar-btn">Home</v-btn>
			</RouterLink>
			<RouterLink to="/todo">
				<v-btn class="nav-bar-btn" data-cy="todoBtn">To-Do</v-btn>
			</RouterLink>
			<RouterLink to="/about">
				<v-btn class="nav-bar-btn">About</v-btn>
			</RouterLink>
			<v-btn class="">
				<button class="logout-btn" @click="logoutFn">Logout</button>
			</v-btn>
		</v-app-bar>

		<v-main class="mt-10">
			<v-container fluid class="pa-4">
				<v-row no-gutters justify="center">
					<v-col cols="12" lg="6" md="6" sm="6">
						<router-view />
					</v-col>
				</v-row>
			</v-container>
		</v-main>

		<v-footer color="primary" app>
			<span>&copy; 2023 Ignacio Ciani</span>
		</v-footer>
	</v-app>
</template>

<script setup>
import { RouterLink } from 'vue-router'
import { useAuthStore } from '@/stores/auth.js'

const auth = useAuthStore()
const logoutFn = async () => {
	await auth.logout()
}
</script>

<style>
.logout-btn {
	text-transform: uppercase;
}
</style>
