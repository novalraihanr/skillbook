<script setup>
import DashboardTemplate from './DashboardTemplate.vue';
import RankingComponent from './RankingComponent.vue';
</script>

<template>
  <DashboardTemplate>
    <template #title>
      <span class="text-sky-300">Ranking</span>
    </template>

    <template #content>
      <div class="flex flex-col container">
        <div class="grid grid-cols-3 gap-5">
          <div class="flex flex-col space-y-2">
            <p class="text-sky-400 font-bold text-[20px]">Jane Doe</p>
            <div class="bg-sky-400 w-20 h-10">

            </div>
          </div>
          <div>
            <p class="text-sky-400 font-bold text-[20px]">John Doe</p>
          </div>
          <div>
            <p class="text-sky-400 font-bold text-[20px]">John Smith</p>
          </div>
        </div>
        <div class="flex flex-col outline-2 outline-sky-400 rounded-[20px] w-100">
          <RankingComponent />
        </div>
      </div>
    </template>

  </DashboardTemplate>
</template>
