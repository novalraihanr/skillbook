<script setup>
import DashboardTemplate from './DashboardTemplate.vue';

import { useUserStore, useQuizStore } from "../../../stores/userStore";
import { computed, onMounted, watch } from "vue";
import { ref } from "vue";
import { useRoute, useRouter } from 'vue-router';

import axiosInstance from "@/axios";

const userStore = useUserStore();
const pageContent = ref([])
const route = useRoute()
const router = useRouter()
const page = ref(parseInt(route.params.page) || 1); // Ensure page is parsed as an integer
const lessonsId = route.params.lesson
const courseId = route.params.course
const totalpage = ref()
const title = ref()
const quizStore = useQuizStore()
const selectedOpt = ref('');
const nextPage = computed(() => page.value + 1);

function navigateToNextQuestion() {
  if (nextPage.value <= totalpage.value) {
    router.push(`/student/courses/${courseId}/lessons/${lessonsId}/quiz/${nextPage.value}`);
  } else {
    // Navigate to results page or back to lessons
    router.push(`/student/courses/${courseId}/lessons/${lessonsId}/quiz/result`);
  }
}


const fetchQuizData = async () => {
  try {
    // Initialize lesson in store (if needed)
    quizStore.initializeLesson(lessonsId);

    // Get current page data from API (include page in request)
    const response = await axiosInstance.get(
      `/api/lessons/${lessonsId}/quiz`
    );

    // Update state with new data
    pageContent.value = response.data.current_page;
    totalpage.value = response.data.total_pages;
    title.value = response.data.lesson.title;

    // Track progress in backend
    await axiosInstance.post(`/api/lessons/update/quiz/${lessonsId}`, {
      lastaccessedquiz: page.value
    });
  } catch (error) {
    console.error('Quiz data fetch error:', error);
    router.push(`/student/courses/${courseId}/lessons/${lessonsId}`);
  }
};

// Answer selection handler
const selectOption = (option) => {

  selectedOpt.value = option;
  const isCorrect = pageContent.value.correct_ans === option;

  if (isCorrect) {
    quizStore.incrementScore(lessonsId, pageContent.value.score);
  }

  // Small delay for UI feedback before navigating
  setTimeout(navigateToNextQuestion, 500);
};

// Watch for route changes
watch([
  () => route.params.page,
  () => route.params.lesson
], ([newPage, newLesson]) => {
  if (newPage && parseInt(newPage) !== page.value) {
    page.value = parseInt(newPage) || 1;
    fetchQuizData();
  }

  if (newLesson && newLesson !== lessonsId) {
    lessonsId = newLesson;
    page.value = 1; // Reset page when changing lessons
    fetchQuizData();
  }
}, { immediate: true }); // Initial load


onMounted(fetchQuizData);

</script>

<template>
  <DashboardTemplate>

    <template #title>
      <span class="text-sky-300">Quiz</span>
    </template>

    <template #content>
      <div class="grid grid-rows-3 container my-20">

        <div class="flex overflow-auto px-20 h-fit">
          <!-- TODO: Make this change question -->
          <p class="text-justify text-[20px]">{{ pageContent.question }}</p>
        </div>

        <div class="flex flex-col row-span-2 px-20 w-full space-y-10">

          <!-- TODO: Make this save score and go to next question -->
          <div @click="selectOption(pageContent.answer_a)"
            class="outline-sky-400 outline-3 hover:bg-sky-400 text-sky-400 hover:text-white rounded-[20px] p-5">
            <p class="font-bold uppercase">A. <span>{{ pageContent.answer_a }}</span></p>
          </div>
          <div @click="selectOption(pageContent.answer_b)"
            class="outline-sky-400 outline-3 hover:bg-sky-400 text-sky-400 hover:text-white rounded-[20px] p-5">
            <p class="font-bold uppercase">B. <span>{{ pageContent.answer_b }}</span></p>
          </div>
          <div @click="selectOption(pageContent.answer_c)"
            class="outline-sky-400 outline-3 hover:bg-sky-400 text-sky-400 hover:text-white rounded-[20px] p-5">
            <p class="font-bold uppercase">C. <span>{{ pageContent.answer_c }}</span></p>
          </div>
          <div @click="selectOption(pageContent.answer_d)"
            class="outline-sky-400 outline-3 hover:bg-sky-400 text-sky-400 hover:text-white rounded-[20px] p-5">
            <p class="font-bold uppercase">D. <span>{{ pageContent.answer_d }}</span></p>
          </div>
        </div>

      </div>

    </template>

  </DashboardTemplate>
</template>
