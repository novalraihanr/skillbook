<script setup>
import Person from "@/assets/img/person.png";
</script>

<template>
    <nav
        class="flex flex-col fixed top-0 left-0 z-40 h-screen transition-transform -translate-x-full sm:translate-x-0 w-60 bg-sky-400"
    >
        <div class="mt-10">
            <h1 class="text-white font-bold text-3xl text-center">
                SKILL<span class="text-sky-600">BOOK</span>
            </h1>
        </div>
        <div
            class="flex flex-col space-y-10 m-auto text-white font-bold text-lg"
        >
            <a href="">Dashboard</a>
            <a href="">Discover</a>
            <a href="">My Course</a>
            <a href="">Ranking</a>
        </div>
        <a
            href="/profile"
            class="flex flex-row rounded-2xl bg-white px-5 py-2 text-black mt-auto text-center justify-center-safe mx-auto mb-10 space-x-3"
        >
            <img :src="Person" alt="" class="size-fit" />
            <p class="text-sm">John Smith</p>
        </a>
    </nav>
</template>
