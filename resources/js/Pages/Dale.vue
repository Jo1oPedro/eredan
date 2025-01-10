<template>
    <div>
        <h1>Counter: {{ counterStore.count }}</h1>
        <button @click="counterStore.increment">+</button>
        <button @click="counterStore.decrement">-</button>
    </div>
    <button @click="x = true">trocou</button>
    <Doly v-if="x"></Doly>
</template>

<script setup>
import { useCounterStore } from '@/stores/counter.js'
import Doly from "@/Pages/Doly.vue";
import {onMounted, ref} from "vue";

const x = ref(false);

const backgroundMusic = new Audio("http://static.eredan.com/sounds/music_menu.mp3");
const dropdownSound = new Audio("http://static.eredan.com/sounds/dock_menu/dockmulti_clic.mp3")

const counterStore = useCounterStore();

onMounted(() => {
   backgroundMusic.loop = true;
   backgroundMusic.volume = 0.0;
   const tryActiveMusic = setInterval(async function() {
      backgroundMusic.play().then(() => {
          clearInterval(tryActiveMusic);
      }).catch((e) => e)
   }, 1000);
});
</script>
