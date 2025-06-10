<script setup>
import DashboardTemplate from '../student/DashboardTemplate.vue';
import { ref, computed } from 'vue';
import axiosInstance from '@/axios'; // Use your axios instance
import { useRouter, useRoute } from 'vue-router';

const router = useRouter();
const route = useRoute();

// Get course_id from route params (assuming URL like /teacher/courses/:courseId/lessons/create)
const courseId = ref(route.params.course || '');

// Lesson Data
const lessonData = ref({
  course_id: courseId.value,
  title: '',
  progress: 0,
  lastaccessedpage: 1,
  lastaccessedquiz: 1
});

// Lesson Pages
const lessonPages = ref([
  {
    page: 1,
    content_1: '',
    code_1: '',
    content_2: '',
    code_2: ''
  }
]);

// Quizzes
const quizzes = ref([
  {
    page: 1,
    question: '',
    answer_a: '',
    answer_b: '',
    answer_c: '',
    answer_d: '',
    correct_ans: 'a',
    score: 10
  }
]);

// Loading state
const isSubmitting = ref(false);

// Computed
const maxLessonPage = computed(() => lessonPages.value.length);
const maxQuizPage = computed(() => Math.max(...quizzes.value.map(q => q.page), 0));

// Add new lesson page
const addLessonPage = () => {
  const nextPage = lessonPages.value.length + 1;
  lessonPages.value.push({
    page: nextPage,
    content_1: '',
    code_1: '',
    content_2: '',
    code_2: ''
  });
};

// Remove lesson page
const removeLessonPage = (index) => {
  if (lessonPages.value.length > 1) {
    lessonPages.value.splice(index, 1);
    // Reorder page numbers
    lessonPages.value.forEach((page, idx) => {
      page.page = idx + 1;
    });
  }
};

// Add new quiz
const addQuiz = () => {
  quizzes.value.push({
    page: 1,
    question: '',
    answer_a: '',
    answer_b: '',
    answer_c: '',
    answer_d: '',
    correct_ans: 'a',
    score: 10
  });
};

// Remove quiz
const removeQuiz = (index) => {
  if (quizzes.value.length > 1) {
    quizzes.value.splice(index, 1);
  }
};

// Submit form
const handleSubmit = async () => {
  if (!lessonData.value.title.trim()) {
    alert('Please enter a lesson title');
    return;
  }

  if (!courseId.value) {
    alert('Course ID is required');
    return;
  }

  isSubmitting.value = true;

  try {
    const payload = {
      lesson: lessonData.value,
      lesson_pages: lessonPages.value,
      quizzes: quizzes.value
    };

    const response = await axiosInstance.post('/api/lessons', payload);

    console.log('Lesson created:', response.data);

    // Redirect back to course details or lessons list
    router.push(`/teacher/courses/${courseId.value}`);

  } catch (error) {
    console.error('Error creating lesson:', error);
    alert('Failed to create lesson. Please try again.');
  } finally {
    isSubmitting.value = false;
  }
};

// Validation helpers
const isFormValid = computed(() => {
  return lessonData.value.title.trim() &&
    courseId.value &&
    lessonPages.value.every(page => page.content_1.trim()) &&
    quizzes.value.every(quiz => quiz.question.trim() && quiz.answer_a.trim());
});
</script>

<template>
  <DashboardTemplate>
    <template #title>
      <span class="text-sky-300">Create New Lesson</span>
    </template>

    <template #content>
      <div class="flex flex-col container max-w-4xl mx-auto">
        <form @submit.prevent="handleSubmit" class="mt-10 space-y-8">

          <!-- Lesson Basic Info -->
          <div class="bg-white p-6 rounded-lg shadow-sm border">
            <h2 class="text-xl font-semibold mb-4">Lesson Information</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label for="lesson-title" class="block text-sm font-medium mb-1">Lesson Title *</label>
                <input v-model="lessonData.title" type="text" id="lesson-title"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500"
                  placeholder="Enter lesson title" required />
              </div>

              <div>
                <label for="course-id" class="block text-sm font-medium mb-1">Course ID</label>
                <input v-model="lessonData.course_id" type="text" id="course-id"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly />
              </div>
            </div>
          </div>

          <!-- Lesson Pages Section -->
          <div class="bg-white p-6 rounded-lg shadow-sm border">
            <div class="flex justify-between items-center mb-4">
              <h2 class="text-xl font-semibold">Lesson Pages ({{ lessonPages.length }})</h2>
              <button type="button" @click="addLessonPage"
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md text-sm">
                + Add Page
              </button>
            </div>

            <div class="space-y-6">
              <div v-for="(page, index) in lessonPages" :key="index" class="border border-gray-200 rounded-lg p-4">
                <div class="flex justify-between items-center mb-4">
                  <h3 class="font-medium">Page {{ page.page }}</h3>
                  <button v-if="lessonPages.length > 1" type="button" @click="removeLessonPage(index)"
                    class="text-red-500 hover:text-red-700 text-sm">
                    Remove Page
                  </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium mb-1">Content 1 *</label>
                    <textarea v-model="page.content_1" rows="4"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500"
                      placeholder="Enter first content section" required></textarea>
                  </div>

                  <div>
                    <label class="block text-sm font-medium mb-1">Code 1</label>
                    <textarea v-model="page.code_1" rows="4"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md font-mono text-sm focus:outline-none focus:ring-2 focus:ring-sky-500"
                      placeholder="Enter code example"></textarea>
                  </div>

                  <div>
                    <label class="block text-sm font-medium mb-1">Content 2</label>
                    <textarea v-model="page.content_2" rows="4"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500"
                      placeholder="Enter second content section"></textarea>
                  </div>

                  <div>
                    <label class="block text-sm font-medium mb-1">Code 2</label>
                    <textarea v-model="page.code_2" rows="4"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md font-mono text-sm focus:outline-none focus:ring-2 focus:ring-sky-500"
                      placeholder="Enter additional code example"></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Quizzes Section -->
          <div class="bg-white p-6 rounded-lg shadow-sm border">
            <div class="flex justify-between items-center mb-4">
              <h2 class="text-xl font-semibold">Quizzes ({{ quizzes.length }})</h2>
              <button type="button" @click="addQuiz"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm">
                + Add Quiz
              </button>
            </div>

            <div class="space-y-6">
              <div v-for="(quiz, index) in quizzes" :key="index" class="border border-gray-200 rounded-lg p-4">
                <div class="flex justify-between items-center mb-4">
                  <h3 class="font-medium">Quiz {{ index + 1 }}</h3>
                  <button v-if="quizzes.length > 1" type="button" @click="removeQuiz(index)"
                    class="text-red-500 hover:text-red-700 text-sm">
                    Remove Quiz
                  </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                  <div>
                    <label class="block text-sm font-medium mb-1">Page Number</label>
                    <input v-model.number="quiz.page" type="number" min="1" :max="maxLessonPage"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500" />
                  </div>

                  <div>
                    <label class="block text-sm font-medium mb-1">Score</label>
                    <input v-model.number="quiz.score" type="number" min="1" max="100"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500" />
                  </div>

                  <div>
                    <label class="block text-sm font-medium mb-1">Correct Answer</label>
                    <input v-model.number="quiz.correct_ans" type="text"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500" />
                  </div>
                </div>

                <div class="mb-4">
                  <label class="block text-sm font-medium mb-1">Question *</label>
                  <textarea v-model="quiz.question" rows="2"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500"
                    placeholder="Enter your question" required></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium mb-1">Answer A *</label>
                    <input v-model="quiz.answer_a" type="text"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500"
                      placeholder="Answer option A" required />
                  </div>

                  <div>
                    <label class="block text-sm font-medium mb-1">Answer B *</label>
                    <input v-model="quiz.answer_b" type="text"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500"
                      placeholder="Answer option B" required />
                  </div>

                  <div>
                    <label class="block text-sm font-medium mb-1">Answer C *</label>
                    <input v-model="quiz.answer_c" type="text"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500"
                      placeholder="Answer option C" required />
                  </div>

                  <div>
                    <label class="block text-sm font-medium mb-1">Answer D *</label>
                    <input v-model="quiz.answer_d" type="text"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500"
                      placeholder="Answer option D" required />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="flex justify-end space-x-4">
            <button type="button" @click="router.go(-1)"
              class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
              Cancel
            </button>
            <button type="submit" :disabled="!isFormValid || isSubmitting"
              class="px-6 py-2 bg-sky-500 hover:bg-sky-600 disabled:bg-gray-400 text-white rounded-md font-medium">
              {{ isSubmitting ? 'Creating...' : 'Create Lesson' }}
            </button>
          </div>
        </form>
      </div>
    </template>
  </DashboardTemplate>
</template>
