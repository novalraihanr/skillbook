<script setup>
import DashboardTemplate from './DashboardTemplate.vue';

import CourseImg from "@/assets/img/courseimage.png"

import LessonsComponent from './LessonsComponent.vue';
import LessonsComponentPending from './LessonsComponentPending.vue';
import RankingComponent from './RankingComponent.vue';

import { RouterLink } from 'vue-router';

import { register } from 'swiper/element/bundle';
register();

import { useUserStore } from "../../../stores/userStore";
import { computed, onMounted } from "vue";
import { ref } from "vue";
import { useRoute } from 'vue-router';

import axiosInstance from "@/axios";

const userStore = useUserStore();
const course = ref([])
const lessons = ref([])
const ranking = ref([])
const route = useRoute()
const courseId = route.params.course
const lessonsId = route.params.lesson

const enrollUser = async () => {
  try {
    const response = await axiosInstance.post('/api/courses/enroll-user', {
      user_id: userStore.user.user_id,
      course_id: courseId,
    });

    console.log('Enrollment successful:', response.data);
    alert('User enrolled successfully!');
  } catch (error) {
    console.error('Enrollment failed:', error.response?.data || error.message);
    alert('Enrollment failed. Please try again.');
  }
};

onMounted(async () => {
  const response = await axiosInstance.get(`/api/courses/${courseId}`)
  course.value = response.data
  console.log(course.value)

  const lessonsData = await axiosInstance.get(`/api/courses/lessons/${courseId}`)
  lessons.value = lessonsData.data.lessons
  console.log(lessonsData.data.lessons)

  const ranks = await axiosInstance.get(`/api/users/rank/course/${courseId}`)
  ranking.value = ranks.data
  console.log(ranking.value)

  const update = await axiosInstance.post(`/api/courses/updateprogress`, {
    user_id: userStore.user.user_id,
    course_id: courseId
  })
})

const isTeacher = computed(() => userStore.user.role === 'teacher')

</script>

<!-- TODO: Add V-IF if users role is a teacher -->

<template>
  <DashboardTemplate>
    <template #title>
      <!-- TODO: Fetch Title from Data Display it Here -->
      <span class="text-sky-300">{{ course.title }}</span>
    </template>

    <template #content>
      <div class="flex flex-row justify-start mt-8 space-x-5">
        <div>
          <img :src="CourseImg" alt="" class="size-60">
        </div>
        <div class="flex flex-col pl-20">
          <div class="text-wrap text-black text-base text-justify h-fit w-svh">
            <p>{{ course.description }}</p>
          </div>
          <div class="flex flex-row h-full w-full items-end justify-between">
            <div class="bg-sky-300 rounded-md w-fit h-fit">
              <p class="text-white font-bold text-xs py-2 px-3">CODING</p>
            </div>
          </div>
        </div>
      </div>

      <!-- TODO: Connect Router Link -->
      <div v-if="isTeacher" class="bg-sky-400 text-white px-5 py-3 w-fit mt-5 rounded-[20px]">
        <RouterLink :to="`/teacher/courses/${courseId}/lesson/addlesson`">
          <button>
            Add Lessons
          </button>

        </RouterLink>
      </div>


      <div v-if="!isTeacher" class="bg-sky-400 text-white px-5 py-3 w-fit mt-5 rounded-[20px]">
        <button @click="enrollUser()">
          Enroll
        </button>

      </div>

      <!-- TODO: Add V-FOR -->
      <div class="grid grid-cols-3 gap-2 h-full w-full mt-5 mb-10">
        <div class="col-span-2 flex flex-col w-full h-fit bg-sky-400 rounded-[20px]">
          <h1 class="ml-5 mt-5 font-bold text-white text-2xl">Lessons</h1>
          <div class="flex flex-col space-y-5 ml-auto mr-auto mt-5 mb-5">
            <div v-for="lesson in lessons" :key="lesson.lesson_id">
              <div v-if="lesson.progress === 100">
                <LessonsComponent :title="lesson.title" :progress="lesson.progress" :link="lesson.lastaccessedpage"
                  :course="courseId" :lesson="lesson.lessons_id" />
              </div>
              <div v-else>
                <LessonsComponentPending :title="lesson.title" :progress="lesson.progress"
                  :link="lesson.lastaccessedpage" :course="courseId" :lesson="lesson.lessons_id" />
              </div>
            </div>
          </div>
        </div>

        <!-- TODO: Add V-FOR -->
        <div class="flex flex-col w-full h-fit outline-2 outline-sky-400 rounded-[20px]">
          <h1 class="ml-5 mt-5 font-bold text-sky-400 text-2xl">Ranking</h1>
          <div class="flex flex-col ml-auto mr-auto mt-5 mb-5 space-y-5">
            <div v-for="rank in ranking" :key="rank.rank">
              <RankingComponent :name="rank.name" :score="rank.totalscore" :rank="rank.rank" />
            </div>
          </div>

        </div>


      </div>
    </template>

  </DashboardTemplate>
</template>
