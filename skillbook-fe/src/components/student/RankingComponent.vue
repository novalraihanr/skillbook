<script setup>
import firstIcon from "@/assets/img/1st.png"
import secondIcon from "@/assets/img/2nd.png"
import thirdIcon from "@/assets/img/3rd.png"

defineProps({
  link: String,
  name: String,
  score: Number,
  rank: Number
})
</script>

<!-- TODO: Insert the data -->
<template>
  <div class="flex flex-row bg-sky-400 w-70 h-7 rounded-[20px] justify-between items-center pr-5 pl-5">
    <div class="flex flex-row space-x-3">
      <!-- TODO: Change this image according to the rank from data -->
      <div v-if="rank === 1">
        <img :src="firstIcon" alt="">
      </div>
      <div v-else-if="rank === 2">
        <img :src="secondIcon" alt="">
      </div>
      <div v-else-if="rank === 3">
        <img :src="thirdIcon" alt="">
      </div>
      <div v-else>
        <p class="text-white">{{ rank }}th</p>
      </div>
      <div>
        <p class="text-white font-bold">{{ name }}</p>
      </div>
    </div>
    <div class="flex bg-white rounded-[20px] h-5 w-fit px-5 justify-center items-center">
      <p class="text-sky-400 font-light">{{ score }}pts</p>

    </div>
  </div>
</template>
