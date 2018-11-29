<template>
    <div class="container-fluid">
        <div class="row headline-row">
            <div class="col-md-12 headline-block">
                <h3>Mine Kurser</h3>
                <hr class="supline">
            </div>
            <article class="content-block">
                <div v-show=" ! courses.length">
                    <h1>Tom liste kurser.</h1>
                </div>
                <div class="scroll-box" v-show="courses.length">
                    <div class="item-box" v-for="c in courses">
                        <div class="avatar-section">
                            <div v-if="c.course.avatar_path != null">
                                <img :src="c.course.avatar_path" alt="avatar" />
                            </div>
                            <div v-else>
                                <img src="/image/avatar-placeholder.png"
                                     alt="avatar">
                            </div>
                        </div>
                        <div class="text-section">
                            <ul>
                                <li class="bold">{{ c.course.course_name }}</li>
                                <li>Teorikursus</li>
                            </ul>
                            <div class="button-section">
                                <router-link :to="{ name: 'course.profile', params: { idCourse: c.course.user_id }}" class="btn btn-primary-outline "> 
                                    se profil
                                </router-link>
                                 <button @click="removeMine(c.course.id)" type="button" class="btn btn-default tool-btn" data-toggle="tooltip" data-placement="top" title="fjern fra liste">
                                <img class="trash" src="/image/vector-smart-trash.png" alt="delete">
                            </button>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</template>

<script>
    export default {
        data()
        {
            return {
                courses : []
            }
        },
        created : function () {
            this.getMineListCourses();
        },
        methods : {
            getMineListCourses()
            {
                let mainInfo = this;
                axios.get('/getMineListCourses')
                        .then(function (response) {
                            mainInfo.courses = response.data; 
                        });
            },
            removeMine(course_id)
            {
                let mainInfo = this;
                axios.post('/removeMine', {'course_id' : course_id})
                        .then(function (response) {
                            mainInfo.getMineListCourses();
                        });
            }
        }
    }
</script>
