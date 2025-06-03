import { createRouter, createWebHistory } from "vue-router";
import DashboardView from "@/views/DashboardView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [

    {
      path: "/test",
      name: "test",
      component: () => import("../components/student/RankingComponent.vue"),
    },
    {
      path: "/",
      name: "dashboard",
      component: DashboardView,
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
      component: () => import("../views/StudentDashboardView.vue"),
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
          path: "courses/:id",
          component: () => import("../components/student/CourseDetail.vue")
        },
        {
          path: "ranking",
          // component: () => import("../views/StudentRankingView.vue"),
        },
        {
          path: "profile",
          // component: () => import("../views/StudentProfileView.vue"),
        },
      ],
    },
    // {
    //   path: "/about",
    //   name: "about",
    //   // route level code-splitting
    //   // this generates a separate chunk (About.[hash].js) for this route
    //   // which is lazy-loaded when the route is visited.
    //   component: () => import("../views/AboutView.vue"),
    // },
  ],
});

export default router;
