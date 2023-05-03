<template>
    <card class="lg:w-1/2 mx-auto" footer="flex justify-end">
        <template #header><h2 class="font-bold">Kayıt Ol</h2></template>
        <div class="bg-yellow-100 text-black flex items-center p-2 transition-all" v-show="error">
            <span class="flex justify-center items-center border-2 border-solid border-black text-black rounded-full me-1 w-6 h-6">!</span>Girmiş olduğunuz parolalar eşleşmiyor. Lütfen parolanızı tekrar girin.
        </div>
        <input v-model="user.name" type="text" class="py-2" placeholder="İsim Soyisim">
        <input v-model="user.email" type="email" class="py-2" placeholder="E-Posta">
        <input v-model="user.password" type="password" class="py-2" placeholder="Parola">
        <input type="password" v-model="password_confirmation" class="py-2" placeholder="Parola Tekrar">
        <template #footer>
            <button @click="register" class="bg-indigo-400 text-white rounded-full py-2 px-5">Kayıt Ol</button>
        </template>
    </card>
</template>
<script setup>
import Card from '../../components/Card.vue';
import {ref} from 'vue';
import store from '../../store/user';

const userStore = store();
const user = ref({
    name: null,
    email:null,
    password:null,
})
const password_confirmation = ref(null);
const error = ref(false);
const register = async () => {
    if(user.value.password == password_confirmation.value){
        error.value = false;
        await userStore.register(user.value);
        location.href = '/';
    } else {
        error.value = true;
        user.value.password = null;
        password_confirmation.value = null;
        setTimeout(() => {error.value = false}, 5000)
    }
}

</script>
