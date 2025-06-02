<script setup>
import whatsapp from "@/assets/img/whatsapp.png";
import instagram from "@/assets/img/instagram.png";
import gmail from "@/assets/img/gmail.png";
</script>

<template>
    <footer class="flex bg-sky-400 w-full mt-30 justify-evenly">
        <div class="text-white my-20 text-4xl">
            <h1>
                <span class="text-sky-700">Learning</span> Is The Ultimate Game
            </h1>
            <h1>
                And <span class="text-sky-700">Knowledge</span> Is The Reward
            </h1>
        </div>
        <div class="flex size-10 space-x-3 my-25">
            <img :src="whatsapp" alt="WhatsApp" />
            <img :src="instagram" alt="Instagram" />
            <img :src="gmail" alt="Gmail" />
        </div>
    </footer>
</template>
