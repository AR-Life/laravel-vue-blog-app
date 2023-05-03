<template>
    <Card footer="flex justify-end mt-2">
        <template #header><h1>Blog Yazısı Ekle</h1></template>
        <input type="text" v-model="blog.title" placeholder="Başlık">
        <textarea v-model="blog.content" class="bg-yellow-200"></textarea>
        <template #footer>
            <button class="p-2 me-2 border-2 rounded-lg border-indigo-400 text-indigo-400" @click="$router.push('/')">Vazgeç</button>
            <button class="p-2 bg-indigo-400 text-white rounded-lg" @click="save">Kaydet</button>
        </template>
    </Card>
    </template>
    <script setup>
    import {ref} from 'vue';
    import Card from '../../components/Card.vue';
    import useBlogStore from '../../store/blog';
    import useUserStore from '../../store/user';
    import { useRouter } from 'vue-router';

    const router = useRouter();
    const userStore = useUserStore();
    const blogStore = useBlogStore();

    const blog = ref({
        title: null,
        content: null,
        user_id: userStore.user.id,
    })
    const save = () => {
            blogStore.store(blog.value).then(() => router.push('/blog'));
    }
    </script>
