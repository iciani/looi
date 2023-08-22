<template>
	<div class="d-flex align-center justify-center" style="height: 100vh">
		<v-sheet width="400" class="mx-auto">
			<v-container>
				<v-img
					width="100%"
					aspect-ratio="16/9"
					cover
					src="https://www.looiconsulting.com/wp-content/uploads/2014/08/LCL-Logo-long-300x53.png"></v-img>
			</v-container>
			<v-form fast-fail @submit.prevent="registerFn" v-model="isFormValid">
				<v-text-field
					v-model="credentials.name"
					label="User Name"
					type="text"
					:rules="[required]"></v-text-field>

				<v-text-field
					v-model="credentials.email"
					label="User Email"
					type="text"
					:rules="[required, email]"></v-text-field>

				<v-text-field
					v-model="credentials.password"
					label="Password"
					type="password"
					autocomplete="off"
					:rules="[required, min]"></v-text-field>

				<RouterLink to="/login">Already registered?</RouterLink>

				<v-btn type="submit" color="primary" block class="mt-2" :loading="loading">
					Register</v-btn
				>
			</v-form>
		</v-sheet>
	</div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { RouterLink, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth.js'
const isFormValid = ref(false)
const loading = ref(false)

const credentials = reactive({
	name: '',
	email: '',
	password: '',
})

const auth = useAuthStore()
const router = useRouter()

//Validations
const required = function (value) {
	if (value) {
		return true
	} else {
		return 'Required Field.'
	}
}
const min = function (value) {
	if (value.length > 5) {
		return true
	} else {
		return 'Required Minimun 6 chars.'
	}
}
const email = function (value) {
	//eslint-disable-next-line
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value)) {
		return true
	} else {
		return 'Invalid Email Format.'
	}
}

const registerFn = async () => {
	if (isFormValid.value) {
		loading.value = true
		await auth.register(credentials)
		await router.push('/')
	}
}
</script>

<style lang="scss" scoped>
.wrapped-form {
	display: flex;
	flex-direction: column;
	gap: 0.5em;
}
</style>
