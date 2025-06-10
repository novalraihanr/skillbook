<script setup>
import DashboardTemplate from './DashboardTemplate.vue';
import CourseCard from './CourseCard.vue';

import { register } from 'swiper/element/bundle';
register();

import { useUserStore } from "../../../stores/userStore";
import { computed, onMounted } from "vue";
import { ref } from "vue";

import axiosInstance from "@/axios";

const userStore = useUserStore();
const course = ref([])
const courseCompleted = ref([])

onMounted(async () => {
  const response = await axiosInstance.get(`/api/users/all/${userStore.user.user_id}`)
  console.log(response.data);
  course.value = response.data.courses;

  const responseCompleted = await axiosInstance.get(`/api/users/all/completed/${userStore.user.user_id}`)
  console.log(responseCompleted.data);
  courseCompleted.value = responseCompleted.data.courses;
})

</script>

<template>
  <DashboardTemplate>
    <template #title>
      <span class="text-sky-300">My Courses</span>
    </template>
    <template #content>
      <div class="mt-5 container">
        <div class="text-sky-300 mt-3">
          <h1 class="font-bold text-lg">Enrolled</h1>
        </div>
        <div class="mt-5">
          <!-- TODO: Use V-For to render Management Courses data -->
          <swiper-container class="flex flex-row pl-3 py-3 bg-sky-400 rounded-md" :slides-per-view="3" :free-mode="true"
            :spaceBetween="10">
            <swiper-slide v-for="course in course" :key="course.course_id" class="!w-fit">
              <CourseCard :link="course.course_id" :title=course.title :progress="course.pivot.progress" />
            </swiper-slide>
          </swiper-container>
        </div>
      </div>
      <div class="mt-5 container">
        <div class="text-sky-300 mt-3">
          <h1 class="font-bold text-lg">Completed</h1>
        </div>
        <div class="mt-5">
          <!-- TODO: Use V-For to render Management Courses data -->
          <swiper-container class="flex flex-row flex-nowrap  pl-3 py-3 bg-sky-400 rounded-md" :slides-per-view="3"
            :free-mode="true" :spaceBetween="10">
            <swiper-slide v-for="course in courseCompleted" :key="course.course_id" class="!w-fit">
              <CourseCard :link="course.course_id" :title=course.title :progress="course.pivot.progress" />
            </swiper-slide>
          </swiper-container>
        </div>
      </div>
    </template>
  </DashboardTemplate>

</template>
