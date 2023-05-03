<template>
    <Card header="flex justify-between items-center w-full">
        <template #header>
            <h1 class="text-xl font-extrabold">Bloglar</h1>
            <button
                class="bg-indigo-400 p-2 rounded-lg"
                @click="$router.push('/blog/store')"
            >
                Yeni Ekle
            </button>
        </template>
        <div class="flex flex-wrap">
            <Card
                class="w-1/3"
                header="bg-indigo-400"
                footer="flex justify-between"
                v-for="blog in blogs"
                :key="blog.id"
            >
                <template #header>
                    <h2>{{ blog.title }}</h2>
                </template>
                <p>{{ blog.content?.slice(0, 300) }}...</p>
                <router-link class="text-amber-700" :to="'/blog/' + blog.id"
                    >Devamını okuyayım.</router-link
                >
                <template #footer>
                    <small class="text-blue-800">{{
                        getDate(blog.created_at)
                    }}</small>
                    <small class="text-amber-700"
                        ><RouterLink :to="'/blog/user/' + blog.user_id">{{
                            blog.name
                        }}</RouterLink></small
                    >
                </template>
            </Card>
        </div>
        <template #footer>
            <Pagination :count="page.count" v-model="page.select"></Pagination>
        </template>
    </Card>
</template>
<script setup>
import Card from "../../components/Card.vue";
import useBlogStore from "../../store/blog";
import { ref, reactive, watch, onMounted, computed } from "vue";
import { getDate } from "../../utils/date";
import Pagination from "../../components/Pagination.vue";
import { useRoute } from "vue-router";

const route = useRoute();
const user_id = computed(() => route.params?.user_id || false);

const blogStore = useBlogStore();
const blogs = ref([]);
const page = reactive({
    count: 1,
    select: 1,
});

watch(
    () => page.select,
    async () => {
        if (user_id.value) {
            blogs.value = await blogStore.getUserIndex(user_id.value,parseInt(page.select * 12,10))
        } else {
            blogs.value = await blogStore.index(parseInt(page.select * 12, 10));
        }
    }
);
onMounted(async () => {
    if (user_id.value) {
        const count = await blogStore.getUserCount(user_id.value).then((response) => response.data);
        page.count = Math.ceil(count/12);
        blogs.value = await blogStore.getUserIndex(user_id.value,parseInt(page.select * 12,10))
    } else {
        const count = await blogStore.count().then((response) => response.data);
        page.count = Math.ceil(count / 12);
        blogs.value = await blogStore.index(page.count);
    }
});
</script>
