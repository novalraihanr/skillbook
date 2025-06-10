<script setup>
import CourseImg from "@/assets/img/courseimage.png";
import { RouterLink } from "vue-router";
defineProps({
  link: String,
  title: String,
  progress: Number
})
</script>

<template>
  <RouterLink :to="`/student/courses/${link}`" class="size-fit">
    <div class="w-fit h-fit">
      <div class="flex flex-row bg-white rounded-md w-fit h-fit py-3 px-3 space-x-10">
        <div class="w-full">
          <img :src="CourseImg" alt="" />
        </div>
        <div class="flex flex-col w-full space-y-5">
          <div class="bg-sky-300 rounded-md w-fit">
            <p class="text-white font-bold text-xs py-2 px-3">CODING</p>
          </div>
          <div>
            <h1 class="font-bold text-base">{{ title }}</h1>
          </div>
          <div class="flex flex-row w-60 justify-between mt-5">
            <div>
              <p class="text-sky-300">{{ progress }}%</p>
            </div>
            <div class="w-50 h-2.5 rounded-full outline-2 outline-black mt-2">
              <div class="bg-sky-300 rounded-full h-2.5" :style="`width: ${progress}%`"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </RouterLink>
</template>
