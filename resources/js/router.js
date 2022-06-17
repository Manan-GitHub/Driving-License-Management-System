import Router from 'vue-router'
import Vue from 'vue'
Vue.use(Router)

import Home from './components/pages/Home.vue'
import Category from './components/pages/Category.vue'
import Rules from './components/pages/Rules.vue'
import Login from './components/pages/Login.vue'
import MyLicense from './components/pages/MyLicense.vue'


// ----------------Admin Routes--------------------------

import User from './components/pages/admin/User.vue'
import Feedback from './components/pages/admin/Feedback.vue'
import License from './components/pages/admin/License.vue'
import Application from './components/pages/admin/Application.vue'
import ProcessedApplication from './components/pages/admin/ProcessedApplication.vue'
import Image from './components/pages/admin/Image.vue'

const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },

    {
        name: 'categories',
        path: '/categories',
        component: Category
    },

    {
        name: 'rules',
        path: '/rules',
        component: Rules
    },

    {
        name: 'login',
        path: '/login',
        component: Login
    },

    {
        name: 'users',
        path: '/users',
        component: User
    },

    {
        name: 'feedbacks',
        path: '/feedbacks',
        component: Feedback
    },

    {
        name: 'applications',
        path: '/applications',
        component: Application
    },

    {
        name: 'processed-applications',
        path: '/processed-applications',
        component: ProcessedApplication
    },

    {
        name: 'my-license',
        path: '/my-license',
        component: MyLicense
    },

    {
        path: '/image',
        name: 'image',
        component: Image,
        props: true
    },

    {
        path: '/licenses',
        name: 'licenses',
        component: License,
    },


]

export default new Router({
    mode: 'history',
    routes

})