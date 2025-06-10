<script setup>
import { RouterLink } from "vue-router";

import Star from "@/assets/img/Star.png";
import Quil from "@/assets/img/Quil.png";
import Book from "@/assets/img/Book.png";

import DashboardTemplate from "@/components/student/DashboardTemplate.vue";
import CourseCard from "@/components/student/CourseCard.vue";

import { useUserStore } from "../../../stores/userStore";
import { onMounted } from "vue";
import { ref } from "vue";

import axiosInstance from "@/axios";

const userStore = useUserStore();

</script>

<template>
  <DashboardTemplate>
    <template #title>
      <span class="text-sky-300">Welcome Back,<span>Mr. </span></span><span class="text-sky-700">
        {{ userStore.user.name }}</span>!
    </template>
    <template #content>
      <!-- Overview -->
      <div class="mt-10 container">
        <h1 class="text-sky-300 font-bold">Overview</h1>
        <div class="mt-5 flex flex-row bg-sky-300 w-fit h-25 pl-5 pr-5 rounded-md">
          <div class="flex flex-row m-auto space-x-40 items-center">
            <div class="flex flex-row rounded-md bg-white w-50 h-20 justify-evenly pt-5">
              <img :src="Star" alt="" class="size-fit" />
              <p class="text-black text-xl text-center p-2">
                Level <span>0</span>
              </p>
            </div>
          </div>
        </div>
      </div>

    </template>
  </DashboardTemplate>
</template>
