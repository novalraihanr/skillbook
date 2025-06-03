<script setup>
import firstIcon from "@/assets/img/1st.png"
import secondIcon from "@/assets/img/2nd.png"
import thirdIcon from "@/assets/img/3rd.png"
</script>

<!-- TODO: Insert the data -->
<template>
  <div class="flex flex-row bg-sky-400 w-70 h-7 rounded-[20px] justify-between items-center pr-5 pl-5">
    <div class="flex flex-row space-x-3">
      <!-- TODO: Change this image according to the rank from data -->
      <div>
        <img :src="firstIcon" alt="">
      </div>
      <div>
        <p class="text-white font-bold">John Smith</p>
      </div>
    </div>
    <div class="flex bg-white rounded-[20px] h-5 w-fit px-5 justify-center items-center">
      <p class="text-sky-400 font-light">99pts</p>

    </div>
  </div>
</template>
