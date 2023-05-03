<template>
    <Card>
        <template #header><h2>Yorumlar</h2></template>
        <div
            class="flex flex-col border-b-2 border-gray-500"
            v-for="item in comments"
            :key="item.id"
        >
            <div class="flex justify-between">
                <p>{{ item.comment }}</p>
                <div v-if="item.user_id === user.id">
                    <span class="text-blue-600 px-2" @click="edit(item)"
                        >Düzenle</span
                    >
                    <span
                        class="ps-2 text-red-600"
                        @click="deleteComment(item.id)"
                        :disabled="destroy"
                        >Sil</span
                    >
                </div>
            </div>
            <div class="flex justify-between">
                <span>{{ item.name }}</span>
                <span>{{ item.created_at }}</span>
            </div>
        </div>
        <template #footer>
            <Pagination :count="page.count" v-model="page.select"></Pagination>
        </template>
    </Card>
    <div v-if="user.id">
        <textarea
            v-model="comment.comment"
            class="w-full bg-blue-200 text-black placeholder:text-black"
            :placeholder="user.name + ' yorum bırakmak ister misin?'"
        ></textarea>
        <div class="flex justify-end">
            <button
                class="px-2 rounded-lg bg-indigo-400 text-white"
                @click="store()">
                Yorum yap
            </button>
        </div>
    </div>
    <Modal v-if="destroy" title="Silmek İstediğinize Emin misiniz?">
        <template #footer>
            <div class="flex justify-end mt-2">
                <button
                    class="bg-green-600 text-white p-2 mx-2"
                    @click="destroy = null"
                >
                    Vazgeç
                </button>
                <button
                    class="bg-red-600 text-white p-2 mx-2"
                    @click="deleteComment(destroy)"
                >
                    Sil
                </button>
            </div>
        </template>
    </Modal>
    <Modal v-if="editData" title="Yorum Düzenleme">
        <div v-if="user.id">
            <textarea
                v-model="editData.comment"
                class="w-full bg-blue-200 text-black placeholder:text-black"
                :placeholder="user.name + ' yorum bırakmak ister misin?'"
            ></textarea>
            <div class="flex justify-end">
                <button
                    class="px-2 rounded-lg bg-indigo-400 text-white"
                    @click="update()"
                >
                    Yorumu kaydet
                </button>
            </div>
        </div>
    </Modal>
</template>
<script setup>
import Card from "../../components/Card.vue";
import { defineProps, ref, reactive, watch, onMounted, computed } from "vue";
import useUserStore from "../../store/user";
import useCommentStore from "../../store/comment";
import Modal from "../../components/Modal.vue";
import Pagination from "../../components/Pagination.vue";


const userStore = useUserStore();
const commentStore = useCommentStore();
const user = computed(() => userStore.user);

const props = defineProps(["blog_id"]);
const comment = ref({
    blog_id: props.blog_id,
    user_id: user.value.id,
    comment: null,
});
const comments = ref([]);
const store = async () => {
    if (comment.value.comment != null) {
        await commentStore
            .store(comment.value)
            .then((data) => comments.value.push({ ...data, user }))
            .then(() => (comment.value.comment = null));
    }
};
const editData = ref(null);
const edit = (item) => {
    editData.value = item;
};
const update = async () => {
    await commentStore.update(editData.value);
    editData.value = null;
};

const destroy = ref(null);
const deleteComment = async (id) => {
    if (destroy.value == null) {
        destroy.value = id;
    } else {
        await commentStore
            .destroy(id)
            .then(
                () =>
                    (comments.value = comments.value.filter(
                        (x) => x.id != destroy.value
                    ))
            )
            .then(() => (destroy.value = null));
    }
};
const page = reactive({
    count: 1,
    select: 1,

})
watch(() =>page.select, async() => {
    comments.value = await commentStore.index(parseInt(props.blog_id), parseInt(page.select*10, 10))
})
onMounted(async () => {
    if (props.blog_id) {
        comments.value = await commentStore.index(parseInt(props.blog_id));
        const count = await commentStore.count(parseInt(props.blog_id)).then((response) => response.data);
        page.count = Math.ceil((count/10));
    }
});
</script>
