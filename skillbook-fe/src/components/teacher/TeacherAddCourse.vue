<script setup>
import DashboardTemplate from '../student/DashboardTemplate.vue';
import { ref } from 'vue';
import axiosInstance from '@/axios'; // Make sure you have axios installed and configured
import { useRouter } from 'vue-router';

const router = useRouter();

// Form fields
const title = ref('');
const description = ref('');

// Submit handler
const handleSubmit = async () => {
  try {
    // Replace '/api/course' with your actual API endpoint
    const response = await axiosInstance.post('/api/courses', {
      title: title.value,
      description: description.value,
    });

    console.log('Course created:', response.data);

    // Redirect after successful submission
    router.push('/teacher/courses');
  } catch (error) {
    console.error('Error creating course:', error);
    alert('Failed to create course. Please try again.');
  }
};


</script>

<template>
  <DashboardTemplate>
    <template #title>
      <span class="text-sky-300">Add Course</span>
    </template>

    <template #content>
      <div class="flex flex-col container">
        <form @submit.prevent="handleSubmit" class="mt-10">
          <div class="space-y-10">
            <!-- Title -->
            <div class="grid grid-cols-2 gap-x-2">
              <label for="title" class="col-span-2 text-sm">Title</label>
              <div class="flex rounded-md outline-1 outline-gray-300 col-span-2">
                <input v-model="title" type="text" id="title" class="block w-full py-1.5 pr-3 pl-1 focus:outline-none"
                  placeholder="Enter course title" required />
              </div>
            </div>

            <!-- Description -->
            <div class="grid grid-cols-1 gap-x-2">
              <label for="desc" class="text-sm">Description</label>
              <div class="flex rounded-md outline-1 outline-gray-300 mt-3">
                <textarea v-model="description" id="desc" class="block w-full h-32 p-3 focus:outline-none resize-none"
                  placeholder="Enter course description" required></textarea>
              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="flex mt-10">
            <button type="submit"
              class="bg-sky-400 rounded-md w-full h-10 px-5 text-white font-bold hover:bg-sky-500 transition">
              Submit
            </button>
          </div>
        </form>
      </div>
    </template>
  </DashboardTemplate>
</template>
