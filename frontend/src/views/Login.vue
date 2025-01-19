<template>
    <div class="w-[100vw] h-[100vh] flex justify-center items-center p-20">
        <div class="w-2/3 p-10">
            <img src="/images/logoulern.png" alt="logo creado para el reto">
        </div>
        <div class="w-3/12 h-[50vh] bg-yellow-300 flex flex-col border rounded-xl shadow-md">
            <div class="w-full flex flex-col justify-center space-y-5">
                <div class="w-full py-3 flex justify-center items-center">
                    <h2 class="text-xl font-extrabold text-secondaryGray">Inicio de sesión</h2>
                </div>
                <form @submit.prevent="login" class="w-full flex flex-col items-center p-5 space-y-5">
                    <div class="w-3/4">
                        <label for="email" class="text-secondaryGray text-lg font-semibold">Correo Electrónico</label>
                        <input v-model="email" type="email" id="email" class="w-full border rounded px-3 py-2"
                            placeholder="Correo electrónico" required />
                    </div>
                    <div class="w-3/4">
                        <label for="password" class="text-secondaryGray text-lg font-semibold">Contraseña</label>
                        <input v-model="password" type="password" id="password" class="w-full border rounded px-3 py-2"
                            placeholder="Contraseña" required />
                    </div>
                    <button type="submit"
                        class="flex flex-row justify-center w-[8vw] h-[5vh] items-center py-3 rounded-md font-medium text-base border-2 border-secondaryGray text-secondaryGray tracking-widest hover:bg-gray-200 active:bg-secondaryGray active:text-white focus:outline-none disabled:opacity-25 transition">
                        Iniciar sesión
                    </button>
                </form>
                <div class="w-full flex flex-col items-center justify-center text-center">
                    <p class="text-gray-700 font-semibold text-lg">¿No tienes una cuenta?</p>
                    <button @click="goToRegister"
                        class="mt-2 text-secondaryGray px-4 py-2 rounded hover:text-white hover:bg-secondaryGray">
                        Registrarse
                    </button>
                </div>
            </div>
            <p v-if="errorMessage" class="text-red-500 mt-4">{{ errorMessage }}</p>
        </div>
    </div>
</template>

<script>
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
    name: 'Login',
    data() {
        return {
            email: '',
            password: '',
            errorMessage: '',
        };
    },
    setup() {
        const router = useRouter();

        const goToRegister = () => {
            router.push('/register');
        };

        return {
            router,
            goToRegister,
        };
    },
    methods: {
        async login() {
            try {
                const response = await axios.post('http://127.0.0.1:8000/api/login', {
                    email: this.email,
                    password: this.password,
                });

                // Guardar el token en localStorage
                localStorage.setItem('authToken', response.data.token);

                this.router.push('/home');
            } catch (error) {
                if (error.response && error.response.status !== 200) {
                    this.errorMessage = 'Credenciales incorrectas. Verificar el correo y contraseña.';
                } else {
                    this.errorMessage = 'Ocurrió un error. Intenta nuevamente más tarde.';
                }
            }
        },
    },
};
</script>
