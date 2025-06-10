<script setup>
import { RouterLink } from 'vue-router';

</script>

<template>
  <nav>
    <div class="flex flex-row justify-between mx-9 mt-4">
      <div>
        <a href="#dashboard" class="text-black text-lg">
          <span class="text-sky-400 font-bold">SKILL</span>
          <span class="font-bold">BOOK</span>
        </a>
      </div>
      <div class="flex flex-row space-x-5">
        <a href="#about" class="text-black">about</a>
        <a href="#contact" class="text-black">contact</a>
        <div>
          <RouterLink to="login" class="text-white bg-sky-400 rounded-md p-2">login</RouterLink>
        </div>
      </div>
    </div>
  </nav>
</template>
