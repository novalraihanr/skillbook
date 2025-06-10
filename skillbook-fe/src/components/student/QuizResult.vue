<script setup>
import DashboardTemplate from './DashboardTemplate.vue';
import { RouterLink } from 'vue-router';

import { useUserStore, useQuizStore } from "../../../stores/userStore";
import { computed, onMounted, watch } from "vue";
import { ref } from "vue";
import { useRoute } from 'vue-router';
import router from '@/router/index.js';
import axiosInstance from "@/axios";

const userStore = useUserStore();
const pageContent = ref([])
const route = useRoute()
const quizStore = useQuizStore()
const courseId = route.params.course
const lessonsId = route.params.lesson

const data = ref({
  user_id: userStore.user.user_id,
  course_id: courseId,
  total_score: quizStore.getScore(lessonsId)
})

onMounted(async () => {
  try {
    const response = await axiosInstance.post('/api/users/updatescore', {
      user_id: data.value.user_id,
      course_id: data.value.course_id,
      total_score: data.value.total_score.score
    })
    quizStore.clearLesson(lessonsId)
    console.log(quizStore.getScore(lessonsId))
  } catch (err) {
    console.error(err)
  }

})
</script>

<template>
  <DashboardTemplate>

    <template #title>
      <span class="text-sky-300">Result</span>
    </template>

    <template #content>
      <div class="flex flex-col container justify-center size-full mx-100 my-15">
        <div class="flex flex-col size-150 outline-sky-400 outline-3 rounded-full justify-between items-center p-20">
          <div class="flex flex-col space-y-15">
            <div class="bg-sky-400 w-fit h-20 px-12 text-center py-5 rounded-[20px]">
              <!-- TODO: Change this according to the score -->
              <p id="score" class="text-white font-bold text-5xl">{{ data.total_score.score }}%</p>
            </div>
            <div>
              <!-- TODO: change the comment according to the score -->
              <p id="comment" class="text-sky-400 font-bold text-5xl">Good Job</p>
            </div>
          </div>
          <div>
            <!-- TODO: Make it redirect back to CourseDetail -->
            <RouterLink :to="`/student/courses/${courseId}`">
              <button class="bg-sky-400 w-50 h-15 rounded-[20px]">
                <p class="font-bold text-white text-2xl">Back</p>
              </button>
            </RouterLink>
          </div>
        </div>
      </div>
    </template>

  </DashboardTemplate>
</template>
