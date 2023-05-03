import {
    createRouter,
    createWebHistory,
  } from 'vue-router';
//   import appAxios from '../utils/appAxios';

  const routes = [
    {
      path: '/login',
      name: 'Login',
      component: () => import('../views/auth/Login.vue'),
    },
    {
      path: '/register',
      name: 'Register',
      component: () => import('../views/auth/Register.vue'),
    },
    {
      path: '/',
      name: 'Anasayfa',
      component: () => import('../views/Index.vue'),
    },
    {
      path: '/blog',
      name: 'Bloglar',
      component: () => import('../views/blog/Index.vue'),
    },
    {
      path: '/blog/user/:user_id',
      name: 'Bloglar',
      component: () => import('../views/blog/Index.vue'),
    },

    {
      path: '/blog/store',
      name: 'Blog Ekleme',
      component: () => import('../views/blog/Store.vue'),
    },
    {
      path: '/blog/edit/:id',
      name: 'Blog Düzenleme',
      component: () => import('../views/blog/Edit.vue'),
    },{
      path: '/blog/:id',
      name: 'Blog Okuma',
      component: () => import('../views/blog/Show.vue'),
    },
  ];

  const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,
  });
  router.beforeEach((to, from, next) => {
    if (to.name) {
      document.title = to.name
    }
    next()
  })
  export default router;
