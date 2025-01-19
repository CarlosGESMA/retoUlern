import { defineStore } from 'pinia';
import axios from 'axios';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        token: localStorage.getItem('authToken') || null,
        user: null,
        errorMessage: ''
    }),
    actions: {
        async login(email, password) {
            try {
                const response = await axios.post('http://127.0.0.1:8000/api/login', {
                    email,
                    password
                });

                localStorage.setItem('authToken', response.data.token);
                this.token = response.data.token;
                this.user = response.data.user; 

                this.$router.push('/home');
            } catch (error) {
                if (error.response && error.response.status === 401) {
                    this.errorMessage = 'Credenciales incorrectas. Verifica tu correo y contraseña.';
                } else {
                    this.errorMessage = 'Ocurrió un error. Intenta nuevamente más tarde.';
                }
            }
        },
        logout() {
            localStorage.removeItem('authToken');
            this.token = null;
            this.user = null;
            this.$router.push('/login');
        }
    },
});
