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
                        <p>Free</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row bio-row">
            <div class="col-md-6">
                
                    <h5>{{ course_name }}</h5>
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
                    <p>
                        <b>Til specialistuddannelse : </b><span v-for="sp in special_preparation">{{ sp }}, </span>
                    </p>
                
                <div v-show="showEditForm">
                    <div class="picture-wrapper bio-edit text-center">
                        <a href="javascript:;" @click="editCourseMainInfo()">
                            <img class="edit-pic" src="/image/edit-ico.png" alt="edit">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-wrapper">
                <a href="javascript:;" id="popUpOpretNySupervisor"
                   class="btn btn-primary-outline pull-right"
                   @click="showEditPencils">
                    Rediger oplysninger
                </a>
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
                        <li>
                            <strong>Hjemmeside:</strong>
                        </li>
                        <a target="_blank" :href="website">{{ website }}</a>
                    </ul>
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
                        <span v-for="teacher in courseTeachers">{{ teacher.teacher_name }}
                        <img class="SupervisorSpecialistbevisTrash"
                            src="/image/vector-smart-trash-white.png" alt="delete"
                            @click="deleteCourseTeacher(teacher.id)" />
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
            <div class="col-md-6 text-fritekst">
                <p>
                    <!--here-->
                    <strong>Fritekst / præsentation:</strong>
                <p class="pre-style" v-html="presentation_description.slice(0, 350) + (presentation_description.length > 350 ? ' ...' : '')"></p>
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
        </div>
    </article>
</template>

<script>
    
    import Dropzone from 'vue2-dropzone';
    import Modal from 'modal-vue';
    import {Slider, SliderItem} from 'vue-easy-slider';
    import Datepicker from 'vue-datepicker';
    import { VueEditor } from 'vue2-editor'

    export default {
//        Collect information to vue.data
        data()
        {
            return {
                toggle_date : 1,
                supervisionId: null,
                supervisorName: "",
                supervisorSurname: "",
                special_preparation: "",
                age: 0,
                website: '',
                websitePath: '',
                trained_leader: null,
                address: "",
                email: "",
                phone: "",
                presentation_description: "",
                form_type: "",
                showEditForm: false,
                city:"",
                addressName :"",
                courseTeachers: [],
                roadName :"",
                postNumber:"",
                byAddress:"",

                course_name: "",
                course_number: "",
                course_date: "",
                course_hours: "",
                course_approved: null,
                course_price: "",
                center: "",

                Arbejds_og_organisationspsykologi: false,
                Børnemodulet: false,
                Voksenmodulet: false,
                Det_tværgående: false,
                Forsknings_og_formidlingsmodulet: false,
                Specialiseringsmodulerne: false,

                primary_education:"",
                secondary_education :"",
                third_education:"",

                Ansigt_till: false,
                Live_Video: false,
                Gruppesupervision: false,
                Enkeltsupervision: false,
                Egenterapi_Personligt:false,


                Eksistentiel_humanistisk: false,
                Kognitiv_adfærdsterapeutisk: false,
                Psykodynamisk_psykoanalytisk: false,
                Systemisk_strukturel: false,

                showEditPresentationForm:false,
    
                supervisor_specialisation: [],
                editSpecialistbevis: false,
                file: null,
                special_preparation_selected: 'default',
                options: [
                    {text: 'Vælg specialistuddannelse', value: 'default'},
                    {text: 'Børnepsykologi: ', value: 0},
                    {text: '   * Sundhedspsykologi med børn', value: 'Sundhedspsykologi med børn'},
                    {text: '   * Psykoterapi med børn', value: 'Psykoterapi med børn'},
                    {text: '   * Klinisk børnepsykologi', value: 'Klinisk børnepsykologi'},
                    {text: '   * Klinisk børneneuropsykologi', value: 'Klinisk børneneuropsykologi'},
                    {text: '   * Pædagogisk psykologi', value: 'Pædagogisk psykologi'},
                    {text: 'Voksenpsykologi: ', value: 0},
                    {text: '   * Specialist i psykotraumatologi', value: 'Specialist i psykotraumatologi'},
                    {text: '   * Sundhedspsykologi med voksne', value: 'Sundhedspsykologi med voksne'},
                    {text: '   * Psykoterapi med voksne', value: 'Psykoterapi med voksne'},
                    {text: '   * Psykopatologi', value: 'Psykopatologi'},
                    {text: '   * Klinisk Neuropsykologi', value: ' Klinisk Neuropsykologi'},
                    {text: '   * Gerontopsykologi', value: 'Gerontopsykologi'},
                    {text: 'Arbejds- og organisationspsykologi: ', value: 0},
                    {text: '   * Arbejds- og organisationspsykologi', value: 'Arbejds- og organisationspsykologi'},
                ],

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
        }
        ,
        //        when component created get info about user
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
                        // console.log(mainData.special_preparation)

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

                        this.dropzoneOptions = {
                            headers: {'X-CSRF-TOKEN': this.token},
                            maxFiles: 8,
                        }

                        this.dropzoneOptionsVideo = {
                            headers: {'X-CSRF-TOKEN': this.token},
                            maxFiles: 8,
                            dictDefaultMessage: `<b>Maks upload 50MB</b><br>
                    <div><div>Formater der kan uploades:</div>
                            <div>.mp4, .m4v (MPEG-4)</div>
                            <div>.mov (QuickTime)</div>
                            <div>.wmv (Windows Media Video)</div>
                            <div>.avi</div>
                            <div>.mpg</div>
                            <div>.ogv (Ogg)</div>
                    </div>
                            `,
                        };
            },
            today() 
            {
                var today = new Date(),
                    dd = today.getDate() < 10 ? "0" + today.getDate() : today.getDate(),
                    mm = (today.getMonth() + 1) < 10 ? "0" + (today.getMonth() + 1) : (today.getMonth() + 1),
                    yyyy = today.getFullYear();

                return yyyy + '-' + mm + '-' + dd;
            },
            showEditPencils(){
                this.showEditForm = !this.showEditForm;
            },

            getMetaContentByName(name, content)
            {
                var content = (content == null) ? 'content' : content;
                return document.querySelector("meta[name='" + name + "']").getAttribute(content);
            },
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
                    '<button type="button" class="btn btn-default dropdown-toggle btn-block" data-toggle="dropdown"> Til specialistuddannelse <span class="caret"></span></button>' +
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
                        
                        

                        var elm = document.querySelector('#primary_education [value="' +  + '"]');
                        if (elm)
                        {
                            document.querySelector('#primary_education [value="' + mainData.special_preparation + '"]').selected = true;
                        }
                        
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
                                
                                var options = [];
                                $( '.dropdown-menu input:checked' ).each(function(k, v){ options.push($(v).parent().data('value')); });
                                if (document.getElementById('courseNumber').value != ''
                                    && document.getElementById('courseTimer').value != ''
                                ) {
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
            editWebsiteUrl()
            {
                var mainData = this;
                swal({
                    title: 'Skift Hjemmeside',
                    showCancelButton: true,
                    html: '<label class="pull-left" for="Website">Hjemmeside</label><Br>' +
                    '<input id="Website" class="swal2-input" autofocus placeholder="http://www.eksempel.dk" value="' + this.website + '">',
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
            },
            editName(){
                var mainData = this;
                swal({
                    title: 'Skift grundlæggende oplysninger',
                    showCancelButton: true,
                    html: '<label class="pull-left" for="supervisorName">Navn</label><Br>' +
                    '<input id="supervisorName" class="swal2-input" autofocus placeholder="Navn" value="' + this.supervisorName + '">' +
                    '<label class="pull-left" for="supervisorSurname">Efternavn</label><Br>' +
                    '<input id="supervisorSurname" class="swal2-input" placeholder="Efternavn" value="' + this.supervisorSurname + '">' +

                    '<label class="pull-left" for="city">Praksis billigenhed</label><Br><Br>' +
                    '<select class="form-control" id="city">' +
//                    '<option value="none" selected="selected">Hvor søger du supervisor?</option>' +
                    '<option disabled>By:</option>' +
                    '<option value="Århus">* Århus</option>' +
                    '<option value="København">* København</option>' +
                    '<option value="Odense">* Odense</option>' +
                    '<option value="Ålborg">* Ålborg</option>' +
                    '<option disabled>Region:</option>' +
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
                    '<option disabled>Børnepsykologi:</option>' +
                    '<option value="Sundhedspsykologi med børn">* Sundhedspsykologi med børn</option>' +
                    '<option value="Psykoterapi med børn">* Psykoterapi med børn</option>' +
                    '<option value="Klinisk børnepsykologi">* Klinisk børnepsykologi</option>' +
                    '<option value="Klinisk børneneuropsykologi">* Klinisk børneneuropsykologi</option>' +
                    '<option value="Pædagogisk psykologi">* Pædagogisk psykologi</option>' +
                    '<option disabled>Voksenpsykologi:</option>' +
                    '<option value="Sundhedspsykologi med voksne">* Sundhedspsykologi med voksne</option>' +
                    '<option value="Psykoterapi med voksne">* Psykoterapi med voksne</option>' +
                    '<option value="Psykopatologi">* Psykopatologi</option>' +
                    '<option value="Psykotraumatologi">* Psykotraumatologi</option>' +
                    '<option value="Klinisk Neuropsykologi">* Klinisk Neuropsykologi</option>' +
                    '<option value="Gerontopsykolog">* Gerontopsykolog</option>' +
                    '<option disabled>Arbejds- og organisationspsykologi:</option>' +
                    '<option value="Arbejds- og organisationspsykologi">* Arbejds- og organisationspsykologi</option>' +
                    '</select><br>' +
//                    '<label class="pull-left" for="secondary_education">Specialistuddannelse secondary</label><Br><Br>' +
                    '<select class="form-control" id="secondary_education">' +
                    '<option value="none" selected="selected">ingen</option>' +
                    '<option disabled>Børnepsykologi:</option>' +
                    '<option value="Sundhedspsykologi med børn">* Sundhedspsykologi med børn</option>' +
                    '<option value="Psykoterapi med børn">* Psykoterapi med børn</option>' +
                    '<option value="Klinisk børnepsykologi">* Klinisk børnepsykologi</option>' +
                    '<option value="Klinisk børneneuropsykologi">* Klinisk børneneuropsykologi</option>' +
                    '<option value="Pædagogisk psykologi">* Pædagogisk psykologi</option>' +
                    '<option disabled>Voksenpsykologi:</option>' +
                    '<option value="Sundhedspsykologi med voksne">* Sundhedspsykologi med voksne</option>' +
                    '<option value="Psykoterapi med voksne">* Psykoterapi med voksne</option>' +
                    '<option value="Psykopatologi">* Psykopatologi</option>' +
                    '<option value="Psykotraumatologi">* Psykotraumatologi</option>' +
                    '<option value="Klinisk Neuropsykologi">* Klinisk Neuropsykologi</option>' +
                    '<option value="Gerontopsykologi">* Gerontopsykologi</option>' +
                    '<option disabled>Arbejds- og organisationspsykologi:</option>' +
                    '<option value="Arbejds- og organisationspsykologi">* Arbejds- og organisationspsykologi</option>' +
                    '</select><br>' +


//                    '<label class="pull-left" for="third_education">Specialistuddannelse third</label><Br><Br>' +
                    '<select class="form-control" id="third_education">' +
                    '<option value="none" selected="selected">ingen</option>' +
                    '<option disabled>Børnepsykologi:</option>' +
                    '<option value="Sundhedspsykologi med børn">* Sundhedspsykologi med børn</option>' +
                    '<option value="Psykoterapi med børn">* Psykoterapi med børn</option>' +
                    '<option value="Klinisk børnepsykologi">* Klinisk børnepsykologi</option>' +
                    '<option value="Klinisk børneneuropsykologi">* Klinisk børneneuropsykologi</option>' +
                    '<option value="Pædagogisk psykologi">* Pædagogisk psykologi</option>' +
                    '<option disabled>Voksenpsykologi:</option>' +
                    '<option value="Sundhedspsykologi med voksne">* Sundhedspsykologi med voksne</option>' +
                    '<option value="Psykoterapi med voksne">* Psykoterapi med voksne</option>' +
                    '<option value="Psykopatologi">* Psykopatologi</option>' +
                    '<option value="Psykotraumatologi">* Psykotraumatologi</option>' +
                    '<option value="Klinisk Neuropsykologi">* Klinisk Neuropsykologi</option>' +
                    '<option value="Gerontopsykolog">* Gerontopsykolog</option>' +
                    '<option disabled>Arbejds- og organisationspsykologi:</option>' +
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
                        trained_leader: trained_leader,
                        city:city,

                        primary_education:primary_education,
                        secondary_education:secondary_education,
                        third_education:third_education,

                        Eksistentiel_humanistisk:mainData.Eksistentiel_humanistisk ,
                        Kognitiv_adfærdsterapeutisk: mainData.Kognitiv_adfærdsterapeutisk ,
                        Psykodynamisk_psykoanalytisk: mainData.Psykodynamisk_psykoanalytisk ,
                        Systemisk_strukturel:mainData.Systemisk_strukturel,
                    };
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
                                swal('Godt arbejde', 'Data, ændret!', 'success');
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                });
            },
            editAddress(){
                var mainData = this;
                swal({
                    title: 'Kursusadresse',
                    showCancelButton: true,
                    html:
                    '<label class="pull-left" for="supervisorNameAddress">Navn på kursussted </label><Br>' +
                    '<input id="supervisorNameAddress" class="swal2-input"  placeholder="Navn på kursussted " value="' + this.addressName + '"><br>'+
                    '<label class="pull-left" for="supervisorVej">Vej</label><Br>' +
                    '<input id="supervisorVej" class="swal2-input"  placeholder="Vej" value="' + this.roadName + '"><br>'+
                    '<label class="pull-left" for="supervisorPostNumber">Postnummer</label><Br>' +
                    '<input id="supervisorPostNumber" class="swal2-input"  placeholder="Postnummer" value="' + this.postNumber + '"><br>'+
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
            },
            editEmailPhone(){
                var mainData = this;
                swal({
                    title: 'Skift Email',
                    showCancelButton: true,
                    html: '<label class="pull-left" for="supervisorEmail">Email</label><Br>' +
                    '<input id="supervisorEmail" class="swal2-input" autofocus placeholder="Email" value="' + this.email + '">' +
                    '<label class="pull-left" for="supervisorPhone">Phone</label><Br>' +
                    '<input id="supervisorPhone" class="swal2-input" placeholder="Phone" value="' + this.phone + '">',
                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            if (true) {
                                if (document.getElementById('supervisorEmail').value != '' && document.getElementById('supervisorPhone').value != '') {
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
            },
            editTeachers()
            {
                let mainData = this;
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

                    axios.post('/addCourseTeacher', {user_id: mainData.courseOwnerId, teacherName: teacherName})
                        .then(function (response) {
                            
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
            },
            editFormType(){
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
            editSpecialistbevisEvent(){
                this.editSpecialistbevis = !this.editSpecialistbevis;
            },
            changeDropDownSelectSupervisorPreparation()
            {
                this.changeColorSelect($('#special_preparation'), $('#special_preparation').val());
            },
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
            },
            uploadFile(event){
                this.file = event.target.files[0];
            },
            uploadSpecialistbevis(){
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
            deleteSpecialisation(id){
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

        }
        ,
        components: {
            'date-picker': Datepicker,
            Modal,
            Slider,
            SliderItem,
            VueEditor
        }
    }


</script>