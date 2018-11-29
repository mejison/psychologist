<template>
    <article class="content-block-profil">
        <h3>OPDATERING SUPERVISION</h3>
        <hr>
        <form action="" @submit.prevent="updateSupervisionSession" @keydown="deleteErrors($event.target.name)">
            <div class="row custom-input-register-supervisor">
                <div class="col-md-12">
                    <b>{{supervision_name}}</b>
                </div>
                <div class="col-md-6 find-supervisor-container">
                    <div class="row text-center">
                        <div class="update-supervision">
                            <date-picker :date="startTime" :option="option"></date-picker>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 find-supervisor-container ">
                    <div class="row supervisorType ">
                        <select class="application-select" id="supervisionsType" v-model="supervisionsType"
                                @change="changeDropDownSupervisionsType">
                            <option class="default-option" v-for="option in supervisionsTypeOptions"
                                    v-bind:value="option.value">
                                {{ option.text }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <vue-slider ref="slider" v-bind="datepicker.default"
                                v-model="datepicker.default.value"></vue-slider>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 ">
                    <p class="slider-number-left">0</p></div>
                <div class="col-md-4 text-center">
                    <p class="slider-text">Antal Timer</p>
                </div>
                <div class="col-md-4 text-right">
                    <p class="slider-number-right">6</p>
                    <a href="javascript:;" @click="addMoreHours"
                       class="btn btn-primary-outline " id="antalButton">
                        Tilføj flere timer
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="row">
                    <div class="check-box-register-supervisor">
                        <div class="col-md-12 ckeck-block">
                            <div class="row">
                                <div class="checkbox-wrapper"
                                     v-show="supervisionsType!='Personligt udviklingsarbejde/egenterapi'">
                                    <div class="check-box">
                                        <div class="customCheckbox">
                                            <input type="radio" id="checkbox-1-1" value="udredning"
                                                   class="regular-checkbox" name="radio_btn_udredning_intervention"
                                                   @change="udredning_interventionSelected()"
                                                   v-model="udredning_intervention"/>
                                            <label for="checkbox-1-1"></label>
                                        </div>
                                        <span class="check-description">Udredning</span>
                                    </div>
                                    <div class="check-box">
                                        <span class="check-description">Intervention</span>

                                        <div class="customCheckbox">
                                            <input type="radio" id="checkbox-1-4" value="intervention"
                                                   class="regular-checkbox" name="radio_btn_udredning_intervention"
                                                   @change="udredning_interventionSelected('selected')"
                                                   v-model="udredning_intervention"/>
                                            <label for="checkbox-1-4"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 ckeck-block">
                            <div class="row">
                                <div class="checkbox-wrapper"
                                     v-show="supervisionsType!='Personligt udviklingsarbejde/egenterapi'">
                                    <div class="check-box">
                                        <span class="check-description">Ekstern</span>

                                        <div class="customCheckbox">
                                            <input type="radio" id="checkbox-1-2" value="ekstern"
                                                   @change="typeWorkSelected('ekstern')"
                                                   class="regular-checkbox" name="radio_btn_type_work"
                                                   v-model="type_work"/>
                                            <label for="checkbox-1-2"></label>
                                        </div>
                                    </div>

                                    <div class="check-box">
                                        <span class="check-description">Intern</span>

                                        <div class="customCheckbox">
                                            <input type="radio" id="checkbox-1-5" value="intern"
                                                   class="regular-checkbox" name="radio_btn_type_work"
                                                   @change="typeWorkSelected('intern')" v-model="type_work"/>
                                            <label for="checkbox-1-5"></label>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <!--HERE WORK-->
                        <div class="col-md-6 ckeck-block " :class="{ 'pull-right': internSelected}"

                             v-show="(interventionSelected && eksternSelected ) || (interventionSelected && internSelected) ">

                            <p>En del af længerevarende uddannelsesforløb?</p>
                            <div class="row">
                                <div class="checkbox-wrapper">
                                    <div class="check-box">
                                        <span class="check-description">ja</span>

                                        <div class="customCheckbox">
                                            <input type="radio" id="checkbox-20" value="ja"
                                                   class="regular-checkbox" name="radio_btn_uddannelsesfor"
                                                   v-model="uddannelsesfor"/>
                                            <label for="checkbox-20"></label>
                                        </div>
                                    </div>

                                    <div class="check-box">
                                        <span class="check-description">nej</span>

                                        <div class="customCheckbox">
                                            <input type="radio" id="checkbox-21" value="nej"
                                                   class="regular-checkbox" name="radio_btn_uddannelsesfor"
                                                   v-model="uddannelsesfor"/>
                                            <label for="checkbox-21"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 ckeck-block">
                            <div class="row">
                                <div class="checkbox-wrapper">
                                    <div class="check-box">
                                        <span class="check-description">Individuel</span>

                                        <div class="customCheckbox">
                                            <input type="radio" id="checkbox-1-3" @change="hideDropDown"
                                                   value="individuel"
                                                   class="regular-checkbox" name="radio_btn_type_class"
                                                   v-model="type_class"/>
                                            <label for="checkbox-1-3"></label>
                                        </div>
                                    </div>
                                    <div class="check-box">
                                        <span class="check-description">Gruppe</span>

                                        <div class="customCheckbox">
                                            <input type="radio" id="checkbox-1-6" value="gruppe"
                                                   class="regular-checkbox"
                                                   @change="hideDropDown('show')" name="radio_btn_type_class"
                                                   v-model="type_class"/>
                                            <label for="checkbox-1-6"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row hide-select-register-supervisor" v-show="hideSelectGroupComposition">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <div class="row supervisorType">
                                    <div v-if="supervisionsType!='Personligt udviklingsarbejde/egenterapi'">
                                        <select class="application-select" id="groupComposition"
                                                v-model="groupComposition"
                                                @change="changeDropDownGroupComposition">
                                            <option class="default-option" v-for="option in groupCompositionOptions"
                                                    v-bind:value="option.value">
                                                {{ option.text }}
                                            </option>
                                        </select>
                                    </div>
                                    <div v-else>
                                        <select class="application-select" id="groupComposition"
                                                v-model="groupComposition"
                                                @change="changeDropDownGroupComposition">
                                            <option
                                                    class="default-option" v-for="option in groupPersonligtOptions"
                                                    v-bind:value="option.value">
                                                {{ option.text }}
                                            </option>
                                            <!--</select>-->
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<div class="col-md-6 ckeck-block" v-show="hideSelectGroupComposition">-->
                        <!--</div>-->
                        <div class="col-md-6 ckeck-block pull-right" v-show="hideSelectGroupComposition">
                            <div v-if="supervisionsType!='Personligt udviklingsarbejde/egenterapi'">
                                <p>Var mere end 25 % af deltagerne af anden faggruppe (dvs. ikkepsykologer)?</p>
                                <div class="row">
                                    <div class="checkbox-wrapper">
                                        <div class="check-box">
                                            <span class="check-description">ja</span>

                                            <div class="customCheckbox">
                                                <input type="radio" id="checkbox-22" value="ja"
                                                       class="regular-checkbox" name="radio_btn_PercentPsychology"
                                                       v-model="percentPsychology"/>
                                                <label for="checkbox-22"></label>
                                            </div>
                                        </div>

                                        <div class="check-box">
                                            <span class="check-description">nej</span>

                                            <div class="customCheckbox">
                                                <input type="radio" id="checkbox-23" value="nej"
                                                       class="regular-checkbox" name="radio_btn_PercentPsychology"
                                                       v-model="percentPsychology"/>
                                                <label for="checkbox-23"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row register-supervisor-textarea">
            <textarea v-model="comment" name="SkrivKommentar" id="" cols="30" rows="1" placeholder="Skriv kommentar.../
            Beskriv kort overfor hvilke arbejdsopgaver supervisionen blev givet:"></textarea>
            </div>
            <div class="row">
                <button type="submit" class="button light-green profil-button ">Opdatering</button>
            </div>
        </form>


        <div class="row register-supervisor-bilag">
            <h5>Bilag</h5>

            <div class="bilag-container" v-for="file in bilag_files">
                <span class="container-img">
                <img src="/image/book.png" alt="book"
                     v-show="file.file_extension=='pdf'||file.file_extension=='doc'||file.file_extension=='docx'">
                    </span>
                <span>{{file.file_name}}</span>

                <div class="actions">
                    <a v-bind:href="file.file_path" download><img class="download" src="/image/arrow-download.png"
                                                                  alt="download"></a>
                    <a href="javascript:;" @click="deleteFile(file.file_id)"><img class="trash"
                                                                                  src="/image/vector-smart-trash.png"
                                                                                  alt="delete"></a>
                </div>
            </div>
            <div class="row upload-bilag">
                <form action="" @submit.prevent="uploadBilag">
                    <input type="file" @change="uploadBilagFile" id="uploadBilag">
                    <button type="submit" class="btn btn-primary-outline">
                        <img class="download" src="/image/vector-smart-arrow-up.png" alt="download">Upload bilag
                    </button>
                </form>
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
                addMoreHoursProp: false,

                interventionSelected: false,
                eksternSelected: false,
                internSelected: false,

                bilag_files: [],
//slider section
                datepicker: {
                    default: {
                        width: 'auto',
                        height: 6,
                        value: 0,
                        direction: 'horizontal',
                        dotSize: 16,
                        eventType: 'auto',
                        min: 0,
                        max: 6,
                        interval: 0.5,
                        disabled: false,
                        show: true,
                        tooltip: 'always',
                        clickable: true,
                        tooltipDir: 'top',
                        piecewise: true,
                        lazy: false,
                        reverse: false,
                        speed: 1,
                        formatter: "{value}",
                        bgStyle: {
                            "backgroundImage": "url('../image/slider.png') left top no-repeat;"
                        },
                        sliderStyle: null,
                        tooltipStyle: {
                            "backgroundColor": "#666",
                            "borderColor": "#666",
                        },
                        processStyle: null,
                        piecewiseStyle: null
                    },
                },
//end slider section

//timer
                startTime: {
                    time: ''
                },
                endtime: {
                    time: ''
                },
                option: {
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
                        'margin': '10px',
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
                    overlayOpacity: 0.5, // 0.5 as default
                    dismissible: true // as true as default
                },
//timer section end
                supervision_name: '',
                comment: '',
                id_session_supervison: '',
                udredning_intervention: '',
                uddannelsesfor: '',
                percentPsychology: '',
                type_work: '',
                type_class: '',
                findSupervisorInput: '',
                hideSelectGroupComposition: false,
                hideSelectLongComposition: false,
                selectSupervisor: 'default',
                selectSupervisorOptions: [
                    {text: 'vælg supervisor', value: 'default'},
                ],
                selectDate: 'default',
                selectDateOptions: [
                    {text: 'Dato', value: 'default'},
                    {text: 'Some Dato', value: 'Some Dato'},
                ],
                supervisionsType: 'default',
                supervisionsTypeOptions: [
                    {text: 'Supervisionstype', value: 'default'},
                    {text: 'Ansigt-til-ansigt', value: 'Ansigt-til-ansigt'},
                    {text: 'Live Video/Audio', value: 'Live Video/Audio'},
                    {text: 'Personligt udviklingsarbejde/egenterapi', value: 'Personligt udviklingsarbejde/egenterapi'},

                ],
                groupComposition: 'default',
                groupCompositionOptions: [
                    {text: 'Gruppesammensætning', value: 'default'},
                    {text: 'Op til 8 personer', value: '0-8'},
                    {text: '9 - 12', value: '9-12'},
                    {text: 'Over 12', value: 'Over12'},
                ],
                groupPersonligtOptions: [
                    {text: 'Gruppesammensætning', value: 'default'},
                    {text: '2-12 personer', value: '2-12'},
                    {text: '13 eller flere personer', value: 'Over13'},
                ],
                errors: [],
                sessionId: ''
            }
        }
        ,
        //        when component created get info about user
        created: function () {
            let registerSupervisionsId = (this.$route.params.idSupervision);
            let registerSupervisionsRole = (this.$route.params.role);
            this.sessionId = registerSupervisionsId;
            let data = {
                registerSupervisionsId: registerSupervisionsId,
                registerSupervisionsRole: registerSupervisionsRole
            };
            console.log("ID   " + registerSupervisionsId);
            //Reference to global data
            let mainData = this;
            axios.post('/getInfoSupervision', data)
                    .then(function (response) {
                        mainData.comment = response.data.comment;
                        mainData.startTime.time = response.data.registration_date;
                        mainData.supervisionsType = response.data.supervision_type;
                        mainData.datepicker.default.value = response.data.number_of_hours;
                        mainData.type_class = response.data.type_classes;
                        mainData.udredning_intervention = response.data.udredning_intervention;
                        mainData.type_work = response.data.type_work;
                        mainData.id_session_supervison = response.data.id;

                        if (response.data.supervision != null) {
                            mainData.supervision_name = response.data.supervision.name + ' ' + response.data.supervision.surname;
                        } else {
                            mainData.supervision_name = response.data.user.name + ' ' + response.data.user.surname;
                        }
                        if (response.data.type_classes == 'gruppe') {
                            mainData.hideSelectGroupComposition = true;
                            mainData.groupComposition = response.data.group_composition;
                            mainData.percentPsychology = response.data.percentPsychology;
                        }
                        if (response.data.long_course != null) {
                            mainData.interventionSelected = true;
                            if (response.data.type_work == 'intern') {
                                mainData.internSelected = true;
                            } else {
                                mainData.eksternSelected = true;
                            }
//                            mainData.hideSelectLongComposition = true;
                            mainData.uddannelsesfor = response.data.long_course;
                        }
                    });
            axios.post('/getAllSupervisionBilags', data)
                    .then(function (response) {
//                        console.log(response.data);
                        if (response.data.length > 0) {
                            let bilag_files = response.data;
                            bilag_files.forEach(function (item) {
                                mainData.bilag_files.push({
                                    file_id: item.id,
                                    file_name: item.file_name,
                                    file_path: item.file_path,
                                    file_extension: item.file_type,
                                });
                            });
                        }
                    })


        }
        ,
        methods: {
            addMoreHours()
            {
                if (this.addMoreHoursProp != true) {
                    this.datepicker.default.max = 40;
                    this.datepicker.default.interval = 0.5;
                    document.querySelector('.slider-number-right').innerHTML = 40;
                    document.getElementById("antalButton").innerHTML = "Færre timer";
                    this.addMoreHoursProp = !this.addMoreHoursProp;
                }
                else {
                    this.datepicker.default.max = 6;
                    this.datepicker.default.interval = 0.5;
                    document.querySelector('.slider-number-right').innerHTML = 6;
                    document.getElementById("antalButton").innerHTML = "Tilføj flere timer";
                    this.addMoreHoursProp = !this.addMoreHoursProp;
                }
            }
            ,
            deleteFile(file_id)
            {
                console.log(file_id);
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
                    let data = {file_id: file_id};
                    axios.post('/deleteBilagFile', data)
                            .then(function (response) {
                                $.each(mainData.bilag_files, function (i) {
                                    if (mainData.bilag_files[i].file_id === file_id) {
                                        mainData.bilag_files.splice(i, 1);
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
            uploadBilagFile(event)
            {
                var mainData = this;
                var fileData = new FormData()
                fileData.append('file', event.target.files[0]);
                fileData.append('sessionId', mainData.sessionId);
                axios.post('/uploadBilagFile', fileData)
                        .then(function (response) {
                            console.log(response.data)
                            mainData.bilag_files.push({
                                file_id: response.data.file_id,
                                file_name: response.data.file_name,
                                file_path: response.data.file_path,
                                file_extension: response.data.file_extension,
                            });
                            swal('Godt arbejde!', 'Din fil er blevet downloadet!', 'success');
                        })
                        .catch(function (error) {
                            swal('Godt arbejde!', 'Filen skal være unikt!', 'error')
                        });
            }
            ,
            uploadBilag()
            {
                $('#uploadBilag').click();
            }
            ,
            updateSupervisionSession()
            {
                let mainData = this;
                let supervisionSessionId = this.id_session_supervison;
                let supervisorType = this.supervisionsType;
                let type_work = this.type_work;
                let udredning_intervention = this.udredning_intervention;
                let type_classes = this.type_class;
                let antalTimer = this.datepicker.default.value;
                let dateTimer = this.startTime.time;
                let groupCount = null;
                let percentPsychology = null;
                if (type_classes == 'gruppe') {
                    groupCount = this.groupComposition;
                    percentPsychology = this.percentPsychology;
                }
                let comment = this.comment;
                let longCourse = this.uddannelsesfor;
                let data = {
                    'supervisionSessionId': supervisionSessionId,
                    'registration_date': dateTimer,
                    'supervision_type': supervisorType,
                    'number_of_hours': antalTimer,
                    'type_work': type_work,
                    'udredning_intervention': udredning_intervention,
                    'type_classes': type_classes,
                    'group_composition': groupCount,
                    'comment': comment,
                    'long_course': longCourse,
                    'percentPsychology': percentPsychology,
                };
                axios.post('/updateSupervisionStatus', data)
                        .then(function (response) {
                            swal('Godt arbejde!', 'Data opdateret!', 'success')
                                    .then(function () {
                                        mainData.$router.push('/oversigtSupervision');
                                    });
                        })
                        .catch(function (error) {
                            swal('Godt arbejde!', 'Dataene er ikke opdateret!', 'error');
                        });
            }
            ,
            udredning_interventionSelected(obj){
                this.uddannelsesfor = '';
                if (typeof (obj) == 'string') {
                    this.interventionSelected = true;
                } else {
                    this.interventionSelected = false;
                }
            },
            typeWorkSelected(type){
                if (type == 'intern') {
                    this.internSelected = true;
                    this.eksternSelected = false;
                } else { //type == ekstern
                    this.internSelected = false;
                    this.eksternSelected = true;
                }
            },
            hideDropDown(obj)
            {
                if (typeof (obj) == 'string') {
                    this.hideSelectGroupComposition = true;
                } else {
                    this.hideSelectGroupComposition = false;
                }
            }
            ,
            hideDropDownLong(obj)
            {
                if (typeof (obj) == 'string') {
                    this.hideSelectLongComposition = true;
                } else {
                    this.hideSelectLongComposition = false;
                    this.uddannelsesfor = '';
                }
            }
            ,

//              check user error
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
            changeDropDownSupervisionsType()
            {
                this.changeColorSelect($('#supervisionsType'), $('#supervisionsType').val());
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
        ,
        components: {
            'date-picker': myDatepicker,
            vueSlider
        }
    }

</script>
