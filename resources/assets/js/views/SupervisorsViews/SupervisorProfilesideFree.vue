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
                <div class="bio-info-free">
                    <h5>{{supervisorName}} {{supervisorSurname}}</h5>
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
                    </ul>
                </address>

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

            </div>
        </div>
        <div class="row address-wrapper">
            <div class="col-md-6 text-fritekst">
                <p><strong>Fritekst / præsentation:</strong><p v-html="presentation_description"></p></p>

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
            <div class="row list-wrapper">
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
    </article>
</template>

<script>
    import myDatepicker from 'vue-datepicker';
    import vueSlider from 'vue-slider-component';
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
            }
        }
        ,
        //        when component created get info about user
        created: function () {

            //            tooltip initialization
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();

            });
            let supervisionsId = (this.$route.params.idSupervision);
            let data = {
                supervisionsId: supervisionsId
            };
            let mainData = this;
            axios.post('/getUserRoleSupervisionInformation', data)
                    .then(function (response) {
                        if (response.data.user.full_info_about_user.version != 'free') {
                            mainData.$router.push('/profilesideSupervisior/' + supervisionsId);
                        }
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
                        mainData.presentation_description = response.data.user.full_info_about_user.presentation;

                        if(mainData.presentation_description.length >=450){
                            mainData.presentation_description = mainData.presentation_description.substring(0,450);
                        }
                        //supervisor info block end

                        //supervisor types block
                        if (response.data.supervision_types) {
                            mainData.Ansigt_till = response.data.supervision_types.Ansigt_till;
                            mainData.Live_Video = response.data.supervision_types.Live_Video;
                            mainData.Gruppesupervision = response.data.supervision_types.Gruppesupervision;
                            mainData.Enkeltsupervision = response.data.supervision_types.Enkeltsupervision;
                            mainData.Egenterapi_Personligt = response.data.supervision_types.Egenterapi_Personligt;

                        }
                        
                        //supervisor address data block
                        mainData.addressName = response.data.supervision_address.address_name;
                        mainData.roadName = response.data.supervision_address.road_name;
                        mainData.postNumber = response.data.supervision_address.post_number;

                        //supervisor educations data block
                        mainData.primary_education = response.data.supervision_educations.primary_education;
                        mainData.secondary_education = response.data.supervision_educations.secondary_education;
                        mainData.third_education = response.data.supervision_educations.third_education;

                        //supervisor speciality/interest  block
                        mainData.Eksistentiel_humanistisk = response.data.supervision_speciality.Eksistentiel_humanistisk;
                        mainData.Kognitiv_adfærdsterapeutisk = response.data.supervision_speciality.Kognitiv_adfærdsterapeutisk;
                        mainData.Psykodynamisk_psykoanalytisk = response.data.supervision_speciality.Psykodynamisk_psykoanalytisk;
                        mainData.Systemisk_strukturel = response.data.supervision_speciality.Systemisk_strukturel;


                        //Supervisor specialisation
                        mainData.supervisor_specialisation = response.data.supervision_specialisation;
                        //add profile visitor
                        mainData.addVisitor();

                    })
                    .catch(function (error) {
                        console.log(error);
                    });
        }
        ,
        methods: {
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


        }
    }


</script>