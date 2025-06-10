<script setup>
import DashboardTemplate from './DashboardTemplate.vue';
import CourseCard from './CourseCard.vue';
import { RouterLink } from 'vue-router';

import { register } from 'swiper/element/bundle';
register();

import { useUserStore } from "../../../stores/userStore";
import { computed, onMounted } from "vue";
import { ref } from "vue";

import axiosInstance from "@/axios";

const userStore = useUserStore();
const course = ref([])

onMounted(async () => {
  const response = await axiosInstance.get(`/api/courses`)
  console.log(response.data);
  course.value = response.data;
})

const isTeacher = computed(() => userStore.user.role === 'teacher')

</script>

<!-- TODO: Add V-IF if users role is a teacher -->

<template>
  <DashboardTemplate>
    <template #title>
      <span class="text-sky-300">Discover</span>
    </template>
    <template #content>
      <div class="mt-5 container">
        <div class="bg-sky-400 text-white w-fit py-3 px-3 rounded-[20px]" v-if="isTeacher">
          <RouterLink to="/teacher/courses/addcourse">
            <button>
              Add Course
            </button>
          </RouterLink>
        </div>
        <div class="text-sky-300 mt-3">
          <h1 class="font-bold text-lg">Programing</h1>
        </div>
        <div class="mt-5">
          <!-- TODO: Use V-For to render Management Courses data -->
          <swiper-container class="flex flex-row flex-nowrap  pl-3 py-3 bg-sky-400 rounded-md" :slides-per-view="3"
            :free-mode="true" :spaceBetween="10">
            <swiper-slide v-for="course in course" :key="course.course_id">
              <CourseCard :link="course.course_id" :title=course.title :progress="0" />
            </swiper-slide>
          </swiper-container>
        </div>
      </div>
    </template>
  </DashboardTemplate>
</template>
