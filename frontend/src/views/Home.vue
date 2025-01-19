<template>
    <div class="w-[100vw] h-[100vh] p-16">
        <div
            class="bg-secondaryGray h-[20vh] flex justify-end py-6 px-12 rounded-lg shadow-lg relative overflow-hidden mb-4">
            <div class="w-full flex justify-end items-center gap-16">
                <div class="bg-white p-2 w-[12vw] h-[10vh] rounded-lg shadow-md text-center flex flex-col items-center hover:scale-125 transition-transform">
                    <h3 class="text-lg font-semibold mt-2">{{ user.name }} {{user.apellidos}}</h3>
                    <p class="text-red-500 text-sm font-bold">{{ user.email }}</p>
                </div>
                <button @click="logout" class="flex flex-row justify-center w-[10vw] h-[7vh] items-center py-3 rounded-md font-medium text-base border-2 border-gray-300 text-white tracking-widest hover:bg-gray-200 hover:text-secondaryGray active:bg-secondaryGray active:text-white focus:outline-none disabled:opacity-25 transition">
                    Cerrar sesión
                </button>
            </div>
        </div>

        <div class="h-[10vh] flex flex-row text-white text-2xl font-bold rounded-lg space-x-3">
            <div class="w-7/12 flex justify-start items-center bg-red-500 rounded-t-lg px-12">
                <span class="py-3 text-center">Datos personales</span>
            </div>
            <div class="w-5/12 flex justify-start items-center bg-red-400 rounded-t-lg px-12">
                <span class="py-3 text-center">Datos privados</span>
            </div>
        </div>

        <div class="h-[53vh] flex flex-row text-white text-2xl font-normal rounded-lg space-x-3">
            <div class="w-7/12 flex flex-col items-center justify-center pr-10 pl-2 text-gray-700 font-semibold space-x-4 bg-gray-400 rounded-b-lg">
                <div class="w-7/12 space-y-10 py-20 px-10">
                    <div class="flex flex-row w-full space-x-3">
                        <label for="name" class="w-6/12 text-end text-xl">Nombre*</label>
                        <input v-model="user.name" type="text" id="name" class="w-7/12 border rounded text-lg px-5" placeholder="" required disabled />
                    </div>
                    <div class="flex flex-row w-full space-x-3">
                        <label for="apellido" class="w-6/12 text-end text-xl">Apellidos*</label>
                        <input v-model="user.apellidos" type="text" id="apellido" class="w-7/12 border rounded text-lg px-5" placeholder="" required disabled />
                    </div>
                    <div class="flex flex-row w-full space-x-3">
                        <label for="email" class="w-6/12 text-end text-xl">Correo*</label>
                        <input v-model="user.email" type="email" id="email" class="w-7/12 border rounded text-lg px-5" placeholder="" required disabled />
                    </div>
                    <div class="flex flex-row w-full space-x-3">
                        <label for="numeroTelefono" class="w-6/12 text-end text-xl">Número telefónico*</label>
                        <input v-model="user.numeroTelefono" type="text" id="numeroTelefono" class="w-7/12 border rounded text-lg px-5" placeholder="" required disabled />
                    </div>
                </div>
            </div>
            <div class="w-5/12 flex text-gray-700 font-semibold p-10 bg-gray-300 rounded-b-lg">
                <div class="w-full flex flex-col justify-center">
                    <div class="w-full flex justify-end h-1/6">
                        <button @click="togglePasswordVisibility" class="flex flex-row justify-center w-[10vw] h-[7vh] items-center py-3 rounded-md font-medium text-base border-2 border-secondaryGray text-secondaryGray tracking-widest hover:bg-gray-200 active:bg-secondaryGray active:text-white focus:outline-none disabled:opacity-25 transition">
                            {{ passwordVisible ? 'Ocultar contraseña' : 'Ver contraseña' }}
                        </button>
                    </div>
                    <div class="flex flex-row justify-center items-center w-full space-x-3 h-5/6">
                        <label for="password" class="w-4/12 text-end">Contraseña</label>
                        <input v-model="user.password" :type="passwordVisible ? 'text' : 'password'" id="password" class="w-5/12 border rounded text-lg px-5"
                            placeholder="Contraseña" required  />
                            <!-- aqui se pondría disabled -->
                    </div>
                    <h1 class="text-sm">Aquí quería integrar la forma de ver o no la contraseña, pero por temas de tiempo y seguridad no quise implementar una mala práctica. De igual manera el "toggle" para ver o no funciona</h1>
                </div>
            </div>
        </div>

        <div v-if="message" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ message }}
        </div>
    </div>
</template>

<script>
import { ref } from 'vue'; 
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
    name: 'Home',
    data() {
        return {
            user: {},
            message: '',
        };
    },
    setup() {
        const passwordVisible = ref(false); 
        const router = useRouter();

        const logout = () => {
            localStorage.removeItem('authToken');
            router.push('/');
        };

        const togglePasswordVisibility = () => {
            passwordVisible.value = !passwordVisible.value;
        };

        return {
            router,
            logout,
            togglePasswordVisibility,
            passwordVisible, 
        };
    },
    mounted() {
        this.fetchUserData();
    },
    methods: {
        async fetchUserData() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/user', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('authToken')}`,
                    },
                });
                this.user = response.data;

            } catch (error) {
                console.error(error);
                this.message = 'No se pudo cargar los datos del usuario. Por favor, inicia sesión nuevamente.';
            }
        },
    },
};
</script>
