<template>
    <article class="content-block-profil content-block container-fluid">
        <div class="row">
            <h3>TEORIKURSER ALLE REGISTRERINGER</h3>
            <hr>
        </div>

        <div class="row border-row">
            <div class="col-md-2 block-value">
                <p><strong>Dato</strong></p>
            </div>
            <div class="col-md-3 block-value">
                <p><strong>Navn</strong></p>
            </div>
            <div class="col-md-1 block-value text-center">
                <p><strong>Kode</strong></p>
            </div>
            <div class="col-md-1 block-value text-center">
                <p><strong>Timer</strong></p>
            </div>
            <div class="col-md-2 block-value  text-center">
                <p><strong>Kursusindhold</strong></p>
            </div>
            <div class="col-md-1 block-value  text-center">
                <p><strong>Redigér</strong></p>
            </div>
            <div class="col-md-1 block-value text-center">
                <p><strong>Slet</strong></p> 
            </div>
        </div>

        <div class="row info-wrapper" v-for="c in courses" v-if="courses.length">
            <div class="col-md-2 list-wrapper">
                <p>{{ c.date ? JSON.parse(c.date).join(", ") : "" }}</p>
            </div>
            <div class="col-md-3 list-wrapper">
                <p>{{ c.name }}</p>
            </div>
            <div class="col-md-1 list-wrapper text-center">
                <p>{{ c.code }}</p>
            </div>
            <div class="col-md-1 list-wrapper text-center">
                <p>{{ c.timer }}</p>
            </div>
            <div class="col-md-2 text-center">
              <div class="picture-wrapper text-center">
                 <router-link :to="{ name : 'course.profile', params: { idCourse: c.course.user_id }}" > 
                    <img class="edit-pic" src="/image/link.png" alt="link" />
                </router-link>
              </div>
            </div>
            <div class="col-md-1 text-center">
              <div class="picture-wrapper text-center">
                 <router-link :to="{ name: 'edit.edit_register_course', params: { idCourse: c.id }}" > 
                    <img class="edit-pic" src="/image/edit-ico.png" alt="edit" />
                </router-link>
              </div>
            </div>
            <div class="col-md-1 text-center">
                <div class="picture-wrapper text-center" @click="deleteRegisterCourse(c.id)">
                    <img src="/image/vector-smart-trash.png" alt="delete" class="trash">
                </div>
            </div>
        </div>

        <div class="row" v-if=" ! courses.length">
            <h5>Empty list ! </h5>
        </div>
        
    </article>
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
            this.getAllRegisterCourses();
        },
        methods : {
            deleteRegisterCourse(id)
            {
                let mainInfo = this;
                    axios.post('/deleteRegisterCourse', {id : id})
                        .then(function (response) {
                           mainInfo.getAllRegisterCourses();
                        });
            },
            getAllRegisterCourses(){
                let mainInfo = this;
                    axios.get('/getAllRegisterCourses')
                        .then(function (response) {
                            mainInfo.courses = response.data; 
                        });
            },
            editCourse(){
                // edit
            }
        }
    }
</script>