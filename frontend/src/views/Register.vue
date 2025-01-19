<template>
  <div class="h-[100vh] w-full p-48 flex flex-col justify-center items-center">
    <div class="h-[10vh]">
      <h2 class="text-2xl text-secondaryGray font-extrabold mb-4">Registro</h2>
    </div>
    <form @submit.prevent="register" class="w-1/6 text-secondaryGray font-bold flex flex-col justify-center">
      <!-- Campos de formulario -->
      <div class="mb-7 flex flex-col justify-center items-start">
        <label for="name" class="text-gray-700">Nombre*</label>
        <input v-model="name" type="text" id="name" class="w-full border rounded px-3 py-2" placeholder="Tu nombre"
          required />
      </div>
      <div class="mb-7 flex flex-col justify-center items-start">
        <label for="apellidos" class="block text-gray-700">Apellidos*</label>
        <input v-model="apellidos" type="text" id="apellidos" class="w-full border rounded px-3 py-2"
          placeholder="Tu apellido" required />
      </div>
      <div class="mb-7 flex flex-col justify-center items-start">
        <label for="numeroTelefono" class="block text-gray-700">Número de teléfono*</label>
        <input v-model="numeroTelefono" type="text" id="numeroTelefono" class="w-full border rounded px-3 py-2"
          placeholder="ej. 912345678" required />
      </div>
      <div class="mb-7 flex flex-col justify-center items-start">
        <label for="email" class="block text-gray-700">Correo Electrónico*</label>
        <input v-model="email" type="email" id="email" class="w-full border rounded px-3 py-2"
          placeholder="Tu correo electrónico" required />
      </div>
      <div class="mb-7 flex flex-col justify-center items-start">
        <label for="password" class="block text-gray-700">Contraseña*</label>
        <input v-model="password" type="password" id="password" class="w-full border rounded px-3 py-2"
          placeholder="Contraseña" required />
      </div>
      <div class="mb-7 flex flex-col justify-center items-start">
        <label for="password_confirmation" class="block text-gray-700">Confirmar Contraseña*</label>
        <input v-model="password_confirmation" type="password" id="password_confirmation"
          class="w-full border rounded px-3 py-2" placeholder="Repite tu contraseña" required />
      </div>
      <button type="submit"
        class="mt-2 text-white bg-secondaryRed px-4 py-2 rounded hover:text-white hover:bg-secondaryGray">
        Registrarme
      </button>
    </form>
    <p v-if="errorMessage" class="text-red-400 font-semibold text-xl mt-4">{{ errorMessage }}</p>
    <p v-if="successMessage" class="text-green-500 mt-4">{{ successMessage }}</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      name: '',
      apellidos: '',
      numeroTelefono: '',
      email: '',
      password: '',
      password_confirmation: '',
      successMessage: '',
      errorMessage: '',
    };
  },
  methods: {
    goToLogin() {
      this.$router.push('/');
    },
    async register() {
      if (this.password !== this.password_confirmation) {
        this.errorMessage = 'Las contraseñas no coinciden.';
        this.password_confirmation = '';
        return;
      }

      try {
        const response = await axios.post('http://127.0.0.1:8000/api/register', {
          name: this.name,
          apellidos: this.apellidos,
          numeroTelefono: this.numeroTelefono,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation,
        });

        if (response.status === 201) {
          this.successMessage = 'Registro exitoso. Por favor, inicia sesión.';
          this.errorMessage = '';
          this.name = '';
          this.apellidos = '';
          this.numeroTelefono = '';
          this.email = '';
          this.password = '';
          this.password_confirmation = '';
          this.goToLogin(); 
        }
      } catch (error) {
        if (error.response && error.response.data && error.response.data.message) {
          this.errorMessage = error.response.data.message;
        } else {
          this.errorMessage = 'Hubo un error al intentar registrarse. Inténtalo de nuevo.';
        }
        this.successMessage = '';
      }
    },
  },
};
</script>
