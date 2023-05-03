<template>
    <section :class="props.class" class="flex flex-col border-lime-100 border-solid border-2 rounded-t-lg">
        <header :class="props.header" class="bg-blue-400 px-2 p-2 text-white"><slot name="header"></slot></header>
        <div :class="props.body" class="flex flex-col"><slot></slot></div>
        <div :class="props.footer" class="px-2 pb-2"><slot name="footer"></slot></div>
    </section>
</template>
<script setup>
import { defineProps } from 'vue';
const props = defineProps(['class','header', 'body', 'footer'])
</script>