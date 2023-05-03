<template>
    <Card footer="flex justify-end mt-2">
        <template #header><h1>Blog Yazısı Düzenleme</h1></template>
        <input type="text" v-model="blog.title" placeholder="Başlık" />
        <textarea v-model="blog.content" class="bg-yellow-200"></textarea>
        <template #footer>
            <button
                class="p-2 me-2 border-2 rounded-lg border-indigo-400 text-indigo-400"
                @click="$router.push('/blog/'+blog.id)"
            >
                Vazgeç
            </button>
            <button
                class="p-2 bg-indigo-400 text-white rounded-lg"
                @click="save"
            >
                Kaydet
            </button>
        </template>
    </Card>
</template>
<script setup>
import { ref, onMounted } from "vue";
import Card from "../../components/Card.vue";
import useBlogStore from "../../store/blog";
import useUserStore from "../../store/user";
import { useRouter, useRoute } from "vue-router";

const route = useRoute();
const router = useRouter();
const userStore = useUserStore();
const blogStore = useBlogStore();

const blog = ref({
    title: null,
    content: null,
    user_id: userStore.user.id,
});
const save = () => {
    blogStore.update(blog.value).then(() => router.push("/blog"));
};
onMounted(async () => {
    const { id } = route.params;
    blog.value = await blogStore.edit(parseInt(id, 10));
    // blog.value.content['ops'][0]['insert'] = blog.value.content;
    console.log(blog.value);
});
</script>
