<script setup>
import Star from "@/assets/img/Star.png";
import Quil from "@/assets/img/Quil.png";
import Book from "@/assets/img/Book.png";
</script>

<template>
    <div class="flex flex-col ml-10 mt-10">
        <div>
            <h1 class="text-4xl font-bold font-outfit">
                <span class="text-sky-300">Welcome Back,</span
                ><span class="text-sky-700"> John Smith</span>!
            </h1>
        </div>
        <div class="mt-10">
            <h1 class="text-sky-300 font-bold">Overview</h1>
            <div
                class="mt-5 flex flex-row bg-sky-300 w-fit h-25 pl-5 pr-5 rounded-md"
            >
                <div class="flex flex-row m-auto space-x-40 items-center">
                    <div
                        class="flex flex-row rounded-md bg-white w-50 h-20 justify-evenly pt-5"
                    >
                        <img :src="Star" alt="" class="size-fit" />
                        <p class="text-black text-xl text-center p-2">
                            Level <span>0</span>
                        </p>
                    </div>

                    <div
                        class="flex flex-row rounded-md bg-white w-50 h-20 justify-evenly pt-5"
                    >
                        <img :src="Book" alt="" class="size-fit" />
                        <div>
                            <p class="text-black text-xl pt-1">0%</p>
                            <p class="text-black text-xs text-center">
                                Course Completed
                            </p>
                        </div>
                    </div>
                    <div
                        class="flex flex-row rounded-md bg-white w-50 h-20 justify-evenly pt-5"
                    >
                        <img :src="Quil" alt="" class="size-fit" />
                        <div>
                            <p class="text-black text-xl pt-1">0</p>
                            <p class="text-black text-xs text-center">
                                Total Course
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
