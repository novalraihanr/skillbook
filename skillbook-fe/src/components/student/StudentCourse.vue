<script setup>
import DashboardTemplate from './DashboardTemplate.vue';
import CourseCard from './CourseCard.vue';

import { register } from 'swiper/element/bundle';
register();
</script>

<template>
  <DashboardTemplate>
    <template #title>
      <span class="text-sky-300">My Courses</span>
    </template>
    <template #content>
      <div class="flex flex-col mt-5">
        <div class="text-sky-300 mt-3">
          <h1 class="font-bold text-lg">Enroled</h1>
        </div>
        <div class="mt-5">
          <!-- TODO: Use V-For to render enroled courses data -->
          <swiper-container class="pl-3 py-3 bg-sky-400 rounded-l-md w-280" :slides-per-view="2" :free-mode="true"
            :space-between="-120">
            <swiper-slide>
              <CourseCard />
            </swiper-slide>
            <swiper-slide>
              <CourseCard />
            </swiper-slide>
            <swiper-slide>
              <CourseCard />
            </swiper-slide>
            <swiper-slide>
              <CourseCard />
            </swiper-slide>
            <swiper-slide>
              <CourseCard />
            </swiper-slide>
            <swiper-slide>
              <CourseCard />
            </swiper-slide>
          </swiper-container>
        </div>
      </div>
      <div class="flex flex-col mt-5">
        <div class="text-sky-300 mt-3">
          <h1 class="font-bold text-lg">Completed</h1>
        </div>
        <div class="mt-5">
          <!-- TODO: Use V-For to render completed courses data -->
          <swiper-container class="pl-3 py-3 bg-sky-400 rounded-l-md w-280" :slides-per-view="2" :free-mode="true"
            :space-between="-120">
            <swiper-slide>
              <CourseCard />
            </swiper-slide>
            <swiper-slide>
              <CourseCard />
            </swiper-slide>
            <swiper-slide>
              <CourseCard />
            </swiper-slide>
            <swiper-slide>
              <CourseCard />
            </swiper-slide>
            <swiper-slide>
              <CourseCard />
            </swiper-slide>
            <swiper-slide>
              <CourseCard />
            </swiper-slide>
          </swiper-container>
        </div>
      </div>
    </template>
  </DashboardTemplate>

</template>
