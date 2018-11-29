<template>
    <article class="content-block-profil content-block container-fluid">
        <div class="row border-row">
            <div class="col-md-6">
                <h3>KURSUS PROFILSIDE</h3>
            </div>
            <div class="col-md-6">
                <div class="btn-wrapper pull-right">
                    <button type="submit" @click="goToRegisterCourse" data-toggle="tooltip" data-placement="top"
                            title="Registrer kursus" class="btn btn-primary supervisor-btn btn-register">
                                Registrer kursus
                            </button>
                    
                    <button type="submit" @click="addToFavoriteList" data-toggle="tooltip" data-placement="top"
                            title="Gem til mine favoritter"
                            class="btn btn-primary supervisor-btn"><img class="download" src="/image/favorit.png"
                                                                        alt="favorit"></button>
                    <button type="submit" @click="redirectBack" class="btn btn-primary text-btn">
                        <img class="download" src="/image/left-arrow.png" alt="favorit" />
                        tilbage
                    </button>
                </div>
            </div>
        </div>
        <div class="row bio-row">
            <div class="col-md-6" v-if="course.user.full_info_about_user.version != 'free'">
                <div class="img-wrapper">
                    <img :src="course && course.user && course.user.full_info_about_user && course.user.full_info_about_user.avatar_path || '/image/admin-icon.png' " style="width: 691px;height: 403px" class="img-responsive" alt="avatar" />
                </div>
            </div>
            <div class="col-md-6 data-info">
                <div class="bio-info-pro">

                    <h5> {{  course && course.course_main_info && course.course_main_info.course_name }}</h5>
                    <p>
                        <b>Kursusnummer:</b> {{ course && course.course_main_info && course.course_main_info.course_number }}
                    </p>
                    <p>
                        <b>Modul:</b>
                        <p v-if="course.course_modules && course.course_modules.groups && course.course_modules.groups.groups && course.course_modules.groups.groups.groups">
                           {{ course.course_modules.groups.groups.groups.name }}
                        </p>
                    </p>
                    <p>
                        <span v-show=" ! toggle_date" ><b>Kursusdato: </b> {{ course && course.course_main_info && course.course_main_info.course_date ? sort(course.course_main_info.course_date, "range").join(" - ") : "" }}</span>
                        <span v-show="toggle_date" ><b>Kursusdato: </b> {{ course && course.course_main_info && course.course_main_info.course_date ? sort(course.course_main_info.course_date, "min").join(", ") : "" }}</span>
                        <span v-show=" ! toggle_date" @click="toggle_date ^= 1">
                            <a href="javascript:;">Vis alle datoer</a>
                        </span>
                        <span v-show="toggle_date" @click="toggle_date ^= 1">
                            <a href="javascript:;">
                                Vis kun start- og slutdato
                            </a>
                        </span>
                    </p>
                    <p>
                        <b>Timer: </b> {{ course && course.course_main_info && course.course_main_info.course_hours }}
                   </p>
                    <p v-show="course && course.course_main_info && course.course_main_info.course_approved">
                        <b>Godkendt af DP: </b> {{ course && course.course_main_info && course.course_main_info.course_approved ? 'ja' : 'nej' }}
                    </p>
                    <p>
                        <b>Til specialistuddannelse: </b> {{ course && course.user && course.user.full_info_about_user && course.user.full_info_about_user.special_preparation && JSON.parse(course.user.full_info_about_user.special_preparation) }}
                    </p>
                    <p>
                         <b>Undervisere</b> <span v-if="course && course.course_teachers" v-for="t in course.course_teachers">{{ t.teacher_name }}, </span><span v-if=" ! course.course_teachers.length">--</span>
                    </p>

                </div>
            </div>
        </div>

        <div class="row address-wrapper">
            <div class="col-md-6">
                <address>
                    <ul class="address-list">
                        <li>
                            <strong>Klinikadresse:</strong>
                        </li>
                        <li>
                            <span >{{ course && course.course_address && course.course_address.address_name }}</span><br />
                            <span >{{ course && course.course_address && course.course_address.road_name }}</span><br />
                            <span >{{ course && course.course_address && course.course_address.post_number }}</span><br />
                            <span >{{ course && course.course_address && course.course_address.by_address }}</span><br /> 
                        </li>
                    </ul>
                </address>
            </div>

            <div class="col-md-6">
                <address>
                    <ul class="contact-list">
                        <li>
                            <strong>Kontaktes på:</strong>
                        </li>
                        <li>
                            email: {{  course &&  course.user && course.user.email }}
                        </li>
                        <li>
                            tlf: {{ course.user && course.user.full_info_about_user && course.user.full_info_about_user.phone }}
                        </li>
                    </ul>
                </address>
            </div>
        </div>

        <div class="row address-wrapper" v-if="course.user.full_info_about_user.version != 'free'">
            <div class="col-md-6 text-fritekst">
                <div class="link-wrapper">
                    <ul class="link-list">
                        <li>
                            <strong>Hjemmeside:</strong>
                        </li>
                        <a  target="_blank" :href="course.user && course.user.full_info_about_user && course.user.full_info_about_user.website">
                            {{ course.user && course.user.full_info_about_user && course.user.full_info_about_user.website }}
                        </a>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="inform-wrapper">
                    <p>
                        <strong>Undervisere:</strong><br>
                        <ul>
                            <li v-for="t in course.course_teachers">{{ t.teacher_name }}</li>
                        </ul>
                    </p>
                </div>
            </div>
        </div>

        <div class="row address-wrapper" v-if="course.user.full_info_about_user.version != 'free'">
            <div class="col-md-6">
                <address>
                    <div class="course-block">
                        <div class="header-block">
                            <strong>Program:</strong>
                        </div>
                        <div class="text-right">
                            <div  v-for="f in course.course_program">
                               <a :href="f.path_to_file" target="_blank">
                                    <img src="/image/list-ico.png" alt="avatar" />
                                </a>
                            </div>
                        </div>
                    </div>
                </address>
            </div>

            <div class="col-md-6" >
                <address>
                    <div class="course-block">
                        <div class="header-block">
                            <strong>Pris:</strong>
                        </div>
                        <p class="text-right">{{ course && course.course_main_info &&course.course_main_info.course_price }} DDK</p>
                    </div>
                </address>
            </div>
        </div>

        <div class="row address-wrapper">
            <div class="col-md-12">
                <p>
                    <strong>Fritekst / præsentation:</strong>
                    <p class="pre-style"  v-if="course.user.full_info_about_user.version != 'free'" v-html="course.user.full_info_about_user.presentation"></p>
                    <p class="pre-style"  v-if="course.user.full_info_about_user.version == 'free'" v-html="course.user.full_info_about_user.presentation.slice(0, 350) + (course.user.full_info_about_user.presentation.length > 350 ? ' ...' : '')"></p>
                </p>
            </div>
        </div>
        
        <div class="row builder-row" v-if="course.user.full_info_about_user.version != 'free'">
            <div class="col-md-1">
                <p>BILLEDER</p>
            </div>

            <div class="col-md-11">
                <div class="row">
                   
                   <div  class="col-md-2" v-for="(picture, index) in course.course_pictures" >
                        <div class="item-box text-center" @click="openPicture(picture)">
                            <div class="avatar-section">
                                <img class="managingPictures" :src="picture.path_to_file" alt="avatar" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       <div class="row builder-row" v-if="course.user.full_info_about_user.version != 'free'">
            <div class="col-md-1">
                <p>VIDEO</p>
            </div>
            <div  class="col-md-11">
                <div class="row">
                    
                    <div class="col-md-3" v-for="(video,index) in course.course_videos">
                        <div class="item-box text-center">
                            <div class="avatar-section">
                                
                                <video v-if=" ! (video.path_to_file.indexOf('youtube') + 1)" muted class="managingPictures" controls>
                                    <source :src="video.path_to_file" type="video/mp4">
                                </video>

                                <iframe muted v-if="video.path_to_file.indexOf('youtube') + 1" class="managingPictures" :src=" 'https://www.youtube.com/embed/' + video.path_to_file.replace('https://www.youtube.com/watch?v=', '').split('&').shift()"></iframe>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="modal fade" id="pictureModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body text-center">
                    <img class="img-slider-popUp img-responsive" style="height:auto; with: auto !important" v-if="picture && picture.path_to_file" :src="picture.path_to_file" alt="picture">
                </div>
                 
                </div>
            </div>
        </div>

    </article>
</template>

<script>
    
    import Modal from 'modal-vue';
    export default {
        data()
        {
            return {
                showModal : false,
                course : {},
                play : 0,
                toggle_date : 0,
                picture : false,
            }
        },
        created : function () 
        {
            let data = this;
            axios.post('/getCourseInformation', {'courseOwnerId' : this.$route.params.idCourse})
                    .then(function (response) {
                       data.course = response.data;
                    })
        },
        components: {
            Modal
        },
        methods: {
            closePictureModal () {
                let mainData = this;
                mainData.showModal = false;
            },
            openPicture (img) {
                // let mainData = this;
                this.picture = img;
                // mainData.showModal = true;
                // console.log(mainData.showModal, mainData.picture);
                
                $("#pictureModal").modal("show");

            },
            sort(list, type)
            {
                switch (type) {
                    case "range" : {
                        var sort = [],
                            min = "",
                            max = "",
                            tmp = [];

                        for(var i in list)
                        {
                            var part = list[i].split('-');
                            sort.push( new Date(part.shift(), part.shift(), part.shift(), "0", "0", "0") / 1000 );
                        }

                        min = list[sort.indexOf(Math.min.apply(Math, sort))];
                        max = list[sort.indexOf(Math.max.apply(Math, sort))];
                        return [min, max];
                        break;
                    }

                    case "min" : {

                        return list.sort(function(a, b){
                            a = a.split('-');
                            a = new Date(a.shift(), a.shift(), a.shift(), "0", "0", "0") / 1000;

                            b = b.split('-');
                            b = new Date(b.shift(), b.shift(), b.shift(), "0", "0", "0") / 1000;
                            return a - b;
                        });
                        break;
                    }
                    
                    default : break;
                }
            },
            redirectBack()
            {
                this.$router.back();
            },
            addToFavoriteList()
            {
                let data = this;
                axios.post('/addToFavoriteListPsychologist', {'courseId' : this.$route.params.idCourse})
                        .then(function (response) {
                            swal(response.data.title, response.data.message, response.data.status);
                        })
            },
            goToRegisterCourse()
            {
                var idCourse =  this.$route.params.idCourse;
                this.$router.push({ name: 'register.course', params: { idCourse } });
            }
        }
    }

</script>