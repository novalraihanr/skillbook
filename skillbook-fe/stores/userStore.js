import { defineStore } from "pinia";

export const useUserStore = defineStore('user', {
  state: () => ({
    user: null,
  }),
  actions: {
    setUser(userData) {
      this.user = userData
    },
    cleanUser() {
      this.user = null
    }
  },
  persist: true,
})

export const useQuizStore = defineStore('quiz', {
  // STATE: Where you define the data
  state: () => ({
    score: {},
  }),

  actions: {
    initializeLesson(lessonId) {
      if (!this.score[lessonId]) {
        this.score[lessonId] = { score: 0 }
      }
    },

    incrementScore(lessonId, addedscore) {
      this.score[lessonId].score += addedscore
      console.log(this.score[lessonId].score)
    },

    getScore(lessonId) {
      return this.score[lessonId] || { score: 0 }
    },

    clearLesson(lessonId) {
      delete this.score[lessonId]
    }
  },

  persist: {
    key: 'quiz-scores',
    storage: sessionStorage
  }
});
