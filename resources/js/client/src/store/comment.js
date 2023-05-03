import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from 'axios';
axios.defaults.baseURL = import.meta.env.VITE_APP_URL;

export default defineStore('comment', () => {
    const state = ref({
        comment: [],
        length: null,
    });
    // Getters

    // Actions
    const index = async (blog_id, rows) => {
        return await axios.get('/comment/'+blog_id+'/rows/'+rows).then((response) => response.data);
    }
    const store = async (data) => {
        return await axios.post('http://localhost:8000/api/comment/store', data)
        .then((response) => response.data)
            .catch((e) => console.log(e));
    }
    const edit = async (id) => {
        return await axios.get('/comment/edit/'+id).then((response) => response.data);
    }

    const update = async (data) => {
        return await axios.post('/comment/update/'+data.id, data).then((response) => response.data);
    }
    const destroy = async (id) => {
        return await axios.get('/comment/destroy/'+id).then((r) => r.data);
    }
    const count = async (blog_id) => {
        return await axios.get('/comment/count/'+blog_id);
    }
    return {
        index,
        store,
        edit,
        update,
        destroy,
        count
    };
});
