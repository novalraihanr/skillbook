<script setup>
import DashboardTemplate from './DashboardTemplate.vue';

import CourseImg from "@/assets/img/courseimage.png"

import LessonsComponent from './LessonsComponent.vue';
import LessonsComponentPending from './LessonsComponentPending.vue';
import RankingComponent from './RankingComponent.vue';


import { register } from 'swiper/element/bundle';
register();

</script>

<template>
  <DashboardTemplate>
    <template #title>
      <!-- TODO: Fetch Title from Data Display it Here -->
      <span class="text-sky-300">Introduction to Java</span>
    </template>

    <template #content>
      <div class="flex flex-row justify-between mt-8 space-x-8">
        <div>
          <img :src="CourseImg" alt="" class="size-60">
        </div>
        <div class="flex flex-col">
          <div class="text-wrap text-black text-base text-justify h-fit w-150">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
              dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
              ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
              fugiat
              nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
              anim id est laborum.</p>
          </div>
          <div class="flex flex-row h-full w-full items-end justify-between">
            <div class="bg-sky-300 rounded-md w-fit h-fit">
              <p class="text-white font-bold text-xs py-2 px-3">CODING</p>
            </div>
            <div>
              <h1 class="text-sky-400 font-bold">3 hours and 20 minutes</h1>
            </div>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-3 gap-2 h-full w-full mt-10 mb-10">
        <div class="col-span-2 flex flex-col w-full h-fit bg-sky-400 rounded-[20px]">
          <h1 class="ml-5 mt-5 font-bold text-white text-2xl">Lessons</h1>
          <div class="flex flex-col space-y-5 ml-5 mt-5 mb-5">
            <div>
              <LessonsComponent />
            </div>
            <div>
              <LessonsComponent />
            </div>
            <div>
              <LessonsComponentPending />
            </div>
            <div>
              <LessonsComponentPending />
            </div>
            <div>
              <LessonsComponentPending />
            </div>
          </div>
        </div>

        <div class="flex flex-col w-full h-fit outline-2 outline-sky-400 rounded-[20px]">
          <h1 class="ml-5 mt-5 font-bold text-sky-400 text-2xl">Ranking</h1>
          <div class="flex flex-col ml-1 mr-1 mt-5 mb-5 space-y-5">
            <div>
              <RankingComponent />
            </div>
            <div>
              <RankingComponent />
            </div>
            <div>
              <RankingComponent />
            </div>
            <div>
              <RankingComponent />
            </div>
            <div>
              <RankingComponent />
            </div>
            <div>
              <RankingComponent />
            </div>
          </div>

        </div>


      </div>
    </template>

  </DashboardTemplate>
</template>
