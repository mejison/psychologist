<template>
    <div class="container-fluid">
        <div class="row headline-row">
            <div class="col-md-12 headline-block">
                <h3>Kurser Favoritliste</h3>
                <hr class="supline">
            </div>
            <article class="content-block">
                <div v-show=" ! favorits.length">
                    <h1>Tom liste favorit.</h1>
                </div>
                <div class="scroll-box" v-show="favorits.length">
                    <div class="item-box" v-for="f in favorits">
                        <div class="like-section">
                            <a href="javascript:;">
                                <img class="download" src="/image/favorit.png" alt="favorit">
                            </a>
                        </div>
                        <div class="avatar-section">
                            <img src="/image/avatar-placeholder.png" alt="avatar">
                        </div>
                        <div class="text-section">
                            <ul>
                                <li class="bold">{{ f.course.course_name }}</li>
                            </ul>
                        </div>
                        <div class="button-section">
                             <router-link :to="{ name: 'course.profile', params: { idCourse: f.course.user_id }}" class="btn btn-primary-outline "> 
                                se profil
                            </router-link>
                            <button @click="removeFavorite(f.course.id)" type="button" class="btn btn-default tool-btn" data-toggle="tooltip" data-placement="top" title="fjern fra liste">
                                <img class="trash" src="/image/vector-smart-trash.png" alt="delete">
                            </button>
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
                favorits : []
            }
        },
        created : function () {
            this.getFavoritsListCourses();
        },
        methods : {
            getFavoritsListCourses()
            {
                let mainInfo = this;
                axios.get('/getFavoritsListCourses')
                        .then(function (response) {
                            mainInfo.favorits = response.data; 
                        });
            },
            removeFavorite(course_id)
            {
                let mainInfo = this;
                axios.post('/removeFavorite', {'course_id' : course_id})
                        .then(function (response) {
                            mainInfo.getFavoritsListCourses();
                        });
            }
        }
    }
</script>
