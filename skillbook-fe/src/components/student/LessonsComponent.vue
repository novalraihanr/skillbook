<script setup>
import { useUserStore } from "../../../stores/userStore";
import { computed, onMounted } from "vue";
import { useRouter } from 'vue-router';
import axiosInstance from "@/axios";
import { ref } from "vue";

const props = defineProps({
  lesson: Number,
  course: Number,
  link: String,
  title: String,
  progress: Number
})

const userStore = useUserStore();
const isTeacher = computed(() => userStore.user.role === 'teacher')
const router = useRouter();
const lessonId = ref(props.lesson)

const deleteLesson = () => {
  const response = axiosInstance.delete(`/api/lessons/${lessonId.value}`)
  router.push('/teacher/courses')
}

</script>

<template>
  <div class="flex flex-row">

    <RouterLink :to="`/student/courses/${props.course}/lessons/${props.lesson}/page/${props.link}`">
      <div class="flex flex-row bg-white  w-190 h-13  rounded-[20px] items-center justify-between px-3">
        <div class="ml-5">
          <p class="text-sky-400 font-bold">{{ props.title }}</p>
        </div>
        <div class="flex flex-row items-center space-x-3">
          <div class="flex bg-sky-400 h-12 w-40 rounded-[20px] items-center justify-center">
            <p class="text-white font-bold text-lg">{{ props.progress }}%</p>
          </div>
        </div>
      </div>
    </RouterLink>
    <RouterLink v-if="isTeacher" :to="`/teacher/courses/${props.course}/lessons/update/${props.lesson}`"
      class="flex text-white font-bold bg-blue-400 h-fit w-fit px-5 py-2 rounded-[20px] items-center justify-center">
      <button>U</button>
    </RouterLink>
    <div v-if="isTeacher">
      <button @click="deleteLesson()"
        class="flex text-white font-bold bg-red-400 h-fit w-fit px-5 py-2 rounded-[20px] items-center justify-center">D</button>
    </div>
  </div>
</template>
