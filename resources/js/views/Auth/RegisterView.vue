<template>
    <div class="flex justify-center mx-4 my-7">
		<div class="flex flex-col w-full max-w-lg">
			<div class="flex items-center px-4 border h-14 bg-[#F8F8F8]">
				Registrase
			</div>
			<div class="flex flex-col justify-between w-full px-4 py-5 h-full border">
				<form @submit.prevent="register">

                    <div class="flex flex-col justify-between my-1">
						<label for="name" >
							Nombre
						</label>
						<input type="text" name="name" v-model="registerForm.name" class="w-full h-9 mt-2 p-4 border border-gray-300">
						<div>
							<span class="text-red-500 text-xs italic">
								{{ errors && errors.name ? errors.name[0] : '' }}
							</span>
						</div>
					</div>

					<div class="flex flex-col justify-between my-1">
						<label for="email" >
							Email
						</label>
						<input type="email" name="email" v-model="registerForm.email" class="w-full h-9 mt-2 p-4 border border-gray-300">
						<div>
							<span class="text-red-500 text-xs italic">
								{{ errors && errors.email ? errors.email[0] : '' }}
							</span>
						</div>
					</div>

					<div class="flex flex-col justify-between my-1">
						<label for="password" >
							Contraseña
						</label>
						<input type="password" v-model="registerForm.password" class="w-full h-9 mt-2 p-4 border border-gray-300">
						<div>
							<span class="text-red-500 text-xs italic">
								{{ errors && errors.password ? errors.password[0] : '' }}
							</span>
						</div>
					</div>

                    <div class="flex flex-col justify-between my-1">
						<label for="password_confirmation" >
							Confirmar Contraseña
						</label>
						<input type="password" v-model="registerForm.password_confirmation" class="w-full h-9 mt-2 p-4 border border-gray-300">
						<div>
							<span class="text-red-500 text-xs italic">
								{{ errors && errors.password_confirmation ? errors.password_confirmation[0] : '' }}
							</span>
						</div>
					</div>

					<div class="flex justify-start items-center">
						<button v-if="!isLoading" type="submit" class="bg-blue-400 hover:bg-blue-600 text-white py-2 px-4 rounded-md my-1">
							Registrarse
						</button>

						<button v-else disable class="bg-blue-700 text-white py-2 px-4 rounded-md my-1 cursor-not-allowed">
							<svg role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
							<path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
							</svg>
							Cargando...
						</button>
                        <div class="mx-4">
                            Ya tienes una cuenta?
                            <router-link class=" text-blue-700 hover:underline " :to="{ name: 'login' }">
                                Click para ir al login
                            </router-link>
                        </div>


					</div>
				</form>
			</div>
		</div>
    </div>
</template>

<script>
import Swal from 'sweetalert2';
export default {
name: "register-view",
  	props: {

	},
  	components: {
  	},

	mounted: function() {
	},

	data: function () {
		return {
            isLoading: false,
			errors: null,
            registerForm: {
                name: null,
                email: null,
                password: null,
                password_confirmation: null
            }
		};
	},

	watch: {

	},

	methods: {
        async register() {
            this.isLoading = true
            this.errors = null;

			await this.$store.dispatch('register', this.registerForm)
            .catch(err => {
				this.isLoading = false;
                this.clearPasswordFields();
				this.errors = err.response.data.errors;
			});

			if(this.errors === null) {
                let userName = this.$store.getters.user.name;
                await Swal.fire({
                    icon: 'success',
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    allowOutsideClick: false,
                    title: `Registro correcto, bienvenido/a ${userName}!`,
                    text: "Sesion iniciada",
                })
				this.$router.push({ name: 'dashboard' });
			}

        },
        clearPasswordFields() {
            this.registerForm.password = null;
            this.registerForm.password_confirmation = null;
        }
	},
}
</script>
