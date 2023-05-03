import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from 'axios';
axios.defaults.baseURL = import.meta.env.VITE_APP_URL;

export default defineStore('blog', () => {
    const state = ref({
        blog: [],
        length: null,
    });
    // Getters
    const user = computed(() => state.value.user);

    // Actions
    const index = async (rows) => {
        return await axios.get('/blog/rows/'+rows).then((response) => response.data);
    }
    const getUserIndex = async (user_id, rows) => {
        return await axios.get('/blog/'+user_id+'/rows/'+rows).then((response) => response.data);
    }
    const store = async (data) => {
        return await axios.post('http://localhost:8000/api/blog/store', data)
            .catch((e) => console.log(e));
    }
    const show = async (id) => {
        return await axios.get('/blog/'+id).then((response) => response.data);
    }
    const edit = async (id) => {
        return await axios.get('/blog/edit/'+id).then((response) => response.data);
    }

    const update = async (data) => {
        return await axios.post('/blog/update/'+data.id, data).then((response) => response.data);
    }
    const destroy = async (id) => {
        return await axios.get('/blog/destroy/'+id).then((response) => response.data);
    }
    const count = async () => {
        return await axios.get('/blog/count');
    }
    const getUserCount = async (user_id) => {
        return await axios.get('/blog/count/'+user_id);
    }
    return {
        index,
        getUserIndex,
        store,
        show,
        edit,
        update,
        destroy,
        count,
        getUserCount
    };
});
