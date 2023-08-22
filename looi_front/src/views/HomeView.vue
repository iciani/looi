<template>
	<v-card class="mt-10">
		<v-sheet class="pa-2 ma-2">
			<h1>Dashboard: Welcome</h1>
			<p>Username: {{ user.$state.name }}</p>
			<p>Email: {{ user.$state.email }}</p>
		</v-sheet>
	</v-card>
</template>

<script setup>
import { useUserStore } from '@/stores/user.js'
const user = useUserStore()
</script>
