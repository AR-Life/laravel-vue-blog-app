<template>
    <header class="flex justify-between items-center lg:px-96 h-24 text-xl bg-indigo-400 text-white">
        <router-link class="text-2xl" to='/'>Blog</router-link>
        <nav>
            <ul class="flex justify-between items-center text-sm" v-if="userData?.access_token">
                <li class="px-2">Hoşgeldiniz {{ userData.name }}</li>
                <li class="p-2 bg-white rounded-lg text-indigo-400 hover:cursor-pointer" @click="logout()" >Çıkış Yap!</li>
            </ul>
            <ul class="flex justify-between" v-else>
                <li class="px-2"><router-link to="/register">Kayıt Ol</router-link></li>
                <li class="px-2"><router-link to="/login">Giriş Yap</router-link></li>
            </ul>
        </nav>
    </header>
</template>
<script setup>
import {computed} from 'vue';
import userStore from '../store/user';
const user = userStore();
const userData = computed(() => user.user);
const logout = async () => {
    await user.logout();
    location.href = '/';
}
</script>
