<script setup>
import GameBoy from "@/assets/img/GameBoy.png"
</script>

<template>
  <main class="flex justify-center space-x-40 my-30">
    <div>
      <img :src="GameBoy" alt="">
    </div>
    <article class="flex flex-col space-y-5">
      <div class="text-4xl font-bold">
        <h1>
          <span class="text-sky-400">Learn</span>
          Smarter.
        </h1>
        <h1>
          <span class="text-sky-400">Play</span>
          Harder.
        </h1>
      </div>
      <div class="flex flex-col max-w-md text-justify tracking-wide">
        <p>Why choose between <span class="text-sky-400">education</span> and <span
            class="text-sky-400">enjoyment</span>?</p>
        <p>With our gamified learning experience, you get the best of both worlds - interactive challenges, fun rewards,
          and real progress. Whether you're solving puzzles, earning badges, or climbing the leaderboard, you're not
          playing - you're learning.</p>
        <p class="my-1">Because when learning is <span class="text-sky-400">fun</span>, it sticks.</p>
      </div>
    </article>
  </main>
</template>
