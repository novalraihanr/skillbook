import { createRouter, createWebHistory } from "vue-router";
import DashboardView from "@/views/DashboardView.vue";
import { check } from '../auth.js'
import { useUserStore } from "../../stores/userStore.js";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [

    {
      path: "/test",
      name: "test",
      component: () => import("../components/student/LessonsPage.vue"),
    },
    {
      path: "/",
      name: "dashboard",
      component: DashboardView,
    },
    {
      path: "/login",
      name: "login",
      component: () => import("../views/LoginView.vue"),
    },
    {
      path: "/register",
      name: "register",
      component: () => import("../views/RegisterView.vue"),
    },
    {
      path: "/student",
      name: "student",
      component: () => import("../views/MainDashboardView.vue"),
      children: [
        {
          path: "",
          component: () => import("../components/student/StudentDashboard.vue"),
        },
        {
          path: "discover",
          component: () => import("../components/student/StudentDiscover.vue"),
        },
        {
          path: "courses",
          component: () => import("../components/student/StudentCourse.vue"),
        },
        {
          path: "courses/:course",
          component: () => import("../components/student/CourseDetail.vue"),
          props: true
        },
        {
          path: "courses/:course/lessons/:lesson/page/:page",
          component: () => import("../components/student/LessonsPage.vue"),
        },
        {
          path: "courses/:course/lessons/:lesson/quiz/:page",
          component: () => import("../components/student/QuizPage.vue"),
        },
        {
          path: "courses/:course/lessons/:lesson/quiz/result",
          component: () => import("../components/student/QuizResult.vue"),
        },
        {
          path: "ranking",
          component: () => import("../components/student/StudentRanking.vue"),
        },
        {
          path: "profile",
          // component: () => import("../views/StudentProfileView.vue"),
        },
      ],
    },
    {
      path: "/teacher",
      name: "teacher",
      component: () => import("../views/MainDashboardView.vue"),
      children: [
        {
          path: "",
          component: () => import("../components/teacher/TeacherDashboard.vue"),
        },
        {
          path: "courses",
          component: () => import("../components/student/StudentDiscover.vue"),
        },
        {
          path: "courses/:course",
          component: () => import("../components/student/CourseDetail.vue"),
        },
        {
          path: "courses/addcourse",
          component: () => import("../components/teacher/TeacherAddCourse.vue"),
        },
        {
          path: "courses/:course/lesson/addlesson",
          component: () => import("../components/teacher/TeacherAddLessons.vue"),
        },
      ]
    }
  ],
});

router.beforeEach(async (to, from) => {
  const userStore = useUserStore()
  const user = await check();
  if (!user && to.name !== 'login' && to.name !== 'dashboard' && to.name !== 'register') {
    return { name: 'login' }
  }

  if (user !== null) {
    if (userStore !== null) {
      userStore.setUser(user)
    }

    if (user.role === 'student' && to.name === 'teacher') {
      return { name: 'student' }
    }
  }

  return true

})

export default router;
