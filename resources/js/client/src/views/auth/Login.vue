<template>
    <card class="lg:w-1/2 mx-auto" footer="flex justify-end">
        <template #header><h2 class="font-bold">Giriş Yap</h2></template>
        <div class="bg-yellow-100 text-black flex items-center p-2 transition-all" v-show="error">
            <span class="flex justify-center items-center border-2 border-solid border-black text-black rounded-full me-1 w-6 h-6">!</span>Girmiş olduğunuz parolalar eşleşmiyor. Lütfen parolanızı tekrar girin.
        </div>
        <input v-model="user.email" type="email" class="py-2" placeholder="E-Posta">
        <input v-model="user.password" type="password" class="py-2" placeholder="Parola">
        <template #footer>
            <button @click="login" class="bg-indigo-400 text-white rounded-full py-2 px-5">Giriş Yap</button>
        </template>
    </card>
</template>
<script setup>
import Card from '../../components/Card.vue';
import {ref} from 'vue';
import store from '../../store/user';
const user = ref({
    email:null,
    password:null,
})
const error = ref(false);
const userStore = store();
const login = async() => {
    await userStore.login(user.value);
    location.href = '/';
}

</script>
