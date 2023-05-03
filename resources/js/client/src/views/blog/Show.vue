<template>
    <Card footer="flex justify-between">
        <template #header>
            <h1>{{ blog.title }}</h1>
        </template>
        <p>{{ blog.content }}</p>
        <template #footer>
            <div>
                <small class="text-blue-800 pe-2">{{ getDate(blog.created_at) }}</small>
                <small class="text-amber-700 px-2">
                    <RouterLink :to="'/blog/user/' + blog.user_id">{{ blog.user?.name }}</RouterLink>
                </small>
            </div>
            <div v-if="blog.user?.id === user?.id">
                <router-link class="px-2 text-blue-600" :to="'/blog/edit/'+blog?.id">Düzenle</router-link>
                <span class="px-2 text-red-600" @click="deleteBlog(blog.id)">Sil</span>
            </div>
        </template>
    </Card>
    <Comments :blog_id="blog_id"></Comments>
    <Modal v-if="destroy">
        <template #title>Silmek İstediğinize Emin misiniz?</template>
        <template #footer>
            <div class="flex justify-end mt-2">
                <button class="bg-green-600 text-white p-2 mx-2" @click="destroy = null">Vazgeç</button>
                <button class="bg-red-600 text-white p-2 mx-2" @click="deleteBlog(destroy)">Sil</button>
            </div>
        </template>
    </Modal>
</template>
<script setup>
import Card from '../../components/Card.vue';
import Modal from '../../components/Modal.vue';
import { useRoute, useRouter } from 'vue-router';
import { ref, onMounted } from 'vue';
import useBlogStore from '../../store/blog';
import useUserStore from '../../store/user';
import {getDate} from '../../utils/date';
import Comments from '../comments/Index.vue'


const blogStore = useBlogStore();
const userStore = useUserStore();

const user = userStore.user;
const route = useRoute();
const router = useRouter()
const blog_id = parseInt(route.params.id,10)

const blog = ref({
    title: null,
    content: null,
    user: null,
    created_at: null
});

const destroy = ref(null);
const deleteBlog = async (id) => {
    if(destroy.value == null ){
        destroy.value = id;
    }else{
        await blogStore.destroy(id).then(() => router.push('/'));
    }
}

onMounted(async () => {
    const { id } = route.params;
    blog.value = await blogStore.show(parseInt(id, 10));

})
</script>
