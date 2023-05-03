<template>
    <Teleport to="body">
        <div class="fixed top-0 left-0 z-10 w-full h-full bg-black bg-opacity-60 flex justify-center items-center">
            <Card class="bg-white">
                <template #header v-if="props.title">{{ props.title }}</template>
                <slot></slot>
                <template #footer><slot name="footer"></slot></template>
            </Card>
        </div>
    </Teleport>
</template>
<script setup>
import Card from './Card.vue';
import { defineProps } from 'vue';
const props = defineProps(['title']);
</script>
