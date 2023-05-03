import {defineStore} from 'pinia';
import {ref, computed} from 'vue';
import axios from 'axios';
axios.defaults.baseURL = import.meta.env.VITE_APP_URL;

export default defineStore('user', () => {
    let access_token = '';
    if (localStorage.getItem('user')) {
      const userData = JSON.parse(localStorage.getItem('user'));
      access_token = userData.user.access_token;
      axios.defaults.headers.common['Authorization'] = `Bearer ${access_token}`;
    }

    const state = localStorage.getItem('user')
      ? ref(JSON.parse(localStorage.getItem('user')))
      : ref({
          user: {},
        });
    // Getters
    const user = computed(() => state.value.user);

    // Actions
    const register = async (data)=> {
        return await axios.post('http://localhost:8000/api/register', data).then((response) => {
            state.value.user = response.data;
            localStorage.setItem('user', JSON.stringify(state.value.user));
            access_token = state.value.user.access_token;
            axios.defaults.headers.common['Authorization'] = `Bearer ${access_token}`;
            return { success: true };
        })
        .catch((e) => console.log(e));
    }
    const login = async (data) => {
      return await axios
        .post('/login', data)
        .then((response) => {
          state.value.user = response.data;
          localStorage.setItem('user', JSON.stringify(state.value.user));
          access_token = state.value.user.access_token;
          axios.defaults.headers.common['Authorization'] = `Bearer ${access_token}`;
          return { success: true };
        })
        .catch((e) => {
          return { success: false, message: e.message };
        });
    };

    const logout = async () => {

      await axios.post('/logout');
      state.user = {};
      localStorage.removeItem('user');
    };

    return {
      user,
      register,
      login,
      logout
    };
  });
