<script setup>
import Logo from "@/assets/img/logregimg.png";
import { RouterLink } from "vue-router";
</script>

<template>
    <div class="flex flex-row">
        <div class="w-auto h-fit">
            <img :src="Logo" alt="" />
        </div>
        <div class="flex flex-col ml-25 mt-30 space-y-5 w-100">
            <div class="space-y-3">
                <h1 class="text-sky-400 font-bold text-4xl">Register</h1>
                <p class="text-gray-500">Hi, Please make your account</p>
            </div>
            <form class="mt-5">
                <div class="space-y-10">
                    <div class="grid grid-cols-1 gap-x-2">
                        <label for="username" class="text-sm">Username</label>
                        <div
                            class="flex rounded-md outline-1 outline-gray-300 mt-3"
                        >
                            <input
                                type="text"
                                id="username"
                                class="block min-w-0 grow py-1.5 pr-3 pl-1 focus:outline-none"
                            />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-x-2">
                        <label for="email" class="text-sm">Email</label>
                        <div
                            class="flex rounded-md outline-1 outline-gray-300 mt-3"
                        >
                            <input
                                type="email"
                                id="email"
                                class="block min-w-0 grow py-1.5 pr-3 pl-1 focus:outline-none"
                            />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-x-2">
                        <label for="password" class="text-sm">Password</label>
                        <div
                            class="flex rounded-md outline-1 outline-gray-300 mt-3"
                        >
                            <input
                                type="password"
                                id="password"
                                class="block min-w-0 grow py-1.5 pr-3 pl-1 focus:outline-none"
                            />
                        </div>
                    </div>
                </div>
            </form>
            <div class="flex flex-row justify-between mt-5">
                <div class="space-x-2">
                    <input type="checkbox" name="remember" id="remember" />
                    <label for="remember" class="text-sm">Remember Me</label>
                </div>
                <div>
                    <a href="" class="text-gray-400 text-sm"
                        >Forgot Password?</a
                    >
                </div>
            </div>
            <div class="mt-5">
                <RouterLink to="/register">
                    <button
                        class="bg-sky-400 rounded-md w-full h-10 text-white font-bold"
                    >
                        Register
                    </button>
                </RouterLink>
            </div>
            <div class="mt-5">
                <p class="text-gray-400 text-sm">
                    Already Have an Account?
                    <RouterLink to="/login" class="text-sky-400 text-sm"
                        >Login</RouterLink
                    >
                </p>
            </div>
        </div>
    </div>
</template>
