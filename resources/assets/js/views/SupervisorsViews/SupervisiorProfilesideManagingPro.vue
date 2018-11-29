<template>
    <article class="content-block-profil content-block container-fluid">
        <div class="row border-row">
            <div class="col-md-6">
                <h3>SUPERVISOR PROFILSIDE</h3>
            </div>
            <div class="col-md-6">
                <div class="btn-wrapper pull-right">
                    <div class="supervisor-free-wrapper">
                        <p>Supervisor</p>
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
                            <button class="file-upload pro-upload">
                                <input type="file" class="file-input" @change="uploadUserAvatar">
                                <img src="/image/vector-smart-arrow-up.png" alt="arrow">
                                Upload


                            </button>
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

                    <h5>{{supervisorName}} {{supervisorSurname}}</h5>
                    <p><b>Praksis beliggenhed : </b>{{city}}</p>
                    <p><b>Alder : </b>{{age}}</p>

                    <p v-show="primary_education.primary_education!='none'||primary_education.secondary_education!='none'||primary_education.third_education!='none'">
                        <b>Uddannelse i:</b>
                    </p>

                    <p v-show="primary_education != 'none'">{{ primary_education }}</p>
                    <p v-show="secondary_education != 'none'">{{ secondary_education }}</p>
                    <p v-show="third_education != 'none'">{{ third_education }}</p>
                   

                    <p>
                    <p v-show="Systemisk_strukturel||Eksistentiel_humanistisk||Kognitiv_adfærdsterapeutisk||Psykodynamisk_psykoanalytisk">
                        <b>Teoretisk preference:</b></p>
                    <p v-show="Eksistentiel_humanistisk">Eksistentiel/humanistisk</p>
                    <p v-show="Kognitiv_adfærdsterapeutisk">Kognitiv/adfærdsterapeutisk</p>
                    <p v-show="Psykodynamisk_psykoanalytisk">Psykodynamisk/psykoanalytisk</p>
                    <p v-show="Systemisk_strukturel">Systemisk/strukturel</p>

                    </p>

                    <p v-show="trained_leader==1"><b>Supervisoruddannet :</b>
                        <span>ja</span>
                    </p>

                </div>
                <div v-show="showEditForm">
                    <div class="picture-wrapper edit-block text-center">
                        <a href="javascript:;" @click="editName()">
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
                        <li><strong>Klinikadresse:</strong></li>
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
                    <p><strong>Tilbyder former for supervision:</strong><br>
                        <span v-show="Ansigt_till">- Ansigt-til-ansigt<br></span>
                        <span v-show="Live_Video">- Live Video/Audio<br></span>
                        <span v-show="Gruppesupervision">- Gruppesupervision<br></span>
                        <span v-show="Enkeltsupervision">- Enkeltsupervision<br></span>
                        <span v-show="Egenterapi_Personligt">- Egenterapi/Personligt udviklingsarbejde<br></span>
                    </p>
                </div>
                <div v-show="showEditForm">
                    <div class="picture-wrapper edit-ico text-center">
                        <a href="javascript:;" @click="editFormType()">
                            <img class="edit-pic" src="/image/edit-ico.png" alt="edit">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="specialist-wrapper">
            <div class="row list-wrapper">
                <div class="col-md-2 headline-block">
                    <p>specialistbevis:</p>
                </div>
                <div v-for="spec in supervisor_specialisation">
                    <div class="col-md-2 text-center">
                        <a :href="spec.path_to_file" target="_blank"><img src="/image/list-ico.png" alt="avatar"></a>
                        <img v-show="editSpecialistbevis" class="SupervisorSpecialistbevisTrash"
                             src="/image/vector-smart-trash.png" alt="delete" @click="deleteSpecialisation(spec.id)">

                        <p>{{spec.specialisation}}</p>
                    </div>
                </div>
                <div v-show="showEditForm">
                    <div class="picture-wrapper edit-ico text-center">
                        <a href="javascript:;" @click="editSpecialistbevisEvent()">
                            <img class="edit-pic" src="/image/edit-ico.png" alt="edit">
                        </a>
                    </div>
                </div>
            </div>
            <div class="row SupervisorSpecialistbevis" v-show="editSpecialistbevis">
                <div class="col-md-2 headline-block SupervisorSpecialistbevisFile">
                    <p>Eksamensbevis:</p>
                </div>
                <div class="col-md-3  SupervisorSpecialistbevisFile">
                    <input type="file" id="specialisationFile" @change="uploadFile">
                </div>
                <div class="col-md-4 SupervisorSpecialistbevisBtnSave">
                    <select class="application-select" v-model="special_preparation_selected"
                            @change="changeDropDownSelectSupervisorPreparation" id="special_preparation">
                        <option class="default-option" v-for="option in options" :class="{'bold' : option.value == 0 }" v-bind:value="option.value"
                                :disabled="option.value==0">
                            {{ option.text }}
                        </option>
                    </select>
                </div>
                <div class="col-md-3 ">
                    <button class="btn btn-success btn-save-Specialistbevis" @click="uploadSpecialistbevis"
                            v-show="file!=null && special_preparation_selected!='default'">Save


                    </button>
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
                        <div class="col-md-2" v-for="(picture,index) in supervisorPictures">
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
                        <div class="col-md-2" v-for="(video,index) in supervisorVideos">
                            <div class="item-box text-center">
                                <div class="avatar-section">
                                    <!--<img @click="getPopUpVideo(index)" class="managingPictures"-->
                                    <!--:src="video.path_to_file" alt="avatar">-->
                                    
                                    <!-- <video poster="/image/videoPlaceholderImg.jpg" class="managingPictures"
                                           @click="getPopUpVideo(index)">
                                        <source :src="video.path_to_file" type="video/mp4" />
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

                        <hr />
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
                    <slider-item v-for="(picture, index) in supervisorPictures" :key="startSlidePicture">
                        <img class="img-slider-popUp" :src="picture.path_to_file" alt="picture">
                    </slider-item>
                </slider>
            </div>
        </modal>


        <modal v-on:hide.bs.modal="alert('hide')"  :showModal="showModalVideo" :closeAction="closeModalVideo">
            <div slot="body" class="text-center">
                <slider animation="fade" :auto="false" :indicators="false" :control-btn="center"
                        :init-index="startSlideVideo">
                    <slider-item v-for="(video, index) in supervisorVideos" :key="startSlideVideo">
                        
                        <div v-if="checkYoutube(video.path_to_file)">
                            <video class="videoId" width="560" height="300" controls>
                                <source  :src="video.path_to_file" type="video/mp4">
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
    import {Slider, SliderItem} from 'vue-easy-slider'
    import { VueEditor } from 'vue2-editor'
    export default {
//        Collect information to vue.data
        data()
        {
            return {
                supervisionId: null,
                supervisorName: "",
                supervisorSurname: "",
                special_preparation: "",
                age: 0,
                trained_leader: null,
                address: "",
                email: "",
                phone: "",
                presentation_description: "",
                form_type: "",
                showEditForm: false,
                user_avatar: '',
                website: '',
                websitePath: '',
                supervisorPictures: [],
                supervisorVideos: [],
                city: "",

                addressName: "",
                roadName: "",
                postNumber: "",
                byAddress: "",


                primary_education: "",
                secondary_education: "",
                third_education: "",

                Ansigt_till: false,
                Live_Video: false,
                Gruppesupervision: false,
                Enkeltsupervision: false,
                Egenterapi_Personligt: false,

                Eksistentiel_humanistisk: false,
                Kognitiv_adfærdsterapeutisk: false,
                Psykodynamisk_psykoanalytisk: false,
                Systemisk_strukturel: false,

                supervisor_specialisation: [],
                editSpecialistbevis: false,
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

                dropzoneOptions : {
                    url : "/uploadUserImages"
                },
                dropzoneOptionsVideo : {
                    url : "/uploadUserVideos",
                    maxFilesize : 25
                },

                showModalImage: false,
                startSlidePicture: null,
                showModalVideo: false,
                startSlideVideo: null,
                urlVideo: '',
                nameVideo : '',
                center:'',
                showEditPresentationForm:false,


            }
        }
        ,
        created: function () {

            let supervisionsId = (this.$route.params.idSupervision);
            this.supervisionId = supervisionsId;
            let data = {
                supervisionsId: supervisionsId
            };
            let mainData = this;
            axios.post('/getUserRoleSupervisionInformation', data)
                .then(function (response) {
                    //supervisor info block begin
                    mainData.supervisionId = response.data.user.id;
                    mainData.supervisorName = response.data.user.name;
                    mainData.supervisorSurname = response.data.user.surname;
                    mainData.special_preparation = response.data.user.full_info_about_user.special_preparation;
                    mainData.address = response.data.user.full_info_about_user.address;
                    mainData.email = response.data.user.email;
                    mainData.phone = response.data.user.full_info_about_user.phone;
                    mainData.age = response.data.user.full_info_about_user.age;
                    mainData.trained_leader = response.data.user.full_info_about_user.trained_leader;
                    mainData.city = response.data.user.full_info_about_user.city;

                    if (response.data.user.full_info_about_user.version != 'pro') {
                        mainData.$router.push('/SupervisorProfilesideManagingFree/' + supervisionsId);
                    }
                    mainData.user_avatar = response.data.user.full_info_about_user.avatar_path != null ? response.data.user.full_info_about_user.avatar_path : '/image/admin-icon.png';
                    mainData.presentation_description = response.data.user.full_info_about_user.presentation;
                    mainData.website = response.data.user.full_info_about_user.website;
                    mainData.websitePath = response.data.user.full_info_about_user.pathWebsiteScreen;
                    //supervisor info block end

                    //supervisor types block
                    mainData.Ansigt_till = response.data.supervision_types && response.data.supervision_types.Ansigt_till ? response.data.supervision_types.Ansigt_till : '';
                    mainData.Live_Video = response.data.supervision_types && response.data.supervision_types.Live_Video ? response.data.supervision_types.Live_Video : '';
                    mainData.Gruppesupervision = response.data.supervision_types && response.data.supervision_types.Gruppesupervision ? response.data.supervision_types.Gruppesupervision : '';
                    mainData.Enkeltsupervision = response.data.supervision_types && response.data.supervision_types.Enkeltsupervision ? response.data.supervision_types.Enkeltsupervision : '';
                    mainData.Egenterapi_Personligt = response.data.supervision_types && response.data.supervision_types.Egenterapi_Personligt ? response.data.supervision_types.Egenterapi_Personligt : '';

                    //supervisor address data block
                    mainData.addressName = response.data.supervision_address && response.data.supervision_address.address_name ? response.data.supervision_address.address_name : '';
                    mainData.roadName = response.data.supervision_address && response.data.supervision_address.road_name ? response.data.supervision_address.road_name : '';
                    mainData.postNumber = response.data.supervision_address && response.data.supervision_address.post_number ? response.data.supervision_address.post_number : '';
                    mainData.byAddress = response.data.supervision_address && response.data.supervision_address.by_address ? response.data.supervision_address.by_address : '';

                    //supervisor educations data block
                    mainData.primary_education = response.data.supervision_educations && response.data.supervision_educations.primary_education ? response.data.supervision_educations.primary_education : '';
                    mainData.secondary_education = response.data.supervision_educations && response.data.supervision_educations.secondary_education ? response.data.supervision_educations.secondary_education : '';
                    mainData.third_education = response.data.supervision_educations && response.data.supervision_educations.third_education ? response.data.supervision_educations.third_education : '';

                    //supervisor speciality/interest  block
                    mainData.Eksistentiel_humanistisk = response.data.supervision_speciality && response.data.supervision_speciality.Eksistentiel_humanistisk ? response.data.supervision_speciality.Eksistentiel_humanistisk : '';
                    mainData.Kognitiv_adfærdsterapeutisk = response.data.supervision_speciality && response.data.supervision_speciality.Kognitiv_adfærdsterapeutisk ? response.data.supervision_speciality.Kognitiv_adfærdsterapeutisk : '';
                    mainData.Psykodynamisk_psykoanalytisk = response.data.supervision_speciality && response.data.supervision_speciality.Psykodynamisk_psykoanalytisk ? response.data.supervision_speciality.Psykodynamisk_psykoanalytisk : '';
                    mainData.Systemisk_strukturel = response.data.supervision_speciality && response.data.supervision_speciality.Systemisk_strukturel ? response.data.supervision_speciality.Systemisk_strukturel : '';

                    //Supervisor specialisation
                    mainData.supervisor_specialisation = response.data.supervision_specialisation;
                    //Supervisor pictures
                    mainData.supervisorPictures = response.data.supervisorPictures;
                    //Supervisor videos
                    mainData.supervisorVideos = response.data.supervisorVideos;
                })
                .catch(function (error) {
                    console.log(error);
                });
//            add token to dropzone post request
            
           this.token = this.getMetaContentByName('csrf-token');
                    
            this.dropzoneOptions.headers = { 'X-CSRF-TOKEN' : this.getMetaContentByName('csrf-token') };
            this.dropzoneOptionsVideo.headers = { 'X-CSRF-TOKEN' : this.getMetaContentByName('csrf-token') };
            

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
        components: {
            Dropzone,
            Modal,
            Slider,
            SliderItem,
            VueEditor,

        },
        methods: {
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
            checkYoutube(url) {
                return url.indexOf("youtu") + 1 ? false : true;
            },
            cancelUrlVideo()
            {
                this.urlVideo = '';
                this.nameVideo = '';
            }
            ,
            submitUrlVideo()
            {
                console.log(this.urlVideo, this.nameVideo);
                var mainData = this;
                let data = {urlVideo: this.urlVideo, nameVideo : this.nameVideo};
                axios.post('/uploadUserVideosUrl', data)
                    .then(function (response) {
                        mainData.supervisorVideos.push({
                            id: response.data.file_id,
                            file_name: response.data.file_name,
                            video_name: response.data.video_name,
                            path_to_file: response.data.path_to_file,
                        });
                        mainData.urlVideo = '';
                        mainData.nameVideo = '';
                        mainData.uploadVideos = false;
                        swal('Godt arbejde', 'Data, ændret!', 'success');
                    })
                    .catch(function (error) {
                        swal('Fejl!', 'Fejl ved indlæsning af fil!', 'error')
                    });
            }
            ,
            getPopUpPicture(index)
            {
                this.startSlidePicture = index;
                this.showModalImage = true;
            }
            ,
            closeModalImage()
            {
                this.showModalImage = false;
            }
            ,
            getPopUpVideo(index)
            {
                this.startSlideVideo = index;
                this.showModalVideo = true;
            }
            ,
            closeModalVideo()
            {
                if ($("#player")[0] &&  $("#player")[0].contentWindow) {
                    $("#player")[0].contentWindow.postMessage('{"event":"command","func":"' + 'pauseVideo' + '","args":""}', '*');
                } else {
                   $('.videoId')[0].pause();
                }
                this.showModalVideo = false;
            }
            ,
            getMetaContentByName(name, content)
            {
                var content = (content == null) ? 'content' : content;
                return document.querySelector("meta[name='" + name + "']").getAttribute(content);
            }
            ,
            //            upload images from supervisor

            showSuccess () {
                console.log('A file was successfully uploaded')
            },

            finishUploadImages(file)
            {
                let fileResponse = file.xhr.response;
                let fileResult = JSON.parse(fileResponse);
                this.supervisorPictures.push({
                    id: fileResult.file_id,
                    file_name: fileResult.file_name,
                    path_to_file: fileResult.path_to_file,
                });

                this.uploadImages = 0;   
            }
            ,
            //            upload images from supervisor
            finishUploadVideos(file)
            {
                let fileResponse = file.xhr.response;
                let fileResult = JSON.parse(fileResponse);
                this.supervisorVideos.push({
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
            editName()
            {
                var mainData = this;
                swal({
                    title: 'Skift grundlæggende oplysninger',
                    showCancelButton: true,
                    html: '<label class="pull-left" for="supervisorName">Fornavn </label><Br>' +
                    '<input id="supervisorName" class="swal2-input" autofocus placeholder="Fornavn " value="' + this.supervisorName + '">' +
                    '<label class="pull-left" for="supervisorSurname">Efternavn</label><Br>' +
                    '<input id="supervisorSurname" class="swal2-input" placeholder="Efternavn" value="' + this.supervisorSurname + '">' +

                    '<label class="pull-left" for="city">Praksis beliggenhed</label><Br><Br>' +
                    '<select class="form-control" id="city">' +
//                    '<option value="none" selected="selected">Hvor søger du supervisor?</option>' +
                    '<option disabled class="bold">By:</option>' +
                    '<option value="Århus">* Århus</option>' +
                    '<option value="København">* København</option>' +
                    '<option value="Odense">* Odense</option>' +
                    '<option value="Ålborg">* Ålborg</option>' +
                    '<option disabled></option>' +
                    '<option disabled class="bold">Region:</option>' +
                    '<option value="Nordjylland">* Nordjylland</option>' +
                    '<option value="Midtjylland">* Midtjylland</option>' +
                    '<option value="Sønderjylland">* Sønderjylland</option>' +
                    '<option value="Fyn">* Fyn</option>' +
                    '<option value="Sjælland">* Sjælland</option>' +
                    '</select><br>' +

                    '<label class="pull-left" for="supervisorAge">Alder</label><Br>' +
                    '<input id="supervisorAge" class="swal2-input" placeholder="Alder" value="' + this.age + '">' +
                    '<label class="pull-left" for="trained_leader">Supervisoruddannet</label><Br>' +
                    '<div class="managingTrainedLeader">' +
                    '<label class="radio-inline"><input id="trained_leader_ja" type="radio"  value="1" name="optradio">ja</label>' +
                    '<label class="radio-inline"><input id="trained_leader_nej" type="radio"  value="0" name="optradio">nej</label>' +
                    '</div><br>' +

                    '<label class="pull-left" for="primary_education">Specialistuddannelse</label><Br><Br>' +
                    '<select class="form-control" id="primary_education">' +
                    '<option value="none" selected="selected">ingen</option>' +

                    '<option disabled></option>' +
                    '<option disabled class="bold">Børnepsykologi:</option>' +
                    '<option value="Sundhedspsykologi med børn">* Sundhedspsykologi med børn</option>' +
                    '<option value="Psykoterapi med børn">* Psykoterapi med børn</option>' +
                    '<option value="Klinisk børnepsykologi">* Klinisk børnepsykologi</option>' +
                    '<option value="Klinisk børneneuropsykologi">* Klinisk børneneuropsykologi</option>' +
                    '<option value="Pædagogisk psykologi">* Pædagogisk psykologi</option>' +

                    '<option disabled></option>' +
                    '<option disabled class="bold">Voksenpsykologi:</option>' +
                    '<option value="Sundhedspsykologi med voksne">* Sundhedspsykologi med voksne</option>' +
                    '<option value="Psykoterapi med voksne">* Psykoterapi med voksne</option>' +
                    '<option value="Psykopatologi">* Psykopatologi</option>' +
                    '<option value="Psykotraumatologi">* Psykotraumatologi</option>' +
                    '<option value="Klinisk Neuropsykologi">* Klinisk Neuropsykologi</option>' +
                    '<option value="Gerontopsykologi">* Gerontopsykologi</option>' +
                    '<option disabled></option>' +
                    '<option disabled class="bold">Arbejds- og organisationspsykologi:</option>' +
                    '<option value="Arbejds- og organisationspsykologi">* Arbejds- og organisationspsykologi</option>' +
                    '</select><br>' +
//                    '<label class="pull-left" for="secondary_education">Specialistuddannelse secondary</label><Br><Br>' +
                    '<select class="form-control" id="secondary_education">' +
                    '<option value="none" selected="selected">ingen</option>' +
                    
                    '<option disabled></option>' +
                    '<option disabled class="bold">Børnepsykologi:</option>' +
                    '<option value="Sundhedspsykologi med børn">* Sundhedspsykologi med børn</option>' +
                    '<option value="Psykoterapi med børn">* Psykoterapi med børn</option>' +
                    '<option value="Klinisk børnepsykologi">* Klinisk børnepsykologi</option>' +
                    '<option value="Klinisk børneneuropsykologi">* Klinisk børneneuropsykologi</option>' +
                    '<option value="Pædagogisk psykologi">* Pædagogisk psykologi</option>' +
                    
                    '<option disabled></option>' +
                    '<option disabled class="bold">Voksenpsykologi:</option>' +
                    '<option value="Sundhedspsykologi med voksne">* Sundhedspsykologi med voksne</option>' +
                    '<option value="Psykoterapi med voksne">* Psykoterapi med voksne</option>' +
                    '<option value="Psykopatologi">* Psykopatologi</option>' +
                    '<option value="Psykotraumatologi">* Psykotraumatologi</option>' +
                    '<option value="Klinisk Neuropsykologi">* Klinisk Neuropsykologi</option>' +
                    '<option value="Gerontopsykologi">* Gerontopsykologi</option>' +
                    
                    '<option disabled></option>' +
                    '<option disabled class="bold">Arbejds- og organisationspsykologi:</option>' +
                    '<option value="Arbejds- og organisationspsykologi">* Arbejds- og organisationspsykologi</option>' +
                    '</select><br>' +


//                    '<label class="pull-left" for="third_education">Specialistuddannelse third</label><Br><Br>' +
                    '<select class="form-control" id="third_education">' +
                    '<option value="none" selected="selected">ingen</option>' +
                    
                    '<option disabled></option>' +
                    '<option disabled class="bold">Børnepsykologi:</option>' +
                    '<option value="Sundhedspsykologi med børn">* Sundhedspsykologi med børn</option>' +
                    '<option value="Psykoterapi med børn">* Psykoterapi med børn</option>' +
                    '<option value="Klinisk børnepsykologi">* Klinisk børnepsykologi</option>' +
                    '<option value="Klinisk børneneuropsykologi">* Klinisk børneneuropsykologi</option>' +
                    '<option value="Pædagogisk psykologi">* Pædagogisk psykologi</option>' +
                    
                    '<option disabled></option>' +
                    '<option disabled class="bold">Voksenpsykologi:</option>' +
                    '<option value="Sundhedspsykologi med voksne">* Sundhedspsykologi med voksne</option>' +
                    '<option value="Psykoterapi med voksne">* Psykoterapi med voksne</option>' +
                    '<option value="Psykopatologi">* Psykopatologi</option>' +
                    '<option value="Psykotraumatologi">* Psykotraumatologi</option>' +
                    '<option value="Klinisk Neuropsykologi">* Klinisk Neuropsykologi</option>' +
                    '<option value="Gerontopsykologi">* Gerontopsykologi</option>' +
                    
                    '<option disabled></option>' +
                    '<option disabled class="bold">Arbejds- og organisationspsykologi:</option>' +
                    '<option value="Arbejds- og organisationspsykologi">* Arbejds- og organisationspsykologi</option>' +
                    '</select><br>' +

                    ` <label class="pull-left">Teoretisk præference</label><Br><Br>
                              <div class="text-left">
                                 <input type="checkbox" id="Eksistentiel_humanistisk" >
                                 <label  for="Eksistentiel_humanistisk">Eksistentiel/humanistisk</label><br>

                                 <input type="checkbox" id="Kognitiv_adfærdsterapeutisk" >
                                 <label  for="Kognitiv_adfærdsterapeutisk">Kognitiv/ adfærdsterapeutisk</label><br>

                                 <input type="checkbox" id="Psykodynamisk_psykoanalytisk" >
                                 <label  for="Psykodynamisk_psykoanalytisk">Psykodynamisk/psykoanalytisk</label><br>

                                 <input type="checkbox" id="Systemisk_strukturel" >
                                 <label  for="Systemisk_strukturel">Systemisk/strukturel</label><br>
                            </div>
                            `
                    ,
                    onOpen: function () {
                        if (mainData.trained_leader == 1) {
                            document.getElementById('trained_leader_ja').checked = true;
                        } else {
                            document.getElementById('trained_leader_nej').checked = true;
                        }

                        document.querySelector('#city [value="' + mainData.city + '"]').selected = true;
                        console.log(mainData.primary_education)
                        document.querySelector('#primary_education [value="' + mainData.primary_education + '"]').selected = true;
                        document.querySelector('#secondary_education [value="' + mainData.secondary_education + '"]').selected = true;
                        document.querySelector('#third_education [value="' + mainData.third_education + '"]').selected = true;

                        if (mainData.Eksistentiel_humanistisk) {
                            document.getElementById('Eksistentiel_humanistisk').checked = true;
                        } else {
                            document.getElementById('Eksistentiel_humanistisk').checked = false;
                        }
                        if (mainData.Kognitiv_adfærdsterapeutisk) {
                            document.getElementById('Kognitiv_adfærdsterapeutisk').checked = true;
                        } else {
                            document.getElementById('Kognitiv_adfærdsterapeutisk').checked = false;
                        }
                        if (mainData.Psykodynamisk_psykoanalytisk) {
                            document.getElementById('Psykodynamisk_psykoanalytisk').checked = true;
                        } else {
                            document.getElementById('Psykodynamisk_psykoanalytisk').checked = false;
                        }
                        if (mainData.Systemisk_strukturel) {
                            document.getElementById('Systemisk_strukturel').checked = true;
                        } else {
                            document.getElementById('Systemisk_strukturel').checked = false;
                        }

                    },
                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            if (true) {
                                var city_list = document.getElementById("city");
                                var primary_education_list = document.getElementById("primary_education");
                                var secondary_education_list = document.getElementById("secondary_education");
                                var third_education_list = document.getElementById("third_education");
                                var city = city_list.options[city_list.selectedIndex].value;
                                var primary_education = primary_education_list.options[primary_education_list.selectedIndex].value;
                                var secondary_education = secondary_education_list.options[secondary_education_list.selectedIndex].value;
                                var third_education = third_education_list.options[third_education_list.selectedIndex].value;
                                if (document.getElementById('supervisorName').value != ''
                                    && document.getElementById('supervisorSurname').value != ''
                                    && document.getElementById('supervisorAge').value != ''
                                ) {
                                    resolve([
                                        document.getElementById('supervisorName').value,
                                        document.getElementById('supervisorSurname').value,
                                        document.getElementById('supervisorAge').value,
                                        document.querySelector('input[name="optradio"]:checked').value,
                                        city,
                                        primary_education,
                                        secondary_education,
                                        third_education
                                    ]);
                                }
                                else {
                                    swal('Fejl', 'Felt kan ikke være tom!', 'error');
                                }
                            }
                        });
                    }
                }).then(function (result) {
                    
                    var name = result[0];
                    var surname = result[1];
                    var age = result[2];
                    var trained_leader = result[3];
                    var city = result[4];
                    var primary_education = result[5];
                    var secondary_education = result[6];
                    var third_education = result[7];


                    mainData.Eksistentiel_humanistisk = document.getElementById('Eksistentiel_humanistisk').checked;
                    mainData.Kognitiv_adfærdsterapeutisk = document.getElementById('Kognitiv_adfærdsterapeutisk').checked;
                    mainData.Psykodynamisk_psykoanalytisk = document.getElementById('Psykodynamisk_psykoanalytisk').checked;
                    mainData.Systemisk_strukturel = document.getElementById('Systemisk_strukturel').checked;

                    let data = {
                        supervisionId: mainData.supervisionId,
                        name: name,
                        surname: surname,
                        age: age,
                        city: city,
                        trained_leader: trained_leader,
                        primary_education: primary_education,
                        secondary_education: secondary_education,
                        third_education: third_education,
                        Eksistentiel_humanistisk: mainData.Eksistentiel_humanistisk,
                        Kognitiv_adfærdsterapeutisk: mainData.Kognitiv_adfærdsterapeutisk,
                        Psykodynamisk_psykoanalytisk: mainData.Psykodynamisk_psykoanalytisk,
                        Systemisk_strukturel: mainData.Systemisk_strukturel,
                    };
                    console.log(data);
                    axios.patch('/updateSupervisionMainInfo', data)
                        .then(function (response) {
                            mainData.supervisorName = name;
                            mainData.supervisorSurname = surname;
                            mainData.age = age;
                            mainData.city = city;
                            mainData.primary_education = primary_education;
                            mainData.secondary_education = secondary_education;
                            mainData.third_education = third_education;
                            mainData.trained_leader = trained_leader;

                            swal('Godt arbejde', 'Data, ændret!', 'success').then(function(){
                                window.location.reload();
                            })
                            
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                });
            }
            ,
            editAddress()
            {
                var mainData = this;
                swal({
                    title: 'Skift address',
                    showCancelButton: true,
                    html: '<label class="pull-left" for="supervisorNameAddress">Kliniknavn </label><Br>' +
                    '<input id="supervisorNameAddress" class="swal2-input"  placeholder="Kliniknavn " value="' + this.addressName + '"><br>' +
                    '<label class="pull-left" for="supervisorVej">Vej</label><Br>' +
                    '<input id="supervisorVej" class="swal2-input"  placeholder="Vej" value="' + this.roadName + '"><br>' +
                    '<label class="pull-left" for="supervisorPostNumber">Postnummer</label><Br>' +
                    '<input id="supervisorPostNumber" class="swal2-input"  placeholder="Postnummer" value="' + this.postNumber + '"><br>' +
                    '<label class="pull-left" for="supervisorByAddress">By</label><Br>' +
                    '<input id="supervisorByAddress" class="swal2-input"  placeholder="By" value="' + this.byAddress + '"><br>',
                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            if (true) {
                                if (document.getElementById('supervisorNameAddress').value != ''
                                    && document.getElementById('supervisorVej').value != ''
                                    && document.getElementById('supervisorPostNumber').value != ''
                                    && document.getElementById('supervisorByAddress').value != ''

                                ) {
                                    resolve([
                                        document.getElementById('supervisorNameAddress').value,
                                        document.getElementById('supervisorVej').value,
                                        document.getElementById('supervisorPostNumber').value,
                                        document.getElementById('supervisorByAddress').value,
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
                    let data = {
                        user_id: mainData.supervisionId,
                        addressName: addressName,
                        roadName: roadName,
                        postNumber: postNumber,
                        byAddress: byAddress,
                    };
                    axios.patch('/updateUserAddress', data)
                        .then(function (response) {
                            mainData.addressName = addressName;
                            mainData.roadName = roadName;
                            mainData.postNumber = postNumber;
                            mainData.byAddress = byAddress;
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
                    title: 'Skift Email',
                    showCancelButton: true,
                    html: '<label class="pull-left" for="supervisorEmail">Email</label><Br>' +
                    '<input id="supervisorEmail" class="swal2-input" autofocus placeholder="Email" value="' + this.email + '">' +
                    '<label class="pull-left" for="supervisorPhone">Phone</label><Br>' +
                    '<input id="supervisorPhone" class="swal2-input" placeholder="Phone" value="' + (this.phone ? this.phone : 'eks.: 87 65 43 21') + '">',
                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            if (true) {
                                if (document.getElementById('supervisorEmail').value != '' 
                                    && document.getElementById('supervisorPhone').value != '') {
                                    resolve([
                                        document.getElementById('supervisorEmail').value,
                                        document.getElementById('supervisorPhone').value
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
            editFormType()
            {
                var mainData = this;
                swal({
                    title: 'Tilbyder former for supervision',
                    showCancelButton: true,
                    html: `
                <div class="text-left">
                    <input type="checkbox" id="Ansigt_till" >
                    <label  for="Ansigt_till">Ansigt-til-ansigt</label><br>

                    <input type="checkbox" id="Live_Video" >
                    <label  for="Live_Video">Live Video/Audio </label><br>

                    <input type="checkbox" id="Gruppesupervision" >
                    <label  for="Gruppesupervision">Gruppesupervision</label><br>

                    <input type="checkbox" id="Enkeltsupervision" >
                    <label  for="Enkeltsupervision">Enkeltsupervision</label><br>

                    <input type="checkbox" id="Egenterapi_Personligt" >
                    <label  for="Egenterapi_Personligt">Egenterapi/Personligt udviklingsarbejde</label><br>
                </div>
                    `,
                    onOpen: function () {
                        if (mainData.Ansigt_till) {
                            document.getElementById('Ansigt_till').checked = true;
                        } else {
                            document.getElementById('Ansigt_till').checked = false;
                        }
                        if (mainData.Live_Video) {
                            document.getElementById('Live_Video').checked = true;
                        } else {
                            document.getElementById('Live_Video').checked = false;
                        }
                        if (mainData.Gruppesupervision) {
                            document.getElementById('Gruppesupervision').checked = true;
                        } else {
                            document.getElementById('Gruppesupervision').checked = false;
                        }
                        if (mainData.Enkeltsupervision) {
                            document.getElementById('Enkeltsupervision').checked = true;
                        } else {
                            document.getElementById('Enkeltsupervision').checked = false;
                        }
                        if (mainData.Egenterapi_Personligt) {
                            document.getElementById('Egenterapi_Personligt').checked = true;
                        } else {
                            document.getElementById('Egenterapi_Personligt').checked = false;
                        }
                    },


                }).then(function (result) {
                    mainData.Ansigt_till = document.getElementById('Ansigt_till').checked;
                    mainData.Live_Video = document.getElementById('Live_Video').checked;
                    mainData.Gruppesupervision = document.getElementById('Gruppesupervision').checked;
                    mainData.Enkeltsupervision = document.getElementById('Enkeltsupervision').checked;
                    mainData.Egenterapi_Personligt = document.getElementById('Egenterapi_Personligt').checked;

                    let data = {
                        user_id: mainData.supervisionId,
                        Ansigt_till: mainData.Ansigt_till,
                        Live_Video: mainData.Live_Video,
                        Gruppesupervision: mainData.Gruppesupervision,
                        Enkeltsupervision: mainData.Enkeltsupervision,
                        Egenterapi_Personligt: mainData.Egenterapi_Personligt,
                    };

                    axios.patch('/updateSupervisionTypes', data)
                        .then(function (response) {
                            console.log(response);
                            swal('Godt arbejde', 'Data, ændret!', 'success');
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                })
            },
            editSpecialistbevisEvent()
            {
                this.editSpecialistbevis = !this.editSpecialistbevis;
            },
            changeDropDownSelectSupervisorPreparation()
            {
                this.changeColorSelect($('#special_preparation'), $('#special_preparation').val());
            },
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
            },
            uploadFile(event)
            {
                this.file = event.target.files[0];
            },
            uploadSpecialistbevis()
            {
                var mainData = this;
                var fileData = new FormData()
                fileData.append('file', this.file);
                fileData.append('user_id', mainData.supervisionId);
                fileData.append('specialisation', this.special_preparation_selected);
                axios.post('/addSupervisionSpecialisation', fileData)
                    .then(function (response) {
                        console.log(response.data)
                        mainData.supervisor_specialisation.push({
                            id: response.data.file_id,
                            file_name: response.data.file_name,
                            path_to_file: response.data.path_to_file,
                            specialisation: response.data.specialisation,
                        });
                        mainData.file = null;
                        document.getElementById("specialisationFile").value = "";
                        mainData.special_preparation_selected = 'default';
                        swal('Godt arbejde', 'Data, ændret!', 'success');
                    })
                    .catch(function (error) {
                        swal('Fejl!', 'Fejl ved indlæsning af fil!', 'error')
                    });
            },
            deleteSpecialisation(id)
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
                    axios.delete('/deleteSpecialisation', {params: data})
                        .then(function (response) {
                            $.each(mainData.supervisor_specialisation, function (i) {
                                if (mainData.supervisor_specialisation[i].id === id) {
                                    mainData.supervisor_specialisation.splice(i, 1);
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
                            $.each(mainData.supervisorPictures, function (i) {
                                if (mainData.supervisorPictures[i].id === id) {
                                    mainData.supervisorPictures.splice(i, 1);
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
                            $.each(mainData.supervisorVideos, function (i) {
                                if (mainData.supervisorVideos[i].id === id) {
                                    mainData.supervisorVideos.splice(i, 1);
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
                    html: '<label class="pull-left" for="supervisorWebsite">Hjemmeside</label><Br>' +
                    '<input id="supervisorWebsite" class="swal2-input" autofocus placeholder="http://www.eksempel.dk" value="' + this.website + '">',
                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            if (true) {
                                if (document.getElementById('supervisorWebsite').value != '') {
                                    resolve(
                                        document.getElementById('supervisorWebsite').value
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
                        supervisionId: mainData.supervisionId,
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

    }
</script>
<style scoped>
    #quill-container {
        height: 200px;
    }
</style>