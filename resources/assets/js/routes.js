import VueRouter from 'vue-router';

let routes = [
    //application routes
    {
        path: '/',
        redirect: '/dashboard'
    },
    {
        path: '/dashboard',
        component: require('./views/ApplicationViews/Dashboard.vue')
    },
    {
        path: '/profile',
        component: require('./views/ApplicationViews/Profile.vue')
    }, {
        path: '/parksisInfo',
        component: require('./views/ApplicationViews/PraksisInfo.vue')
    },
    // supervision routes
    {
        path: '/findSupervisor',
        component: require('./views/SupervisorsViews/FindSupervisor.vue')
    },
    {
        path: '/registerSupervision',
        name: 'register.supervisors',
        component: require('./views/SupervisorsViews/RegisterSupervision.vue')
    },
    {
        path: '/oversigtSupervision',
        name: 'oversigt.supervisors',
        component: require('./views/SupervisorsViews/OversigtSupervision.vue')
    },
    {
        path: '/registreringer',
        component: require('./views/SupervisorsViews/RegistreringerSupervision.vue')
    },
    {
        path: '/updateSupervision/:idSupervision/:role',
        name: 'supervision.update',
        component: require('./views/SupervisorsViews//UpdateSupervision.vue')
    },
    {
        path: '/mineSupervisorer',
        name: 'mine.supervisors',
        component: require('./views/SupervisorsViews/MineSupervisorer.vue')
    },
    {
        path: '/favoritliste',
        component: require('./views/SupervisorsViews/Favoritliste.vue')
    },

    {
        path: '/profilesideSupervisior/:idSupervision',
        name: 'supervision.profile',
        component: require('./views/SupervisorsViews/SupervisorProfileside.vue')
    },
    {
        path: '/profilesideSupervisiorPsychology/:idSupervision',
        name: 'supervision.profile.psychology',
        component: require('./views/SupervisorsViews/SupervisorPsychologyProfilesideFree.vue')
    },
    {
        path: '/profilesideSupervisiorFree/:idSupervision',
        name: 'supervision.profile.free',
        component: require('./views/SupervisorsViews/SupervisorProfilesideFree.vue')
    },
    {
        path: '/SupervisorProfilesideManagingFree/:idSupervision',
        name: 'supervision.profile.managing.free',
        component: require('./views/SupervisorsViews/SupervisorProfilesideManagingFree.vue')
    },  
    {
        path: '/SupervisorProfilesideManagingPro/:idSupervision',
        name: 'supervision.profile.managing.pro',
        component: require('./views/SupervisorsViews/SupervisiorProfilesideManagingPro.vue')
    },

    //kursus routes
    {
        path: '/CourseOverview/:idCourse', 
        name: 'course.profile',
        component: require('./views/TeorikurserViews/CourseOverview.vue')
    },
    {
        path: '/findKursus',
        component: require('./views/TeorikurserViews/FindKursus.vue')
    },
    {
        path: '/registerKursus/:idCourse?',
        name : 'register.course',
        component: require('./views/TeorikurserViews/RegistrerTeorikursus.vue')
    },
    {
        path: '/favoritlisteKursus',
        component: require('./views/TeorikurserViews/FavoritlisteKursus.vue')
    },
    {
        path: '/oversignKursus',
        component: require('./views/TeorikurserViews/StatusOversigtKursus.vue')
    },
    {
        name: 'registreringerKursus',
        path: '/registreringerKursus',
        component: require('./views/TeorikurserViews/RegistreringerTeorikursus.vue')
    },
    {
        path: '/CourseOrganizerProfilesideManagingFree/:idCourseOrganizer',
        name: 'courseOrganizer.profile.managing.free',
        component: require('./views/TeorikurserViews/Managing/CourseOrganizerProfilesideManagingFree.vue')
    },
    {
        path: '/CourseOrganizerProfilesideManagingPro/:idCourseOrganizer',
        name: 'courseOrganizer.profile.managing.pro',
        component: require('./views/TeorikurserViews/Managing/CourseOrganizerProfilesideManagingPro.vue')
    },
    {
        path: '/mineKursus',
        name: 'mine.courses',
        component: require('./views/TeorikurserViews/MineKursus.vue')
    },
    {
        path: '/editRegisterCourse/:idCourse',
        name: 'edit.edit_register_course',
        component: require('./views/TeorikurserViews/EditRegisterKursus.vue')
    },
    {
        path: '/test',
        component: require('./views/SupervisorsViews/test.vue')
    }
];



export default new VueRouter({
    routes
});