import Swal from 'sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'

export const useNotify = () => {
	const successNotify = msg => {
		Swal.fire({
			position: 'top-end',
			icon: 'success',
			title: msg ? msg : 'Your work has been saved',
			showConfirmButton: false,
			timer: 1500,
		})
	}

	const errorNotify = e => {
		let msg = e.response.data.message
		let mySubString = msg.substring(msg.indexOf('{'), msg.lastIndexOf('}') + 1)

		Swal.fire({
			position: 'top-end',
			icon: 'error',
			title:
				e && typeof e === 'string'
					? e
					: e.response.data.message.replace(mySubString, ''),
			showConfirmButton: false,
			timer: 1500,
		})
	}

	return { successNotify, errorNotify }
}
