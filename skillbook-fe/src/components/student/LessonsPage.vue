<script setup>
// TODO : Fetch Data
import DashboardTemplate from './DashboardTemplate.vue';
import { RouterLink } from 'vue-router';

import { useUserStore, useQuizStore } from "../../../stores/userStore";
import { computed, onMounted, watch } from "vue";
import { ref } from "vue";
import { useRoute } from 'vue-router';

import axiosInstance from "@/axios";

const userStore = useUserStore();
const pageContent = ref([])
const route = useRoute()
const page = ref(parseInt(route.params.page) || 1); // Ensure page is parsed as an integer
const lessonsId = route.params.lesson
const courseId = route.params.course
const totalpage = ref()
const title = ref()
const quizStore = useQuizStore()


const previous = computed(() => page.value > 1 ? page.value - 1 : 1);
const next = computed(() => page.value < totalpage.value ? page.value + 1 : totalpage.value);

const fetchPageContent = async () => {
  try {
    const response = await axiosInstance.get(`/api/lessons/${lessonsId}/page`);
    pageContent.value = response.data.current_page;
    totalpage.value = response.data.total_pages;
    title.value = response.data.lesson.title;

    await axiosInstance.post(`/api/lessons/update/${lessonsId}`, {
      lastaccessedpage: page.value
    });
  } catch (error) {
    console.error('Error fetching page content:', error);
  }
};

onMounted(fetchPageContent);

// Watch for changes in the page parameter and reload the content
watch(
  () => route.params.page,
  (newPage) => {
    page.value = parseInt(newPage) || 1;
    fetchPageContent();
  }
);

</script>

<template>
  <DashboardTemplate>

    <template #title>
      <!-- TODO: Fetch Title from Data Display it Here -->
      <span class="text-sky-300">{{ title }}</span>
    </template>

    <template #content>
      <div class="flex flex-col container w-350 mt-10 overflow-auto space-y-20">

        <div class="flex flex-col space-y-5 px-15">

          <!-- TODO: Make a If Statement if the data is available -->
          <p class="text-justify" id="content_1">
            {{ pageContent.content_1 }}
          </p>

          <div class="flex flex-col space-y-5 bg-sky-400 w-full rounded-[20px] p-5">
            <h1 class="text-white text-[20px] font-bold">Code</h1>
            <div class="bg-white rounded-[20px] p-10 w-full">
              <p class="font-mono" id="code_1">{{ pageContent.code_1 }}</p>
            </div>
          </div>

        </div>

        <div class="flex flex-col space-y-5 px-15">
          <p class="text-justify" id="content_2">
            {{ pageContent.content_2 }}
          </p>

          <div class="flex flex-col space-y-5 bg-sky-400 w-full rounded-[20px] p-5">
            <h1 class="text-white text-[20px] font-bold">Code</h1>

            <div class="bg-white rounded-[20px] p-10 w-full">
              <p class="font-mono" id="code_1">{{ pageContent.code_2 }}</p>
            </div>

          </div>

        </div>

        <div class="flex flex-row justify-between px-20 mb-10 mt-10">

          <RouterLink :to="`/student/courses/${courseId}/lessons/${lessonsId}/page/${previous}`" v-if="page > 1">
            <div class="bg-sky-400 w-fit px-10 py-5 rounded-[20px]">
              <p class="text-white font-bold">Previous</p>
            </div>
          </RouterLink>

          <RouterLink :to="`/student/courses/${courseId}/lessons/${lessonsId}/page/${next}`" v-if="totalpage > page">
            <div class="bg-sky-400 w-fit px-10 py-5 rounded-[20px]">
              <p class="text-white font-bold">Next</p>
            </div>
          </RouterLink>

          <RouterLink :to="`/student/courses/${courseId}/lessons/${lessonsId}/quiz/1`" v-else>
            <div class="bg-sky-400 w-fit px-10 py-5 rounded-[20px]">
              <p class="text-white font-bold">Next</p>
            </div>
          </RouterLink>

        </div>

      </div>
    </template>
  </DashboardTemplate>
</template>
