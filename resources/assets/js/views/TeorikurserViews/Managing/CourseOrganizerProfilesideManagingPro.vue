<template>
    <article class="content-block-profil content-block container-fluid">
        <div class="row border-row">
            <div class="col-md-6">
                <h3>KURSUS PROFILSIDE</h3>
            </div>
            <div class="col-md-6">
                <div class="btn-wrapper pull-right">
                    <div class="course-free-wrapper">
                        <p>Kursusudbyder</p>
                    </div>
                    <div class="pro-wrapper">
                        <p>Pro</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row bio-row">
            <div class="col-md-6">
                <div class="img-wrapper pro-wrapper">
                    <!--<img src="/image/admin-icon.png" class="img-responsive" alt="avatar">-->
                    <img :src="user_avatar" class="img-responsive" alt="avatar" style="width: 695px; height: 403px;">
                </div>
                <div v-show="showEditForm">
                    <div class="bio-action">
                        <div class="upload-wrapper">
                            <a class="file-upload pro-upload">
                                <input type="file" class="file-input" @change="uploadUserAvatar">
                                <img src="/image/vector-smart-arrow-up.png" alt="arrow">
                                Upload                           
                            </a>
                        </div>
                        <div class="delete-wrapper text-right">
              <span id="fileDelete" @click="deleteAvatar">
              <img src="/image/vector-smart-trash.png" alt="trash" @click="deleteAvatar">
                  Fjern
              </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 data-info">
                <div class="bio-btn-block text-right">
                    <button href="javascript:;"
                            class="btn btn-primary-outline"
                            @click="showEditPencils">
                        Rediger oplysninger

                    
                    
                    </button>
                </div>
                <div class="bio-info-pro">
                    <h5>{{course_name}}</h5>
                    <p><b>Kursusnummer : </b> {{ course_number }} </p>

                    <p v-show="Arbejds_og_organisationspsykologi||Børnemodulet|| Voksenmodulet ||Det_tværgående||Forsknings_og_formidlingsmodulet ||Specialiseringsmodulerne">
                        <b>Modul:</b></p>
                    <p v-show="Arbejds_og_organisationspsykologi">Arbejds- og organisationspsykologi</p>
                    <p v-show="Børnemodulet">Børnemodulet</p>
                    <p v-show="Voksenmodulet">Voksenmodulet</p>
                    <p v-show="Det_tværgående">Det tværgående modul</p>
                    <p v-show="Forsknings_og_formidlingsmodulet">Forsknings- og formidlingsmodulet</p>
                    <p v-show="Specialiseringsmodulerne">Specialiseringsmodulerne</p>

                    <p>
                        <b>Kursusdato : </b>
                        <date-picker v-show=" ! startTime.time" @change="ChangeCourseDate()" :date="startTime" :option="option"></date-picker>

                        <span v-show="startTime.time && toggle_date">
                            {{ startTime.time ? sort(startTime.time, "range").join(" - ") : "" }}
                        </span>

                        <span v-show="startTime.time && ! toggle_date">
                            {{ startTime.time ? sort(startTime.time, "min").join(", ") : "" }}
                        </span>

                        <span v-show="startTime.time && ! toggle_date" @click="toggle_date ^= 1">
                            <a href="javascript:;">Vis kun start- og slutdato</a>
                        </span>

                        <span v-show="startTime.time && toggle_date" @click="toggle_date ^= 1">
                            <a href="javascript:;">
                                Vis alle datoer
                            </a>
                        </span>
                    </p>
                    
                    <p><b>Timer : </b>{{course_hours}}</p>
                    <p><b>Godkendt af DP :</b>
                        <span>{{ course_approved ? 'ja' : 'nej' }}</span>
                    </p>
                    <p><b>Til specialistuddannelse : </b><span v-for="sp in special_preparation">{{ sp }}, </span></p>


                </div>
                <div v-show="showEditForm">
                    <div class="picture-wrapper edit-block text-center">
                        <a href="javascript:;" @click="editCourseMainInfo()">
                            <img class="edit-pic" src="/image/edit-ico.png" alt="edit">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row address-wrapper">
            <div class="col-md-6">
                <address>
                    <ul class="address-list">
                        <li><strong>Kursusadresse:</strong></li>
                        <li>{{addressName}}</li>
                        <li>{{roadName}}</li>
                        <li>{{postNumber}}</li>
                        <li>{{byAddress}}</li>

                    </ul>
                </address>
                <div v-show="showEditForm">
                    <div class="picture-wrapper edit-block text-center">
                        <a href="javascript:;" @click="editAddress()">
                            <img class="edit-pic" src="/image/edit-ico.png" alt="edit">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="test">
                    <address>
                        <ul class="contact-list">
                            <li><strong>Kontaktes på:</strong></li>
                            <li>email: {{email}}</li>
                            <li>tlf: {{phone}}</li>
                        </ul>
                    </address>
                </div>
                <div v-show="showEditForm">
                    <div class="picture-wrapper edit-block text-center">
                        <a href="javascript:;" @click="editEmailPhone()">
                            <img class="edit-pic" src="/image/edit-ico.png" alt="edit">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row address-wrapper">
            <div class="col-md-6 text-fritekst">
                <div class="link-wrapper">
                    <ul class="link-list">
                        <li><strong>Hjemmeside:</strong></li>
                        <a target="_blank" :href="website">{{website}}</a>
                    </ul>
                    <!--<div class="text-center">-->
                    <!--<a target="_blank" :href="website"> <img class="websitePathImg" :src="websitePath"-->
                    <!--alt="screensite"></a>-->
                    <!--</div>-->
                </div>
                <div v-show="showEditForm">
                    <div class="picture-wrapper edit-ico text-center">
                        <a href="javascript:;" @click="editWebsiteUrl()">
                            <img class="edit-pic" src="/image/edit-ico.png" alt="edit">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="inform-wrapper">
                    <p><strong>Undervisere:</strong><br>
                        <span v-for="teacher in courseTeachers">{{teacher.teacher_name}}
                        <img class="SupervisorSpecialistbevisTrash"
                             src="/image/vector-smart-trash-white.png" alt="delete"
                             @click="deleteCourseTeacher(teacher.id)">
                        <br></span>
                    </p>
                </div>
                <div v-show="showEditForm">
                    <div class="picture-wrapper edit-ico text-center">
                        <a href="javascript:;" @click="editTeachers()">
                            <img class="edit-pic" src="/image/edit-ico.png" alt="edit">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row address-wrapper">
            <div class="col-md-6">
                <address>
                    <div class="course-block">
                        <div class="header-block"><strong>Program</strong></div>
                        <div v-for="course in course_program">
                            <div class="text-right">
                                <a :href="course.path_to_file" target="_blank"><img src="/image/list-ico.png"
                                                                                    alt="avatar"></a>
                                <img v-show="editCourseProgram" class="SupervisorSpecialistbevisTrash"
                                     src="/image/vector-smart-trash.png" alt="delete"
                                     @click="deleteCourseProgram(course.id)">
                            </div>
                        </div>

                        <div class="row" v-show="editCourseProgram">
                            <div class="col-md-6  SupervisorSpecialistbevisFile">
                                <input type="file" id="specialisationFile" @change="uploadFile">
                            </div>

                            <div class="col-md-6 ">
                                <button class="btn btn-success btn-save-course" @click="uploadCourse"
                                        v-show="file!=null">Save

                                
                                
                                </button>
                            </div>
                        </div>
                    </div>

                </address>
                <div v-show="showEditForm">
                    <div class="picture-wrapper edit-block text-center">
                        <a href="javascript:;" @click="editCourseProgramEvent()">
                            <img class="edit-pic" src="/image/edit-ico.png" alt="edit">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="test">
                    <address>
                        <div class="course-block">
                            <div class="header-block"><strong>Pris:</strong></div>
                            <p class="text-right">{{ course_price }} DKK</p>
                        </div>
                    </address>
                </div>
                <div v-show="showEditForm">
                    <div class="picture-wrapper edit-block text-center">
                        <a href="javascript:;" @click="editCoursePrice()">
                            <img class="edit-pic" src="/image/edit-ico.png" alt="edit">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 presentation">
                <p>
                    <!--here-->
                    <strong>Fritekst / præsentation:</strong>
                <p class="pre-style" v-html="presentation_description">{{presentation_description}}</p>
                <vue-editor v-show="showEditPresentationForm" v-model="presentation_description"></vue-editor>
                </p>
                <button v-show="showEditPresentationForm" class="btn btn-primary" @click="editPresentationDescription()">Save</button>
                <div v-show="showEditForm">
                    <div class="picture-wrapper edit-ico text-center">
                        <a href="javascript:;" @click="showEditPresentationForm = !showEditPresentationForm">
                            <img class="edit-pic" src="/image/edit-ico.png" alt="edit">
                        </a>
                    </div>
                    <!--</div>-->
                </div>

            </div>
            <div class="row"></div>
            <div class="row builder-row">
                <div class="col-md-1">
                    <p>BILLEDER</p>
                </div>
                <div v-show="!uploadImages" class="col-md-11">
                    <div class="row">
                        <div class="col-md-2" v-for="(picture,index) in coursePictures">
                            <div class="item-box text-center">
                                <div class="avatar-section">
                                    <img class="managingPictures" :src="picture.path_to_file" alt="avatar"
                                         @click="getPopUpPicture(index)">
                                    <img v-show="showEditForm" class="SupervisorSpecialistbevisTrash"
                                         src="/image/vector-smart-trash.png" alt="delete"
                                         @click="deletePicture(picture.id)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-show="uploadImages">
                    <div class="col-md-8  col-md-offset-1">
                        <dropzone id="uploadImages" v-on:vdropzone-success="finishUploadImages" :options="dropzoneOptions"></dropzone>
                    </div>
                </div>
                <div v-show="showEditForm">
                    <div class="picture-wrapper edit-ico text-center">
                        <a href="javascript:;" @click="showPictureUploadsForm()">
                            <img class="edit-pic" src="/image/edit-ico.png" alt="edit">
                        </a>
                    </div>
                </div>
            </div>
            <div class="row builder-row">
                <div class="col-md-1">
                    <p>VIDEO</p>
                </div>
                <div v-show="!uploadVideos" class="col-md-11">
                    <div class="row">
                        <div class="col-md-2" v-for="(video,index) in courseVideos">
                            <div class="item-box text-center">
                                <div class="avatar-section">
                                    <!--<img @click="getPopUpVideo(index)" class="managingPictures"-->
                                    <!--:src="video.path_to_file" alt="avatar">-->
                                    <!-- <video   poster="/image/videoPlaceholderImg.jpg" class="managingPictures" @click="getPopUpVideo(index)">
                                        <source :src="video.path_to_file" type="video/mp4">
                                    </video>
                                     <div class="text-center">
                                        <span>{{ video.file_name ? video.file_name : 'supervisorVideos' }}</span>
                                    </div>  
                                    <img v-show="showEditForm" class="SupervisorSpecialistbevisTrash"
                                         src="/image/vector-smart-trash.png" alt="delete"
                                         @click="deleteVideo(video.id)"> -->

                                    <video v-if=" ! (video.path_to_file.indexOf('youtube') + 1)" muted class="managingPictures" controls>
                                        <source :src="video.path_to_file" type="video/mp4">
                                    </video>

                                    <iframe muted v-if="video.path_to_file.indexOf('youtube') + 1" class="managingPictures" :src=" 'https://www.youtube.com/embed/' + video.path_to_file.replace('https://www.youtube.com/watch?v=', '').split('&').shift()"></iframe>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-show="uploadVideos">
                    <div class="col-md-8  col-md-offset-1">
                        <dropzone id="uploadVideos"  v-on:vdropzone-success="finishUploadVideos"  :options="dropzoneOptionsVideo"></dropzone>
                        <hr>
                        <div class="form-group">
                            <label for="urlVideo">Youtube link:</label>
                            <input v-model="urlVideo" type="text" placeholder="Indsæt link til Youtube-video her" class="form-control" id="urlVideo" />
                            <label for="nameVideo">Name:</label>
                            <input v-model="nameVideo" type="text" placeholder="Name" class="form-control" id="nameVideo" />
                        </div>
                        <div class="form-group" v-show="urlVideo != '' || nameVideo != ''">
                            <button @click="submitUrlVideo()" type="submit" class="btn btn-primary">Save</button>
                            <button @click="cancelUrlVideo()" type="submit" class="btn btn-danger">Cancel</button>
                        </div>
                    </div>
                </div>
                <div v-show="showEditForm">
                    <div class="picture-wrapper edit-ico text-center">
                        <a href="javascript:;" @click="showVideosUploadsForm()">
                            <img class="edit-pic" src="/image/edit-ico.png" alt="edit">
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <modal :showModal="showModalImage" :closeAction="closeModalImage">
            <div slot="body" class="text-center">
                <slider animation="fade" :auto="false" :indicators="false" :init-index="startSlidePicture">
                    <slider-item v-for="(picture, index) in coursePictures" :key="startSlidePicture">
                        <img class="img-slider-popUp" :src="picture.path_to_file" alt="picture">
                    </slider-item>
                </slider>
            </div>
        </modal>


        <modal :showModal="showModalVideo" :closeAction="closeModalVideo">
            <div slot="body" class="text-center">
                <slider animation="fade" :auto="false" :indicators="false" :control-btn="center"
                        :init-index="startSlideVideo">
                    <slider-item v-for="(video, index) in courseVideos" :key="startSlideVideo">
                        <div v-if="checkYoutube(video.path_to_file)">
                            <video width="568" height="300" controls class="videoId">
                                <source :src="video.path_to_file" type="video/mp4">
                            </video>
                        </div>
                        <div v-else>
                            <div v-html="getYoutubeVideo(video.path_to_file)"></div>
                        </div>

                    </slider-item>
                </slider>
            </div>
        </modal>

    </article>
</template>

<script>
    import Dropzone from 'nuxt-dropzone';
    import Modal from 'modal-vue';
    import {Slider, SliderItem} from 'vue-easy-slider';
    import Datepicker from 'vue-datepicker';
    import { VueEditor } from 'vue2-editor'



    export default {
        data()
        {
            return { 
                toggle_date : 1,
                dropzoneOptions : {
                    url : "/uploadUserImages"
                },
                dropzoneOptionsVideo : {
                    url : "/uploadUserVideos",
                    maxFilesize : 25
                },
                optionDatepicker : {
                    type: 'day',
                    week: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
                    month: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    format: 'YYYY-MM-DD',
                    placeholder: 'Dato',
                    inputStyle: {
                        'appearance': 'none',
                        'background': 'transparent url("/image/down-arrow.svg") no-repeat',
                        'background-position': 'calc(100% - 20px)',
                        'width': '100%',
                        'height': '42px',
                        'border-radius': '5px',
                        'padding': '0 15px',
                        'font-family': 'Raleway',
                        'border': '1px solid #4ba3b6',
                        'color': '#4ba3b6',
                        'background-color': 'white',
                    },
                    color: {
                        header: '#3b7f8e',
                        headerText: '#000000'
                    },
                    buttons: {
                        ok: 'Ok',
                        cancel: 'Cancel'
                    },
                    overlayOpacity: 0.5,
                    dismissible: true
                },
                lookingKursusOptions: [
                    {text: 'Område som psykologen får at se i sin søgning', value: 'default', disabled : true},
                    {text: 'By: ', disabled: true},
                    {text: '   * Århus', value: 'Århus'},
                    {text: '   * København', value: 'København'},
                    {text: '   * Odense', value: 'Odense'},
                    {text: '   * Ålborg', value: 'Ålborg'},
                    {text: 'Region: ', disabled: true},
                    {text: '   * Nordjylland', value: 'Nordjylland'},
                    {text: '   * Midtjylland', value: 'Midtjylland'},
                    {text: '   * Sønderjylland', value: 'Sønderjylland'},
                    {text: '   * Fyn', value: 'Fyn'},
                    {text: '   * Sjælland', value: 'Sjælland'},
                ],
                courseOwnerId: null,
                course_name: "",
                course_number: "",
                course_date: "",
                course_hours: "",
                course_approved: null,
                course_price: "",
                center: "",
//              course modules block
                Arbejds_og_organisationspsykologi: false,
                Børnemodulet: false,
                Voksenmodulet: false,
                Det_tværgående: false,
                Forsknings_og_formidlingsmodulet: false,
                Specialiseringsmodulerne: false,

                email: "",
                phone: "",
                special_preparation: "",
                presentation_description: "",
                showEditForm: false,
                user_avatar: '',
                website: '',
                websitePath: '',

                addressName: "",
                roadName: "",
                postNumber: "",
                byAddress: "",
                byAddress2: "",

                course_program: [],
                editCourseProgram: false,
                file: null,
                special_preparation_selected: 'default',
                options: [
                    {text: 'Vælg specialistuddannelse', value: 'default'},
                    {text: '', value: 0},
                    {text: 'Børnepsykologi: ', value: 0},
                    {text: '   * Sundhedspsykologi med børn', value: 'Sundhedspsykologi med børn'},
                    {text: '   * Psykoterapi med børn', value: 'Psykoterapi med børn'},
                    {text: '   * Klinisk børnepsykologi', value: 'Klinisk børnepsykologi'},
                    {text: '   * Klinisk børneneuropsykologi', value: 'Klinisk børneneuropsykologi'},
                    {text: '   * Pædagogisk psykologi', value: 'Pædagogisk psykologi'},
                    {text: '', value: 0},
                    {text: 'Voksenpsykologi: ', value: 0},
                    {text: '   * Specialist i psykotraumatologi', value: 'Specialist i psykotraumatologi'},
                    {text: '   * Sundhedspsykologi med voksne', value: 'Sundhedspsykologi med voksne'},
                    {text: '   * Psykoterapi med voksne', value: 'Psykoterapi med voksne'},
                    {text: '   * Psykopatologi', value: 'Psykopatologi'},
                    {text: '   * Klinisk Neuropsykologi', value: ' Klinisk Neuropsykologi'},
                    {text: '   * Gerontopsykologi', value: 'Gerontopsykologi'},
                    {text: '', value: 0},
                    {text: 'Arbejds- og organisationspsykologi: ', value: 0},
                    {text: '   * Arbejds- og organisationspsykologi', value: 'Arbejds- og organisationspsykologi'},
                ],


                token: '',
                uploadImages: false,
                uploadVideos: false,
                
                showModalImage: false,
                startSlidePicture: null,
                showModalVideo: false,
                startSlideVideo: null,
                urlVideo: '',
                nameVideo : '',

                coursePictures: [],
                courseVideos: [],
                courseTeachers: [],
                showEditPresentationForm:false,

                startTime: {
                    time: ""
                },

                option: {
                    type: 'multi-day',
                    week: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
                    month: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    format: 'YYYY-MM-DD',
                    placeholder: 'Dato',
                    inputStyle: {
                        'appearance': 'none',
                        'width': '100%',

                        'font-family': 'Raleway',
                        'border': 'none',
                    },
                    color: {
                        header: '#3b7f8e',
                        headerText: '#000000'
                    },
                    buttons: {
                        ok: 'Ok',
                        cancel: 'Cancel'
                    },
                    overlayOpacity: 0.5,
                    dismissible: true
                },
                modules : {},
                sub_modules : {},
                courses : {},
                selected : {
                    module : false,
                    sub_module : false,
                    course : false
                }
            }
        },
        created: function () {
            
           

            let courseOwnerId = (this.$route.params.idCourseOrganizer);
            this.courseOwnerId = courseOwnerId;
            this.get();

            
            let data = this;
            axios.post('/api/getModulesAll')
                .then(function(response) {
                    data.modules = response.data.modules;
                    data.sub_modules = response.data.sub_modules;
                    data.courses = response.data.courses;
                });
            
            $(document).ready(function() {
                $(".dz-message span")
                    .first()
                    .html("Indsat dine billedfiler her for at uploade <ul class='upload-text'><li> - Formater der kan uploades: jpg, png.</li><li> - Max størrelse: 4MB per billede</li></ul>");
                
                $(".dz-message span")
                    .last()
                    .html("Indset dine videofiler her for at uploade <ul class='upload-text'><li> - Formater der kan uploades: mp4.</li><li> - Max størrelse : 25 MB per film");
            });
        }
        ,
        methods: {
            sort(list, type)
            {
                list = JSON.parse(list);
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
            get()
            {

            let data = {
                courseOwnerId: this.courseOwnerId
            };


            let mainData = this;
            axios.post('/getCourseInformation', data)
                .then(function (response) {
                    if (response.data.user.full_info_about_user.version != 'pro') {
                        mainData.$router.push('/CourseOrganizerProfilesideManagingFree/' + mainData.courseOwnerId);
                    }
                    
                    if (response.data.course_main_info != null) {

                        if (response.data.course_main_info.course_id)
                        {
                            mainData.selected.course = response.data.course_main_info.course_id;
                            mainData.selected.sub_module = response.data.course_main_info.sub_module;
                            mainData.selected.module = response.data.course_main_info.module;  
                        }
                        
                        console.log(mainData.selected)

                        mainData.course_name = response.data.course_main_info.course_name;
                        mainData.course_number = response.data.course_main_info.course_number;

                        mainData.startTime.time = response.data.course_main_info.course_date ? JSON.stringify(response.data.course_main_info.course_date) : "";
                       

                        mainData.course_hours = response.data.course_main_info.course_hours;
                        mainData.course_approved = response.data.course_main_info.course_approved;
                        mainData.course_price = response.data.course_main_info.course_price;
                    }

                    if (response.data.course_modules != null) {
                        mainData.Arbejds_og_organisationspsykologi = response.data.course_modules.Arbejds_og_organisationspsykologi;
                        mainData.Børnemodulet = response.data.course_modules.Børnemodulet;
                        mainData.Voksenmodulet = response.data.course_modules.Voksenmodulet;
                        mainData.Det_tværgående = response.data.course_modules.Det_tværgående;
                        mainData.Forsknings_og_formidlingsmodulet = response.data.course_modules.Forsknings_og_formidlingsmodulet;
                        mainData.Specialiseringsmodulerne = response.data.course_modules.Specialiseringsmodulerne;
                    }
                    
                    mainData.special_preparation = JSON.parse(response.data.user.full_info_about_user.educations);
                    
                    mainData.user_avatar = response.data.user.full_info_about_user.avatar_path != null ? response.data.user.full_info_about_user.avatar_path : '/image/admin-icon.png';
                    mainData.presentation_description = response.data.user.full_info_about_user.presentation;
                    mainData.website = response.data.user.full_info_about_user.website;
                    mainData.websitePath = response.data.user.full_info_about_user.pathWebsiteScreen;
                    mainData.email = response.data.user.email;
                    mainData.phone = response.data.user.full_info_about_user.phone;
                    //course info block end

                    //Course program
                    mainData.course_program = response.data.course_program;

                    //Course pictures
                    mainData.coursePictures = response.data.course_pictures;

                    //Course videos
                    mainData.courseVideos = response.data.course_videos;
                    //Course Teachers
                    mainData.courseTeachers = response.data.course_teachers;

                    //supervisor address data block
                    mainData.addressName = response.data.course_address.address_name;
                    mainData.roadName = response.data.course_address.road_name;
                    mainData.postNumber = response.data.course_address.post_number;
                    mainData.byAddress = response.data.course_address.by_address;
                    mainData.byAddress2 = response.data.course_address.by_address2;
                })
                .catch(function (error) {
                    console.log(error);
                });
                    this.token = this.getMetaContentByName('csrf-token');
                    
                    this.dropzoneOptions.headers = { 'X-CSRF-TOKEN' : this.getMetaContentByName('csrf-token') };
                    this.dropzoneOptionsVideo.headers = { 'X-CSRF-TOKEN' : this.getMetaContentByName('csrf-token') };
                  
            },
            today() {
            var today = new Date(),
                dd = today.getDate() < 10 ? "0" + today.getDate() : today.getDate(),
                mm = (today.getMonth() + 1) < 10 ? "0" + (today.getMonth() + 1) : (today.getMonth() + 1),
                yyyy = today.getFullYear();

            return yyyy + '-' + mm + '-' + dd;
            },
            explode(delimiter, string){
                var emptyArray = {0: ''};
                if (arguments.length != 2
                    || typeof arguments[0] == 'undefined'
                    || typeof arguments[1] == 'undefined') {
                    return null;
                }
                if (delimiter === ''
                    || delimiter === false
                    || delimiter === null) {
                    return false;
                }
                if (typeof delimiter == 'function'
                    || typeof delimiter == 'object'
                    || typeof string == 'function'
                    || typeof string == 'object') {
                    return emptyArray;
                }
                if (delimiter === true) {
                    delimiter = '1';
                }
                return string.toString().split(delimiter.toString());
            },
            getYoutubeVideo(url)
            {
                let step1 = this.explode('v=', url);
                let step2 = this.explode('&', step1[1]);
                if(step1[1]!=null){
                    let vedio_id = step2[0];
                    let youTubeVideo = '<iframe id="player" width="640" height="360" src="http://www.youtube.com/embed/' + vedio_id + '?enablejsapi=1&version=3&playerapiid=ytplayer"  allowfullscreen="true" allowscriptaccess="always" frameborder="0"></iframe>';
                    return youTubeVideo;
                }
            }
            ,
            ChangeCourseDate(){
                var mainData = this;
                let data = {
                    user_id: mainData.courseOwnerId,
                    CourseDate: this.startTime.time
                };
                console.log(data);
                axios.patch('/updateCourseDate', data)
                    .then(function (response) {
                        mainData.get();                    
                    })
                    .catch(function (error) {
                        mainData.get();                    
                    });
            },
            
            cancelUrlVideo(){
                this.urlVideo = '';
                this.nameVideo = '';
            },
            submitUrlVideo()
            {
                var mainData = this;
                axios.post('/uploadUserVideosUrl', {urlVideo: this.urlVideo, nameVideo : this.nameVideo})
                    .then(function (response) {
                         mainData.courseVideos.push({
                            id: response.data.file_id,
                            file_name: response.data.file_name,
                            video_name: response.data.video_name,
                            path_to_file: response.data.path_to_file,
                        });

                        mainData.urlVideo = '';
                        mainData.nameVideo = '';
                        mainData.uploadVideos = false;

                        swal('Godt arbejde', 'Data, ændret!', 'success');
                        mainData.uploadImages = 0;
                    })
                    .catch(function (response) {
                        mainData.uploadImages = 0;
                    });
            }
            ,
            getPopUpPicture(index){
                this.startSlidePicture = index;
                this.showModalImage = true;
            },
            closeModalImage(){
                this.showModalImage = false;
            },
            getPopUpVideo(index){
                this.startSlideVideo = index;
                this.showModalVideo = true;
            },
            closeModalVideo() {
                 if ($("#player")[0] &&  $("#player")[0].contentWindow) {
                    $("#player")[0].contentWindow.postMessage('{"event":"command","func":"' + 'pauseVideo' + '","args":""}', '*');
                } else {
                   $('.videoId')[0].pause();
                }
                this.showModalVideo = false;
            },
            getMetaContentByName(name, content)
            {
                var content = (content == null) ? 'content' : content;
                return document.querySelector("meta[name='" + name + "']").getAttribute(content);
            }
            ,
            //            upload images from supervisor
            finishUploadImages(file)
            {
                let fileResponse = file.xhr.response;
                let fileResult = JSON.parse(fileResponse);
                this.coursePictures.push({
                    id: fileResult.file_id,
                    file_name: fileResult.file_name,
                    path_to_file: fileResult.path_to_file,
                });

                this.uploadImages = 0;   
            },
            //            upload images from supervisor
            finishUploadVideos(file)
            {
                let fileResponse = file.xhr.response;
                let fileResult = JSON.parse(fileResponse);
                this.courseVideos.push({
                    id: fileResult.file_id,
                    file_name: fileResult.file_name,
                    path_to_file: fileResult.path_to_file,
                });

                this.uploadVideos = 0;               
            }
            ,
            //            update user avatar
            uploadUserAvatar(event)
            {
                var mainData = this;
                var data = new FormData();
                data.append('image', event.target.files[0]);
                axios.post('/userImageUploadAvatar', data)
                    .then(function (res) {
                        mainData.user_avatar = res.data;
                        swal('Godt arbejde!', 'Avatar uploadet!', 'success');
                    })
                    .catch(function (err) {
                        console.error(err);
                        swal('Fejl', 'ikke belastning avatar!', 'error');
                    });
            }
            ,
            //            delete user avatar
            deleteAvatar()
            {
                let that = this;
                swal({
                    title: 'Er du sikker?',
                    text: "Du vil ikke være i stand til at vende tilbage denne!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ja, slet det!',
                    cancelButtonText: 'Nej, annullere!',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false
                }).then(function () {
                    let data = {
                        'managingPlaceholder': true
                    }
                    axios.post('/deleteUserAvatar', data)
                        .then(function (response) {
                            that.user_avatar = '/image/admin-icon.png';
                            swal('Godt arbejde!', 'Avatar fjernet!', 'success');
                        })
                        .catch(function (error) {
                            that.errors = error.response.data;
                        });

                }, function (dismiss) {
                    if (dismiss === 'cancel') {
                        swal(
                            'Aflyst',
                            'Din avatar ikke slettet!',
                            'error'
                        )
                    }
                })
            }
            ,

            showEditPencils()
            {
                this.showEditForm = !this.showEditForm;
            }
            ,
            getDinamicalPart()
            {
                let mainInfo = this;

                var html = "";
                html += '<label class="pull-left" for="module">Modul</label>';
                html += "<select id='module' class='form-control form-group'>";
                html += "<option disabled selected>Vælg modul</option>";
                for(var m in mainInfo.modules)
                {
                    html += "<option ";
                    html += mainInfo.selected.module == mainInfo.modules[m].id ? " selected " : " ";
                    html += " value='" + mainInfo.modules[m].id + "'>" + mainInfo.modules[m].name + "</option>";
                }
                html += "</select>";

                html += '<label class="pull-left" for="sub_module">Submodul</label>';
                html += "<select id='sub_module' class='form-control form-group' ";
                 if ( ! mainInfo.selected.module) {
                    html += " disabled ";
                }
                html += " >";
                html += "<option disabled selected>Vælg submodul</option>";
                if(mainInfo.selected.module)
                {
                    for(var s in mainInfo.sub_modules[mainInfo.selected.module])
                    {
                        html += "<option ";
                        html += mainInfo.selected.sub_module == mainInfo.sub_modules[mainInfo.selected.module][s].id ? " selected " : " ";
                        html += " value='" + mainInfo.sub_modules[mainInfo.selected.module][s].id + "'>" + mainInfo.sub_modules[mainInfo.selected.module][s].name + "</option>";
                    }
                }
                html += "</select>";

                html += '<label class="pull-left" for="course">Kursus</label>';
                html += "<select id='course' class='form-control form-group' ";
                if ( ! mainInfo.selected.sub_module) {
                    html += " disabled ";
                }
                html += " >";
                html += "<option disabled selected>Vælg kursus</option>";
                if(mainInfo.selected.sub_module)
                {
                    for(var c in mainInfo.courses[mainInfo.selected.sub_module])
                    {
                        html += "<option ";
                        html += mainInfo.selected.course == mainInfo.courses[mainInfo.selected.sub_module][c].id ? " selected " : " ";
                        html += " value='" + mainInfo.courses[mainInfo.selected.sub_module][c].id + "'>" + mainInfo.courses[mainInfo.selected.sub_module][c].name + "</option>";
                    }
                }
                html += "</select>";
                
                $(document).ready(function(){
                    $('#module').change(function(){
                        mainInfo.selected.module = $(this).val();
                        
                        $( ".swal2-container" ).css("overflow-y", "auto");
                        $('#course option').remove();
                        $('#course').attr('disabled', 'disabled');
                        
                        if (mainInfo.sub_modules[mainInfo.selected.module] && mainInfo.sub_modules[mainInfo.selected.module][0]) {
                            mainInfo.selected.sub_module = "" + mainInfo.sub_modules[mainInfo.selected.module][0].id;
                            if(mainInfo.courses[mainInfo.selected.sub_module] && mainInfo.courses[mainInfo.selected.sub_module][0]) {
                                mainInfo.selected.course = "" + mainInfo.courses[mainInfo.selected.sub_module][0].id;
                            }
                        }
                        
                        mainInfo.editCourseMainInfo();

                    });

                     $('#sub_module').change(function(){
                        mainInfo.selected.sub_module = $(this).val();
                        mainInfo.editCourseMainInfo();
                        $( ".swal2-container" ).css("overflow-y", "auto");
                    });

                    $('#course').change(function(){
                        for(var c in mainInfo.courses[mainInfo.selected.sub_module])
                        {
                            if (mainInfo.courses[mainInfo.selected.sub_module][c].id == $(this).val())
                            {
                                $("#courseNumber").val(mainInfo.courses[mainInfo.selected.sub_module][c].number);
                                $("#courseTimer").val(mainInfo.courses[mainInfo.selected.sub_module][c].time);
                            }
                        }
                    });
                })

                return html;
                
            },
            checkYoutube(url) {
                return url.indexOf("youtu") + 1 ? false : true;
            },
            editCourseMainInfo(){
                var mainData = this;
                swal({
                    title: 'Skift grundlæggende oplysninger',
                    showCancelButton: true,
                    html:
                    this.getDinamicalPart() +
                    
                    '<label class="pull-left" for="courseNumber">Kursusnummer</label><Br>' +
                    '<input id="courseNumber" class="swal2-input" placeholder="Kursusnummer" value="' + this.course_number + '">' +
                    '<br>' +

                    '<label class="pull-left" for="courseDate">Dato </label>' +
                    '<button id="courseDate" class="btn btn-primary">Datovælger</button><br>' +

                    '<label class="pull-left" for="courseTimer">Timer</label><Br>' +
                    '<input id="courseTimer" class="swal2-input" placeholder="Timer" value="' + this.course_hours + '">' +

                    '<label class="pull-left" for="courseApproved">Godkendt af DP</label><Br>' +
                    '<div class="managingTrainedLeader">' +
                    '<label class="radio-inline"><input id="courseApproved_yes" type="radio"  value="1" name="optradio">ja</label>' +
                    '<label class="radio-inline"><input id="courseApproved_not" type="radio"  value="0" name="optradio">nej</label>' +
                    '</div><br>' +

                    '<label class="pull-left" for="primary_education">Til specialistuddannelse</label><Br><Br>' +
                    '<div class="dropup">' +
                    '<button type="button" class="btn btn-default dropdown-toggle btn-block" data-toggle="dropdown">Til specialistuddannelse <span class="caret"></span></button>' +
                    '<ul class="dropdown-menu">' +
                 
                   '<li><a href="javascript:void(0);"><b>Børnepsykologi:</b></a></li>' +
                        '<li><a href="javascript:void(0);" class="small" data-value="Sundhedspsykologi med børn" tabIndex="-1"><input type="checkbox"/> Sundhedspsykologi med børn</a></li>' +
                        '<li><a href="javascript:void(0);" class="small" data-value="Psykoterapi med børn" tabIndex="-1"><input type="checkbox"/> Psykoterapi med børn</a></li>' +
                        '<li><a href="javascript:void(0);" class="small" data-value="Klinisk børnepsykologi" tabIndex="-1"><input type="checkbox"/> Klinisk børnepsykologi</a></li>' +
                        '<li><a href="javascript:void(0);" class="small" data-value="Psykotraumatologi" tabIndex="-1"><input type="checkbox"/> Psykotraumatologi</a></li>' +
                        '<li><a href="javascript:void(0);" class="small" data-value="Klinisk Neuropsykologi" tabIndex="-1"><input type="checkbox"/> Klinisk Neuropsykologi</a></li>' +
                        '<li><a href="javascript:void(0);" class="small" data-value="Klinisk børneneuropsykologi" tabIndex="-1"><input type="checkbox"/> Klinisk børneneuropsykologi</a></li>' +
                        '<li><a href="javascript:void(0);" class="small" data-value="Pædagogisk psykologi" tabIndex="-1"><input type="checkbox"/> Pædagogisk psykologi</a></li>' +

                        '<li><a href="javascript:void(0);"><b>Voksenpsykologi:</b></a></li>' +
                        '<li><a href="javascript:void(0);" class="small" data-value="Sundhedspsykologi med voksne" tabIndex="-1"><input type="checkbox"/> Sundhedspsykologi med voksne</a></li>' +
                        '<li><a href="javascript:void(0);" class="small" data-value="Psykoterapi med voksne" tabIndex="-1"><input type="checkbox"/> Psykoterapi med voksne</a></li>' +
                        '<li><a href="javascript:void(0);" class="small" data-value="Psykopatologi" tabIndex="-1"><input type="checkbox"/> Psykopatologi</a></li>' +
                        '<li><a href="javascript:void(0);" class="small" data-value="Psykotraumatologi" tabIndex="-1"><input type="checkbox"/> Psykotraumatologi</a></li>' +
                        '<li><a href="javascript:void(0);" class="small" data-value="Klinisk Neuropsykologi" tabIndex="-1"><input type="checkbox"/> Klinisk Neuropsykologi</a></li>' +
                        '<li><a href="javascript:void(0);" class="small" data-value="Gerontopsykologi" tabIndex="-1"><input type="checkbox"/> Gerontopsykologi</a></li>' +
                        
                        '<li><a href="javascript:void(0);"><b>Arbejds- og organisationspsykologi:</b></a></li>' +
                        '<li><a href="javascript:void(0);" class="small" data-value="Arbejds- og organisationspsykologi" tabIndex="-1"><input type="checkbox"/> Arbejds- og organisationspsykologi</a></li>' +

                    '</ul>' +
                    '</div><br />'

                    ,
                    onOpen: function () {
                        if (mainData.course_approved) {
                            document.getElementById('courseApproved_yes').checked = true;
                        } else {
                            document.getElementById('courseApproved_not').checked = true;
                        }
                        
                        $( '.dropdown-menu input' ).each(function(k, v){ 
                            let value = $(v).parent().data("value");
                            if (mainData.special_preparation.indexOf(value) + 1) {
                                $(v).attr("checked", "checked");
                            }
                        });
                        
                        $('#courseDate').click(() => {
                            $( ".swal2-container" ).css("z-index", "1");
                            $('.cov-vue-date').css("display", "block");
                            $( ".cov-datepicker" ).trigger( "click" );
                        });
                        
                        $( "#hide-date-picker" ).css("display", "inline");
                    },
                    onClose:()=>{
                        $( "#hide-date-picker" ).css("display", "none");
                    },
                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            if (true) {
                                var course_number = document.getElementById("courseNumber").value;
                                var course_hours = document.getElementById("courseTimer").value;
                                var primary_education_list = document.getElementById("primary_education");
                                
                                var options = [];
                                $( '.dropdown-menu input:checked' ).each(function(k, v){ options.push($(v).parent().data('value')); });
                                if (document.getElementById('courseNumber').value != ''
                                    && document.getElementById('courseTimer').value != '') {
                                    resolve([
                                        course_number,
                                        course_hours,
                                        options,
                                        document.querySelector('input[name="optradio"]:checked').value,
                                    ]);
                                }
                                else {
                                    swal('Fejl', 'Felt kan ikke være tom!', 'error');
                                }
                            }
                        });
                    }
                }).then(function (result) {
                    
                    var course_number = result[0];
                    var course_hours = result[1];
                    var primary_education = result[2];
                    var course_approved = result[3];

               

                    let data = {
                        user_id: mainData.courseOwnerId,
                        course_id : $("#course").val(),
                        course_number: course_number,
                        course_hours: course_hours,
                        special_preparation: primary_education,
                        course_approved: course_approved * 1 ? 1 : 0
                    };

                    console.log(data);
                    
                    axios.patch('/updateCourseMainInfo', data)
                        .then(function (response) {
                            mainData.course_number = course_number;
                            mainData.course_hours = course_hours;
                            mainData.special_preparation = primary_education;
                            mainData.course_approved = course_approved;
                            
                            swal('Godt arbejde', 'Data, ændret!', 'success')
                                .then(function(){
                                   window.location.reload();
                                })

                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                });
            },
            editAddress(){
                var mainData = this;

                var options_looking = "";
                for(var o in mainData.lookingKursusOptions) { 
                    options_looking += "<option class='default-option' value='" + mainData.lookingKursusOptions[o].value + "' "; 
                    if (mainData.lookingKursusOptions[o].disabled) {
                         options_looking += " disabled ";
                    }
                    if (this.byAddress2 == mainData.lookingKursusOptions[o].value) {
                        options_looking += " selected ";
                    }
                    options_looking += ">" + mainData.lookingKursusOptions[o].text + "</option>";
                }

                swal({
                    title: 'Kursusadresse',
                    showCancelButton: true,
                    html: '<label class="pull-left" for="NameAddress">Navn på kursussted </label><Br>' +
                    '<input id="NameAddress" class="swal2-input"  placeholder="Navn på kursussted " value="' + this.addressName + '"><br>' +
                    '<label class="pull-left" for="Vej">Vej</label><Br>' +
                    '<input id="Vej" class="swal2-input"  placeholder="Vej" value="' + this.roadName + '"><br>' +
                    '<label class="pull-left" for="PostNumber">Postnummer</label><Br>' +
                    '<input id="PostNumber" class="swal2-input"  placeholder="Postnummer" value="' + this.postNumber + '"><br>' +
                    '<label class="pull-left" for="ByAddress">By</label><Br>' +
                    '<input id="ByAddress" class="swal2-input" value="' + this.byAddress + '" />' +
                    '<label class="pull-left" for="ByAddress2">Område som psykologen får at se i sin søgning</label><Br>' +
                    '<select id="ByAddress2" style="margin:0" class="application-select">' +
                    options_looking +
                    '</select>'+
                    '<br>',
                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            if (true) {
                                if (document.getElementById('NameAddress').value != ''
                                    && document.getElementById('Vej').value != ''
                                    && document.getElementById('PostNumber').value != ''
                                    && document.getElementById('ByAddress').value != ''
                                    && document.getElementById('ByAddress2').value != ''

                                ) {
                                    resolve([
                                        document.getElementById('NameAddress').value,
                                        document.getElementById('Vej').value,
                                        document.getElementById('PostNumber').value,
                                        document.getElementById('ByAddress').value,
                                        document.getElementById('ByAddress2').value
                                    ]);
                                }
                                else {
                                    swal('Fejl', 'Felt kan ikke være tom!', 'error');
                                }
                            }
                        });
                    }
                }).then(function (result) {
                    var addressName = result[0];
                    var roadName = result[1];
                    var postNumber = result[2];
                    var byAddress = result[3];
                    var byAddress2 = result[4];
                    let data = {
                        user_id: mainData.courseOwnerId,
                        addressName: addressName,
                        roadName: roadName,
                        postNumber: postNumber,
                        byAddress: byAddress,
                        byAddress2 : byAddress2,
                    };
                    axios.patch('/updateUserAddress', data)
                        .then(function (response) {
                            mainData.addressName = addressName;
                            mainData.roadName = roadName;
                            mainData.postNumber = postNumber;
                            mainData.byAddress = byAddress;
                            mainData.byAddress2 = byAddress2;
                            swal('Godt arbejde', 'Data, ændret!', 'success');
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                });
            }
            ,
            editEmailPhone()
            {
                var mainData = this;
                swal({
                    title: 'Kontaktoplysninger',
                    showCancelButton: true,
                    html: '<label class="pull-left" for="Email">Email</label><Br>' +
                    '<input id="Email" class="swal2-input" autofocus placeholder="eks: psykolog@psykolog.dk" value="' + this.email + '">' +
                    '<label class="pull-left" for="Phone">Telefonnummer</label><Br>' +
                    '<input id="Phone" class="swal2-input" placeholder="eks: 32 32 23 32" value="' + this.phone + '">',
                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            if (true) {
                                if (document.getElementById('Email').value != '' && document.getElementById('Phone').value != '') {
                                    resolve([
                                        document.getElementById('Email').value,
                                        document.getElementById('Phone').value
                                    ]);
                                }
                                else {
                                    swal('Fejl', 'Felt kan ikke være tom!', 'error');
                                }
                            }
                        });
                    }
                }).then(function (result) {
                    var email = result[0];
                    var phone = result[1];
                    let data = {
                        supervisionId: mainData.supervisionId,
                        email: email,
                        phone: phone
                    };
                    axios.patch('/updateUserEmailPhone', data)
                        .then(function (response) {
                            mainData.email = email;
                            mainData.phone = phone;
                            swal('Godt arbejde', 'Data, ændret!', 'success');
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                });
            }
            ,
            editCoursePrice()
            {
                var mainData = this;
                swal({
                    title: 'Skift Pris',
                    showCancelButton: true,
                    html: '<label class="pull-left" for="Price">Pris</label><Br>' +
                    '<input id="Price" class="swal2-input" autofocus placeholder="Angiv prisen med numerisk værdi" value="' + (this.course_price ? this.course_price : '')  + '">',
                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            if (true) {
                                if (document.getElementById('Price').value != '') {
                                    resolve(
                                        document.getElementById('Price').value,
                                    );
                                }
                                else {
                                    swal('Fejl', 'Felt kan ikke være tom!', 'error');
                                }
                            }
                        });
                    }
                }).then(function (price) {
                    var course_price = price.replace("DKK", "") * 1;
                    let data = {
                        courseOwnerId: mainData.courseOwnerId,
                        course_price: course_price,
                    };
                    axios.patch('/updateCoursePrice', data)
                        .then(function (response) {
                            mainData.course_price = course_price;
                            swal('Godt arbejde', 'Data, ændret!', 'success');
                        })
                        .catch(function (error) {
                            console.log(error);
                            swal('Fejl', 'Feltet kan ikke være tomt skal være numerisk!', 'error');
                        });
                });

            }
            ,
            updateSupervisionProfileVersion()
            {
                var mainData = this;
                swal({
                    title: 'Er du sikker?',
                    text: "Din profil vil blive ændret til den pro version!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ja, slet det!',
                    cancelButtonText: 'Nej, annullere!',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false
                }).then(function () {
                    axios.patch('/updateSupervisionProfileVersion')
                        .then(function (response) {
                            mainData.$router.push('/SupervisorProfilesideManagingPro/' + mainData.supervisionsId);
                            swal('Godt arbejde', 'Nu har du den pro version!', 'success');
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                });
            }
            ,
            editPresentationDescription()
            {
                let mainData = this;
                let data = {
                    supervisionId: this.supervisionId,
                    presentationDescription: this.presentation_description
                };
                console.log(data);
                axios.patch('/updateUserPresentation', data)
                    .then(function (response) {
                        mainData.presentation_description = mainData.presentation_description;
                        mainData.showEditPresentationForm = false;
                        swal('Godt arbejde', 'Data, ændret!', 'success');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
            ,
            editTeachers()
            {
                var mainData = this;
                swal({
                    title: 'Undervisere:',
                    showCancelButton: true,
                    html: '<label class="pull-left" for="teacherName">Underviserens navn:</label><Br>' +
                    '<input id="teacherName" class="swal2-input" autofocus placeholder="Underviserens navn" >',
                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            if (true) {
                                if (document.getElementById('teacherName').value != '') {
                                    resolve(
                                        document.getElementById('teacherName').value
                                    );
                                }
                                else {
                                    swal('Fejl', 'Felt kan ikke være tom!', 'error');
                                }
                            }
                        });
                    }
                }).then(function (teacherName) {

                    let data = {
                        user_id: mainData.courseOwnerId,
                        teacherName: teacherName,
                    };
                    axios.post('/addCourseTeacher', data)
                        .then(function (response) {
//                                response.data is teacher id
                            mainData.courseTeachers.push({
                                id: response.data,
                                teacher_name: teacherName,
                            });

                            swal('Godt arbejde', 'Data, ændret!', 'success');
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                })
            }
            ,
            editCourseProgramEvent()
            {
                this.editCourseProgram = !this.editCourseProgram;
            }
            ,
            changeDropDownSelectSupervisorPreparation()
            {
                this.changeColorSelect($('#special_preparation'), $('#special_preparation').val());
            }
            ,
            //            change color field when user change option
            changeColorSelect(select, selectedValue)
            {
                if (selectedValue == 'default') {
                    select.css({
                        "background-color": "#d0edf8",
                        "font-family": "Raleway"
                    });
                } else {
                    select.css({
                        "background-color": "#f6faca",
                        "font-family": "Raleway regular"
                    });
                }
            }
            ,
            uploadFile(event)
            {
                this.file = event.target.files[0];
            }
            ,
            uploadCourse()
            {
                var mainData = this;
                var fileData = new FormData()
                fileData.append('file', this.file);
                fileData.append('user_id', mainData.courseOwnerId);
                axios.post('/addCourseProgram', fileData)
                    .then(function (response) {
                        mainData.course_program.push({
                            id: response.data.file_id,
                            file_name: response.data.file_name,
                            path_to_file: response.data.path_to_file,
                        });
                        mainData.file = null;
                        mainData.editCourseProgram = false;
                        swal('Godt arbejde', 'Data, ændret!', 'success');
                    })
                    .catch(function (error) {
                        swal('Fejl!', 'Fejl ved indlæsning af fil!', 'error')
                    });
            }
            ,
            deleteCourseProgram(id)
            {
                let mainData = this;
                swal({
                    title: 'Er du sikker?',
                    text: "Du vil ikke være i stand til at vende tilbage denne!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ja, slet det!',
                    cancelButtonText: 'Nej, annullere!',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false
                }).then(function () {
                    let data = {id: id};
                    axios.delete('/deleteCourseProgram', {params: data})
                        .then(function (response) {
                            $.each(mainData.course_program, function (i) {
                                if (mainData.course_program[i].id === id) {
                                    mainData.course_program.splice(i, 1);
                                    return false;
                                }
                            });
                            mainData.editCourseProgram = false;
                            swal('Godt arbejde!', 'Fil slettet!', 'success');
                        })
                        .catch(function (error) {
                            console.log(error);
                        });

                }, function (dismiss) {
                    if (dismiss === 'cancel') {
                        swal(
                            'Aflyst',
                            'Din fil ikke slettet!',
                            'error'
                        )
                    }
                })
            },
            deleteCourseTeacher(id)
            {
                let mainData = this;
                swal({
                    title: 'Er du sikker?',
                    text: "Du vil ikke være i stand til at vende tilbage denne!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ja, slet det!',
                    cancelButtonText: 'Nej, annullere!',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false
                }).then(function () {
                    let data = {id: id};
                    axios.delete('/deleteCourseTeacher', {params: data})
                        .then(function (response) {
                            $.each(mainData.courseTeachers, function (i) {
                                if (mainData.courseTeachers[i].id === id) {
                                    mainData.courseTeachers.splice(i, 1);
                                    return false;
                                }
                            });
                            swal('Godt arbejde!', 'Fil slettet!', 'success');
                        })
                        .catch(function (error) {
                            console.log(error);
                        });

                }, function (dismiss) {
                    if (dismiss === 'cancel') {
                        swal(
                            'Aflyst',
                            'Din fil ikke slettet!',
                            'error'
                        )
                    }
                })
            },
            deletePicture(id)
            {
                let mainData = this;
                swal({
                    title: 'Er du sikker?',
                    text: "Du vil ikke være i stand til at vende tilbage denne!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ja, slet det!',
                    cancelButtonText: 'Nej, annullere!',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false
                }).then(function () {
                    let data = {id: id};
                    axios.delete('/deleteUserPicture', {params: data})
                        .then(function (response) {
                            $.each(mainData.coursePictures, function (i) {
                                if (mainData.coursePictures[i].id === id) {
                                    mainData.coursePictures.splice(i, 1);
                                    return false;
                                }
                            });
                            swal('Godt arbejde!', 'Fil slettet!', 'success');
                        })
                        .catch(function (error) {
                            console.log(error);
                        });

                }, function (dismiss) {
                    if (dismiss === 'cancel') {
                        swal(
                            'Aflyst',
                            'Din fil ikke slettet!',
                            'error'
                        )
                    }
                })
            }
            ,
            deleteVideo(id)
            {
                let mainData = this;
                swal({
                    title: 'Er du sikker?',
                    text: "Du vil ikke være i stand til at vende tilbage denne!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ja, slet det!',
                    cancelButtonText: 'Nej, annullere!',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false
                }).then(function () {
                    let data = {id: id};
                    axios.delete('/deleteUserVideos', {params: data})
                        .then(function (response) {
                            $.each(mainData.courseVideos, function (i) {
                                if (mainData.courseVideos[i].id === id) {
                                    mainData.courseVideos.splice(i, 1);
                                    return false;
                                }
                            });
                            swal('Godt arbejde!', 'Fil slettet!', 'success');
                        })
                        .catch(function (error) {
                            console.log(error);
                        });

                }, function (dismiss) {
                    if (dismiss === 'cancel') {
                        swal(
                            'Aflyst',
                            'Din fil ikke slettet!',
                            'error'
                        )
                    }
                })
            }
            ,
            editWebsiteUrl()
            {
                var mainData = this;
                swal({
                    title: 'Skift Hjemmeside',
                    showCancelButton: true,
                    html: '<label class="pull-left" for="Website">Hjemmeside</label><Br>' +
                    '<input id="Website" class="swal2-input" autofocus placeholder="http://www.eksempel.dk " value="' + this.website + '">',
                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            if (true) {
                                if (document.getElementById('Website').value != '') {
                                    resolve(
                                        document.getElementById('Website').value
                                    );
                                }
                                else {
                                    swal('Fejl', 'Felt kan ikke være tom!', 'error');
                                }
                            }
                        });
                    }
                }).then(function (result) {
                    var website = result;
                    let data = {
                        user_id: mainData.courseOwnerId,
                        website: website
                    };
                    axios.patch('/updateUserWebsite', data)
                        .then(function (response) {
                            mainData.website = website;
                            mainData.websitePath = response.data;
                            swal('Godt arbejde', 'Data, ændret!', 'success');
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                });
            }
            ,
            showPictureUploadsForm()
            {
                this.uploadImages = !this.uploadImages;
            }
            ,
            showVideosUploadsForm()
            {
                this.uploadVideos = !this.uploadVideos;
            }
            ,
        }
        ,
        components: {
            'date-picker': Datepicker,
            Dropzone,
            Modal,
            Slider,
            SliderItem,
            VueEditor
        }

    }
</script>
<style scoped>
    #hide-date-picker {
        display:none;
    }
</style>