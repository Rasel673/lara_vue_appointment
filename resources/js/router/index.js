import { createRouter,createWebHistory } from "vue-router";

import Dashboard from '../components/dashboard.vue'
import Error from '../components/error.vue'
import AppointmentList from '../pages/appointments/listAppointments.vue'
import UsersList  from '../pages/users/listUsers.vue'
import UpdateSettings from '../pages/settings/updateSettings.vue'
import UpdateProfile from '../pages/users/updateProfile.vue'
import AddAppointment from '../pages/appointments/addAppointment.vue'
import Login from '../pages/auth/login.vue';
import Todo from '../pages/todo/todoList.vue';


const routes=[


    {
        path:'/login',
        name:'login',
        component:Login

    },

    {
        path:'/admin/dasboard',
        name:'home',
        component:Dashboard

    },

    {
        path:'/:pathMatch(.*)*',
        name:'error',
        component:Error

    },


    {
        path:'/admin/users',
        name:'user.list',
        component:UsersList

    },

    {
        path:'/admin/update_profile',
        name:'update.profile',
        component:UpdateProfile

    },



    {
        path:'/admin/appoinment',
        name:'appointment.list',
        component:AppointmentList

    },


    {
        path:'/admin/appoinment/create',
        name:'appointment.create',
        component:AddAppointment

    },


    {
        path:'/admin/appoinment/:id/edit',
        name:'appointment.edit',
        component:AddAppointment

    },


    {
        path:'/admin/update_settings',
        name:'update.settings',
        component:UpdateSettings

    },

    {
        path:'/admin/todo',
        name:'todo',
        component:Todo

    },




]

const router=createRouter({
history:createWebHistory(),
routes

})


export default router