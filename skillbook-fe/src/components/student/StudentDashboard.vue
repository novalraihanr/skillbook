<script setup>
import { RouterLink } from "vue-router";

import Star from "@/assets/img/Star.png";
import Quil from "@/assets/img/Quil.png";
import Book from "@/assets/img/Book.png";

import DashboardTemplate from "./DashboardTemplate.vue";
import CourseCard from "@/components/student/CourseCard.vue";

import { useUserStore } from "../../../stores/userStore";
import { onMounted } from "vue";
import { ref } from "vue";

import axiosInstance from "@/axios";

const userStore = useUserStore();
const course = ref([])
const courseCompleted = ref([])

const countCourse = ref()
const countCompleted = ref()

onMounted(async () => {
  const response = await axiosInstance.get(`/api/users/${userStore.user.user_id}`)
  console.log(response.data);
  course.value = response.data.courses;
  countCourse.value = response.data.courses_count;

  const responseCompleted = await axiosInstance.get(`/api/users/completed/${userStore.user.user_id}`)
  console.log(responseCompleted.data);
  courseCompleted.value = responseCompleted.data.courses;
  countCompleted.value = responseCompleted.data.courses_count;
})

</script>

<template>
  <DashboardTemplate>
    <template #title>
      <span class="text-sky-300">Welcome Back, </span><span class="text-sky-700"> {{ userStore.user.name }}</span>!
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
                Level <span>{{ userStore.user.level }}</span>
              </p>
            </div>

            <div class="flex flex-row rounded-md bg-white w-50 h-20 justify-evenly pt-5">
              <img :src="Book" alt="" class="size-fit" />
              <div>
                <p class="text-black text-xl pt-1">{{ countCompleted }}</p>
                <p class="text-black text-xs text-center">
                  Completed Course
                </p>
              </div>
            </div>
            <div class="flex flex-row rounded-md bg-white w-50 h-20 justify-evenly pt-5">
              <img :src="Quil" alt="" class="size-fit" />
              <div>
                <p class="text-black text-xl pt-1">{{ countCourse }}</p>
                <p class="text-black text-xs text-center">
                  Total Course
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Course and Skill -->
      <div class="flex flex-row mt-5 space-x-3 mb-5 w-full">
        <div class="flex flex-col w-full h-auto bg-sky-300 rounded-md">
          <div class="mt-3 ml-5">
            <h1 class="text-white font-bold text-2xl">My Course</h1>
          </div>
          <!-- TODO: Fetch Data from Database, sort it to recent -->
          <div class="mt-3 ml-5 mr-5 mb-5" v-for="course in course" :key="course.course_id">
            <CourseCard :link="course.course_id" :title=course.title :progress="course.pivot.progress" />
          </div>
          <div class="text-center mb-3">
            <RouterLink to="/student/courses">
              <p class="text-white font-bold">See More</p>
            </RouterLink>
          </div>
        </div>
        <div class="flex flex-col w-full h-auto bg-sky-300 rounded-md">
          <div class="mt-3 ml-5">
            <h1 class="text-white font-bold text-2xl">
              Acquired Skills
            </h1>
          </div>
          <!-- TODO: Fetch Data from Database, sort it to recent -->
          <div class="mt-3 ml-5 mr-5 mb-5" v-for="course in courseCompleted" :key="course.course_id">
            <CourseCard :link="course.course_id" :title=course.title :progress="course.pivot.progress" />
          </div>
          <div class="text-center mb-3">
            <!-- TODO: Add link to Course -->
            <RouterLink to="/student/courses">
              <p class="text-white font-bold">See More</p>
            </RouterLink>
          </div>
        </div>
      </div>

    </template>
  </DashboardTemplate>
</template>
