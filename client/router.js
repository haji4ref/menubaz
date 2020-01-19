import Vue from 'vue'
import Router from 'vue-router'
import { scrollBehavior } from '~/utils'

Vue.use(Router)

const page = path => () => import(`~/pages/${path}`).then(m => m.default || m)

const routes = [
  { path: '/', name: 'welcome', component: page('welcome.vue') },

  { path: '/login', name: 'login', component: page('auth/login.vue') },
  {
    path: '/verification',
    name: 'verification',
    component: page('auth/verification.vue')
  },
  {
    path: '/register',
    name: 'register',
    component: page('auth/register.vue')
  },
  {
    path: '/password/reset',
    name: 'password.request',
    component: page('auth/password/email.vue')
  },
  {
    path: '/password/reset/:token',
    name: 'password.reset',
    component: page('auth/password/reset.vue')
  },
  {
    path: '/email/verify/:id',
    name: 'verification.verify',
    component: page('auth/verification/verify.vue')
  },
  {
    path: '/email/resend',
    name: 'verification.resend',
    component: page('auth/verification/resend.vue')
  },

  // dashboard
  {
    path: '/dashboard',
    name: 'dashboard',
    component: page('dashboard/index.vue')
  },
  { path: '/telegram', name: 'telegram', component: page('telegram.vue') },

  // roles
  {
    path: '/dashboard/roles',
    name: 'roles-index',
    component: page('dashboard/roles/index.vue')
  },
  {
    path: '/dashboard/roles/create',
    name: 'roles-create',
    component: page('dashboard/roles/create.vue')
  },

  // comments
  {
    path: '/dashboard/comments',
    name: 'comments-index',
    component: page('dashboard/comments/index.vue')
  },

  // menus
  {
    path: '/dashboard/menus',
    name: 'menus-index',
    component: page('dashboard/menus/index.vue')
  },

  // menu_categories
  {
    path: '/dashboard/menu_categories/:id/foods',
    name: 'foods-index',
    component: page('dashboard/menu_categories/foods/index.vue')
  },

  // bots
  {
    path: '/dashboard/bots',
    name: 'bots-index',
    component: page('dashboard/bots/index.vue')
  },
  {
    path: '/dashboard/bots/manage/:id',
    name: 'bot-manage',
    component: page('dashboard/bots/manage.vue')
  },

  { path: '/home', name: 'home', component: page('home.vue') },
  {
    path: '/settings',
    component: page('settings/index.vue'),
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      {
        path: 'profile',
        name: 'settings.profile',
        component: page('settings/profile.vue')
      },
      {
        path: 'password',
        name: 'settings.password',
        component: page('settings/password.vue')
      }
    ]
  }
]

export function createRouter () {
  return new Router({
    routes,
    scrollBehavior,
    mode: 'history'
  })
}
