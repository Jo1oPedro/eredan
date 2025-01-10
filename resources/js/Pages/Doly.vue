<template>
    <div>
        <h1>Counter: {{ counterStore.count }}</h1>
        <button @click="counterStore.increment">+</button>
        <button @click="counterStore.decrement">-</button>
    </div>
</template>

<script setup>
import { useCounterStore } from '@/stores/counter.js'

const counterStore = useCounterStore()
</script>
