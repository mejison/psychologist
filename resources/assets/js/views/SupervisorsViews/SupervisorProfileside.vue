<template>
    <article class="content-block-profil content-block container-fluid">
        <div class="row border-row">
            <div class="col-md-6">
                <h3>SUPERVISOR PROFILSIDE</h3>
            </div>
            <div class="col-md-6">
                <div class="btn-wrapper pull-right">
                    <button type="submit" @click="addToMineList" data-toggle="tooltip" data-placement="top"
                            title="Gem til mine supervisorer" class="btn btn-primary supervisor-btn"><img
                            class="download" src="/image/person.png" alt="person"></button>
                    <button type="submit" @click="addToFavoriteList" data-toggle="tooltip" data-placement="top"
                            title="Gem til mine favoritter"
                            class="btn btn-primary supervisor-btn"><img class="download" src="/image/favorit.png"
                                                                        alt="favorit"></button>
                    <button type="submit" @click="redirectBack" class="btn btn-primary text-btn"><img class="download"
                                                                                                      src="/image/left-arrow.png"
                                                                                                      alt="favorit">tilbage
                        til søgning
                    </button>
                </div>
            </div>
        </div>
        <div class="row bio-row">
            <div class="col-md-6">
                <div class="img-wrapper">
                    <img :src="user_avatar" style="width: 691px;height: 403px" class="img-responsive" alt="avatar">
                </div>
            </div>
            <div class="col-md-6 text-wrapper">
                <div class="bio-info" style="transform: translateY(0);">
                    <h5>{{supervisorName}} {{supervisorSurname}}</h5>
                    <p><b>Praksis belligenhed : </b> {{city}}</p>
                    <p><b>Alder : </b>{{age}}</p>

                    <p v-show="primary_education!='none'||secondary_education!='none'||third_education!='none'"><b>Uddannelse i:</b></p>
                    <p v-show="primary_education!='none'">{{primary_education}}</p>
                    <p v-show="secondary_education!='none'">{{secondary_education}}</p>
                    <p v-show="third_education!='none'">{{third_education}}</p>

                    <p>
                        <p  v-show="Systemisk_strukturel||Eksistentiel_humanistisk||Kognitiv_adfærdsterapeutisk||Psykodynamisk_psykoanalytisk">
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
                        <li>{{by_address}}</li>
                    </ul>
                </address>
            </div>
            <div class="col-md-6">
                <address>
                    <ul class="contact-list">
                        <li><strong>Kontaktes på:</strong></li>
                        <li>email: {{email}}</li>
                        <li>tlf: {{phone}}</li>
                    </ul>
                </address>
            </div>
        </div>
        <div class="row address-wrapper">
            <div class="col-md-6 text-fritekst">
                <div class="link-wrapper">
                    <ul class="link-list">
                        <li><strong>Hjemmeside:</strong></li>
                        <a @click="addVisitWebPage()" target="_blank" :href="website">{{website}}</a>
                    </ul>
                    <!--<div class="text-center">-->
                        <!--<a @click="addVisitWebPage()" target="_blank" :href="website"> <img class="websitePathImg" :src="websitePath"-->
                                                                 <!--alt="screensite"></a>-->
                    <!--</div>-->
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
            </div>
        </div>
        <div class="specialist-wrapper">
            <div class="row">
                <div class="col-md-2 headline-block">
                    <p>specialistbevis:</p>
                </div>
                <div v-for="spec in supervisor_specialisation">
                    <div class="col-md-2 text-center">
                        <a :href="spec.path_to_file" target="_blank"><img src="/image/list-ico.png" alt="avatar"></a>
                        <p>{{spec.specialisation}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row profile-info">
            <div class="col-md-12">
                <p>
                    <strong>Fritekst / præsentation:</strong><p v-html="presentation_description"></p>
                </p>
            </div>
        </div>
        <div class="row builder-row">
            <div class="col-md-1">
                <p>BILLEDER</p>
            </div>

            <div class="col-md-11">
                <div class="row">
                    <div class="col-md-2" v-for="(picture,index) in supervisorPictures">
                        <div class="item-box text-center">
                            <div class="avatar-section">
                                <img class="managingPictures" :src="picture.path_to_file" alt="avatar"
                                     @click="getPopUpPicture(index)">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row builder-row">
            <div class="col-md-1">
                <p>VIDEO</p>
            </div>
            <div  class="col-md-11">
                <div class="row">
                    <div class="col-md-2" v-for="(video, index) in supervisorVideos">
                        <div class="item-box text-center">
                            <div class="avatar-section">
                                
                                <!-- <video class="managingPictures" @click="getPopUpVideo(index)">
                                    <source :src="video.path_to_file" type="video/mp4">
                                </video> -->

                                <div>
                                    <video v-if=" ! (video.path_to_file.indexOf('youtube') + 1)" muted class="managingPictures" controls>
                                        <source :src="video.path_to_file" type="video/mp4">
                                    </video>
                                </div>
                                <div>
                                    <iframe width="420" height="315" muted v-if="video.path_to_file.indexOf('youtube') + 1" class="managingPictures" :src=" 'https://www.youtube.com/embed/' + video.path_to_file.replace('https://www.youtube.com/watch?v=', '').split('&').shift()"></iframe>
                                </div>
                        

                            </div>
                        </div>
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


        <modal :showModal="showModalVideo" :closeAction="closeModalVideo">
            <div slot="body" class="text-center">
                <slider animation="fade" :auto="false" :indicators="false" :control-btn="center"
                        :init-index="startSlideVideo">
                    <slider-item v-for="(video, index) in supervisorVideos" :key="startSlideVideo">
                        
                        <!-- <div v-if=" ! (video.path_to_file.indexOf('youtube') + 1 )">
                            <video width="568" height="300" controls>
                                <source :src="video.path_to_file" type="video/mp4">
                            </video>
                        </div>

                        <div v-if="(video.path_to_file.indexOf('youtube') + 1 )">
                            <div v-html="video.path_to_file"></div>
                            <iframe width="420" height="315" src="https://www.youtube.com/embed/" :src="video.path_to_file.replace("", "")">
                            </iframe>
                        </div> -->

                        <div>
                            <video v-if=" ! (video.path_to_file.indexOf('youtube') + 1)" muted class="managingPictures" controls>
                                <source :src="video.path_to_file" type="video/mp4">
                            </video>
                        </div>
                        <div>
                            <iframe width="420" height="315" muted v-if="video.path_to_file.indexOf('youtube') + 1" class="managingPictures" :src=" 'https://www.youtube.com/embed/' + video.path_to_file.replace('https://www.youtube.com/watch?v=', '').split('&').shift()"></iframe>
                        </div>
                        


                    </slider-item>
                </slider>
            </div>
        </modal>
    </article>
</template>

<script>
    import Modal from 'modal-vue';
    import {Slider, SliderItem} from 'vue-easy-slider'

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
                by_address: '',
                website: '',
                websitePath: '',
                supervisorPictures: [],
                supervisorVideos: [],

                Ansigt_till: false,
                Live_Video: false,
                Gruppesupervision: false,
                Enkeltsupervision: false,
                Egenterapi_Personligt: false,

                primary_education:"",
                secondary_education :"",
                third_education:"",

                addressName :"",
                roadName :"",
                postNumber:"",

                Eksistentiel_humanistisk: false,
                Kognitiv_adfærdsterapeutisk: false,
                Psykodynamisk_psykoanalytisk: false,
                Systemisk_strukturel: false,

                supervisor_specialisation: [],

                showModalImage: false,
                startSlidePicture: null,
                showModalVideo: false,
                startSlideVideo: null,
                urlVideo: '',
                city: ''
            }
        }
        ,
        //        when component created get info about user
        created: function () {
//            tooltip initialization
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();

            })
            let supervisionsId = (this.$route.params.idSupervision);
            let data = {
                supervisionsId: supervisionsId
            };
            let mainData = this;
            axios.post('/getUserRoleSupervisionInformation', data)
                    .then(function (response) {
//                        if user has free version
                        if (response.data.user.full_info_about_user.version != 'pro') {
                            mainData.$router.push('/profilesideSupervisiorFree/' + supervisionsId);
                        }
                        //supervisor info block begin
                        mainData.supervisionId = response.data.user.id;
                        mainData.supervisorName = response.data.user.name;
                        mainData.supervisorSurname = response.data.user.surname;
                        mainData.special_preparation = response.data.user.full_info_about_user.special_preparation;
                        mainData.address = response.data.user.full_info_about_user.address;
                        mainData.email = response.data.user.email;
                        mainData.city = response.data.user.full_info_about_user.city;
                        mainData.phone = response.data.user.full_info_about_user.phone;

                        mainData.by_address = response.data.supervision_address.by_address;
                        
                        mainData.age = response.data.user.full_info_about_user.age;
                        mainData.trained_leader = response.data.user.full_info_about_user.trained_leader;
                        mainData.user_avatar = response.data.user.full_info_about_user.avatar_path != null ? response.data.user.full_info_about_user.avatar_path : '/image/admin-icon.png';
                        mainData.presentation_description = response.data.user.full_info_about_user.presentation;
                        mainData.website = response.data.user.full_info_about_user.website;
                        mainData.websitePath = response.data.user.full_info_about_user.pathWebsiteScreen;

                        //supervisor types block
                        if (response.data.supervision_types) {
                            mainData.Ansigt_till = response.data.supervision_types.Ansigt_till;
                            mainData.Live_Video = response.data.supervision_types.Live_Video;
                            mainData.Gruppesupervision = response.data.supervision_types.Gruppesupervision;
                            mainData.Enkeltsupervision = response.data.supervision_types.Enkeltsupervision;
                            mainData.Egenterapi_Personligt = response.data.supervision_types.Egenterapi_Personligt;
                        }


                        //supervisor educations data block
                        mainData.primary_education = response.data.supervision_educations.primary_education;
                        mainData.secondary_education = response.data.supervision_educations.secondary_education;
                        mainData.third_education = response.data.supervision_educations.third_education;

                        //supervisor address data block
                        mainData.addressName = response.data.supervision_address.address_name;
                        mainData.roadName = response.data.supervision_address.road_name;
                        mainData.postNumber = response.data.supervision_address.post_number;


                        //supervisor speciality/interest  block
                        mainData.Eksistentiel_humanistisk = response.data.supervision_speciality.Eksistentiel_humanistisk;
                        mainData.Kognitiv_adfærdsterapeutisk = response.data.supervision_speciality.Kognitiv_adfærdsterapeutisk;
                        mainData.Psykodynamisk_psykoanalytisk = response.data.supervision_speciality.Psykodynamisk_psykoanalytisk;
                        mainData.Systemisk_strukturel = response.data.supervision_speciality.Systemisk_strukturel;

                        //Supervisor specialisation
                        mainData.supervisor_specialisation = response.data.supervision_specialisation;
                        //Supervisor pictures
                        mainData.supervisorPictures = response.data.supervisorPictures;
                        //Supervisor videos
                        mainData.supervisorVideos = response.data.supervisorVideos;

                        //add profile visitor
                        mainData.addVisitor();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
        }
        ,
        components: {
            Modal,
            Slider,
            SliderItem

        },
        methods: {
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
            closeModalVideo(){
                this.showModalVideo = false;
            },
            addVisitWebPage(){
                let params = {
                    userId: this.supervisionId
                };
                axios.patch('/addProfileWebPageVisitor', params)
                        .then(function (response) {
                            console.log(response);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
            },
            addVisitor(){
                let mainData = this;
//                if user haven't cookie PSYCHOLOGY_VISITED with current supervisor
                if (!this.getCookie('PSYCHOLOGY_VISITED_'+mainData.supervisionId)) {
                    var date = new Date;
//                        set cookie +7 days
                    date.setDate(date.getDate() + 7);
                    document.cookie = "PSYCHOLOGY_VISITED_"+mainData.supervisionId+"=visited; path=/; expires=" + date.toUTCString();
//                        add visitor id
                    let params = {
                        visitorId: mainData.supervisionId
                    };
                    axios.patch('/addProfileVisitor', params)
                            .then(function (response) {
                                console.log(response);
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                }
            },
            getCookie(name) {
                var matches = document.cookie.match(new RegExp(
                        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
                ));
                return matches ? decodeURIComponent(matches[1]) : undefined;
            },
            addToMineList(){
                let data = {
                    supervisionsId: this.supervisionId
                };
                axios.post('/addToMineList', data)
                        .then(function (response) {
                            swal('Succes!', 'Vejledere tilføjet til listen!', 'success');
                        })
                        .catch(function (error) {
                            swal('Fejl', 'Vejledere allerede på din liste!', 'error');
                        });
            },
            addToFavoriteList(){
                let data = {
                    supervisionsId: this.supervisionId
                };
                axios.post('/addToFavoriteList', data)
                        .then(function (response) {
                            swal('Succes!', 'Vejledere tilføjet til listen!', 'success');
                        })
                        .catch(function (error) {
                            swal('Fejl', 'Vejledere allerede på din liste!', 'error');
                        });
            },
//              check user error
            redirectBack(){
                this.$router.back();
            },
            hasError(field)
            {
                return this.errors[field] !== undefined;
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
            getError(field)
            {
                if (this.errors[field]) {
                    return this.errors[field][0];
                }
            }
            ,
        }
    }


</script>
