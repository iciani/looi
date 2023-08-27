<template>
	<v-card class="mt-10" variant="tonal">
		<v-data-table
			:headers="headers"
			:items="todos"
			:total-items="todos.length"
			rows-per-page-items="10"
			:loading="loading"
			item-key="id">
			<template v-slot:top>
				<v-toolbar flat>
					<v-toolbar-title>My To-Do List</v-toolbar-title>
					<v-spacer></v-spacer>
				</v-toolbar>
			</template>
			<template v-slot:[`item.thumbnail`]="{ item }">
				<a
					:href="item.raw.thumbnail"
					target="_blank"
					v-show="item.raw.thumbnail != ''">
					<v-icon
						:color="item.raw.thumbnail ? 'info' : 'gray'"
						icon="mdi-image-area"
						size="small"></v-icon>
				</a>
			</template>
			<!-- chip on state { item }-->
			<template v-slot:[`item.state`]="{ item }">
				<p>
					<v-chip
						:color="item.raw.state === globals.STATS.Completed ? 'success' : 'gray'"
						class="align-center my-auto">
						{{ item.raw.state }}
					</v-chip>
				</p>
			</template>
			<template v-slot:[`item.actions`]="{ item }">
				<v-icon
					:data-cy="'show_action_' + item.raw.id"
					size="small"
					class="me-2"
					@click="showItem(item.raw)">
					mdi-eye
				</v-icon>
				<v-icon
					:data-cy="'edit_action_' + item.raw.id"
					size="small"
					class="me-2"
					@click="editItem(item.raw)">
					mdi-pencil
				</v-icon>
				<v-icon
					:data-cy="'delete_action_' + item.raw.id"
					size="small"
					class="me-2"
					@click="deleteItem(item.raw)">
					mdi-delete
				</v-icon>
			</template>
		</v-data-table>

		<v-card-actions>
			<div class="ml-0">
				<v-btn
					color="primary"
					min-width="120"
					variant="outlined"
					@click.stop="addItem()">
					<v-icon class="mr-1"> mdi-plus-circle-outline </v-icon>
					Add To-Do
				</v-btn>
			</div>
		</v-card-actions>
	</v-card>
	<v-dialog
		:key="componentKey + 1"
		:CloseOnEscape="false"
		persistent
		v-model="showDialog"
		:width="display.smAndDown ? '100%' : '60%'"
		:fullscreen="display.smAndDown">
		<ToDoForm
			:key="componentKey"
			:p-active-row="activeRow"
			:p-operator="operator"
			@onSave="SaveData"
			@closeComponent="showDialog = false" />
	</v-dialog>
</template>

<script setup>
import { ref, onMounted, nextTick, inject } from 'vue'
import { useDisplay } from 'vuetify'
import { VDataTable } from 'vuetify/labs/VDataTable'
import ToDoForm from './ToDoForm.vue'
import todoApi from '@/api/todoApi'
const axios = inject('axios')
const globals = inject('globals')

//We import an API file per Entity with its related endpoints.
const todo = todoApi(axios)

//Data
const display = ref(useDisplay())
const todos = ref([])
const loading = ref(true)
const showDialog = ref(false)
const activeRow = ref([])
const operator = ref('')
const componentKey = ref(0)

const headers = [
	{ title: 'Id', align: 'end', key: 'id', type: 'int' },
	{ title: 'Title', align: 'end', sortable: false, key: 'title' },
	{ title: 'State', align: 'end', sortable: false, key: 'state' },
	{ title: 'Image', align: 'end', sortable: false, key: 'thumbnail' },
	{
		title: 'Comm. Due Date',
		align: 'end',
		sortable: false,
		key: 'committed_due_date',
		type: 'date',
	},
	{
		title: 'Priority',
		align: 'end',
		sortable: true,
		key: 'priority',
	},
	{
		title: 'Created At',
		align: 'end',
		sortable: false,
		key: 'created_at',
		type: 'date',
	},
	{
		title: 'Updated At',
		align: 'end',
		sortable: false,
		key: 'updated_at',
		type: 'date',
	},
	{
		title: 'Actions',
		key: 'actions',
		align: 'center',
		width: '150',
		sortable: false,
	},
]

//Events
onMounted(() => {
	getListData()
})

//Functions
const forceRerender = async () => {
	componentKey.value += 1
	showDialog.value = false
	await nextTick()
	showDialog.value = true
}

const getListData = async () => {
	try {
		loading.value = true
		const response = await todo.List()
		todos.value = response.data
	} catch (error) {
		loading.value = false
		return []
	} finally {
		loading.value = false
	}
}

//ADD ITEM
const addItem = () => {
	operator.value = 'Add'
	showDialog.value = true
	forceRerender()
}

//EDIT ITEM
const editItem = data => {
	forceRerender()
	operator.value = globals.EDIT
	showDialog.value = true
	activeRow.value = data
}

//SHOW ITEM
const showItem = data => {
	forceRerender()
	operator.value = globals.SHOW
	showDialog.value = true
	activeRow.value = data
}

//DELETE ITEM
const deleteItem = data => {
	forceRerender()
	operator.value = globals.DELETE
	showDialog.value = true
	activeRow.value = data
}

const SaveData = () => {
	showDialog.value = false
	getListData()
}
</script>

<style>
.state-chip {
	/* width: 170px !important; */
	white-space: normal;
}
</style>
