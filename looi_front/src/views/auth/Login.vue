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
			<v-form fast-fail @submit.prevent="loginFn" v-model="isFormValid">
				<v-text-field
					v-model="credentials.email"
					label="User Name"
					type="text"
					:rules="[required, email]"></v-text-field>

				<v-text-field
					v-model="credentials.password"
					label="password"
					type="password"
					autocomplete="off"
					:rules="[required]"></v-text-field>

				<RouterLink to="/register">Not Registered?</RouterLink>

				<v-btn type="submit" color="primary" block class="mt-2" :loading="loading">
					Sign in</v-btn
				>
			</v-form>
			<div class="mt-1">
				<v-alert
					v-show="credentialError"
					closable
					variant="outlined"
					density="compact"
					text="Error in Credentials..."
					type="error">
				</v-alert>
			</div>
		</v-sheet>
	</div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth.js'

const router = useRouter()
const auth = useAuthStore()

//data
const credentials = reactive({
	email: null,
	password: null,
})
const credentialError = ref(false)
const loading = ref(false)
const isFormValid = ref(false)

//Validations
const required = function (value) {
	if (value) {
		return true
	} else {
		return 'Required Field.'
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

const loginFn = async () => {
	if (isFormValid.value) {
		try {
			loading.value = true
			credentialError.value = false
			await auth.login(credentials)
			await router.push('/')
		} catch (error) {
			console.log(error.message)
			credentialError.value = true
			loading.value = false
		}
	}
}
</script>
