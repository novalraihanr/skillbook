<script setup>
defineProps({
  lesson: Number,
  course: Number,
  link: String,
  title: String,
  progress: Number
})
</script>

<template>
  <RouterLink :to="`/student/courses/${course}/lessons/${lesson}/page/${link}`">
    <div class="flex flex-row outline-2 outline-white  w-190 h-13  rounded-[20px] items-center justify-between px-3">
      <div class="ml-5">
        <p class="text-white font-bold">{{ title }}</p>
      </div>
      <div class="flex bg-white h-12 w-40 rounded-[20px] items-center justify-center">
        <p class="text-sky-400 font-bold text-sm">{{ progress }}%</p>
      </div>
    </div>
  </RouterLink>
</template>
