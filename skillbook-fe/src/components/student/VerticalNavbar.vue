<script setup>
import Person from "@/assets/img/person.png";
import { RouterLink } from "vue-router";
import { useRouter } from "vue-router";

import { computed } from "vue";

import { useUserStore } from "../../../stores/userStore";
import { logout } from "@/auth";
const userStore = useUserStore();

const router = useRouter()

const logoutButton = async () => {
  try {
    const response = await logout()
    console.log(response)

    router.push('login')
  } catch (error) {
    console.log(error)
  }

}

const isTeacher = computed(() => userStore.user.role === 'teacher')

</script>

<template>
  <nav
    class="flex flex-col fixed top-0 left-0 z-40 min-h-screen transition-transform -translate-x-full sm:translate-x-0 w-60 bg-sky-400">
    <div class="mt-10">
      <h1 class="text-white font-bold text-3xl text-center">
        SKILL<span class="text-sky-600">BOOK</span>
      </h1>
    </div>

    <!-- TODO: Add V-IF teacher -->
    <div class="flex flex-col space-y-10 m-auto text-white font-bold text-lg" v-if="!isTeacher">
      <RouterLink to="/student">Dashboard</RouterLink>
      <RouterLink to="/student/discover">Discover</RouterLink>
      <RouterLink to="/student/courses">My Course</RouterLink>
    </div>

    <div class="flex flex-col space-y-10 m-auto text-white font-bold text-lg" v-else>
      <RouterLink to="/teacher">Dashboard</RouterLink>
      <RouterLink to="/teacher/courses">Discover</RouterLink>
      <RouterLink to="/teacher/manage/user">Manage Users</RouterLink>

    </div>

    <!-- TODO: Change username from data -->
    <a href="/profile"
      class="flex flex-row rounded-2xl bg-white px-5 py-2 text-black mt-auto text-center justify-center-safe mx-auto mb-10 space-x-3">
      <img :src="Person" alt="" class="size-fit" />
      <p class="text-sm">{{ userStore.user.name }}</p>
    </a>

    <button @click="logoutButton" class="p-5 text-white font-bold">
      Logout
    </button>
  </nav>
</template>
