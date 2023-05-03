<template>
<div class="flex justify-center items-center mx-auto my-2">
    <button class="hover:cursor-pointer me-1 rounded-lg bg-indigo-400 text-white p-2 text-2xl" @click="decrement">&laquo;</button>
    <select v-model="model" class="mx-1 text-2xl">
        <option v-for="item in props.count" :value="item" >{{ item }}</option>
    </select>
    <span class="text-2xl mx-1">/</span>
    <span class="hover:cursor-pointer mx-1 rounded-lg bg-indigo-400 text-white p-2 text-2xl" @click="emit('update:modelValue', props.count)">{{ props.count }}</span>
    <button class="hover:cursor-pointer ms-1 rounded-lg bg-indigo-400 text-white p-2 text-2xl" @click="increment">&raquo;</button>
</div>
</template>
<script setup>
import { defineProps, defineEmits, computed} from 'vue';
const props = defineProps({
    modelValue:{
    },
    value:{},
    count:{ }
  })
const emit = defineEmits(['update:modelValue'])
const model = computed({
    get () {
      return props.modelValue
    },
    set (value) {
      return emit('update:modelValue', value)
    }
  })
  const decrement = () => {
    if(model.value >1){
        emit('update:modelValue', model.value - 1)
    }
  }
  const increment = () => {
    if(props.count > model.value ){
        emit('update:modelValue', model.value + 1)
    }
  }
</script>
