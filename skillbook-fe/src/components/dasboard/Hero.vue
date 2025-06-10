<script setup>
import heroimg from "@/assets/img/Group.png";
import { RouterLink } from "vue-router";
</script>

<template>
  <section class="flex m-auto my-30 justify-center-safe space-x-40">
    <div class="flex flex-col space-y-15">
      <div class="font-bold text-7xl">
        <h1 class="text-sky-400">Level Up</h1>
        <h1>Your</h1>
        <h1>Learning !</h1>
      </div>
      <div>
        <RouterLink to="register">
          <button class="bg-sky-400 p-3 text-white text-center rounded-md font-bold text-1xl">
            Start Now
          </button>
        </RouterLink>
      </div>
    </div>
    <div class="overflow-hidden translate-x-15">
      <img :src="heroimg" alt="Book" class="scale-100" />
    </div>
  </section>
</template>
