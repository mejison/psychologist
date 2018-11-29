<template>
    <div>
    <article class="content-block-profil form-group">
        <h3>REGISTRER SUPERVISION</h3>
        <hr>
        <!--START SECTON POP UP-->
        <div class="row popUp-Opret">
            <div class="popUpContainer">
                <div class="row">
                    <div class="col-md-6 col-md-offset-6">
                        <!--<a href="javascript:;" id="popUpOpretNySupervisor" @click="showPopUp"-->
                        <!--class="btn btn-primary-outline ">-->
                        <!--Opret ny supervisor-->
                        <!--</a>-->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <span>Kviksøg supervisor i vores database</span>
                        <input type="text" name="name" class="application-input" id="findSupervisorInRegister"
                               list="supervisor_list" v-model="findSupervisorInput" placeholder="Navn"
                               @keyup="findSupervisor">

                        <datalist id="supervisor_list">
                            <option></option>
                        </datalist>
                        <div class="voresDatabase">
                            <span>Kan du ikke finde supervisorprofil i vores database?</span>
                            <a href="javascript:;" id="openCreateSupervisor" @click="showSupervisorCreate"
                               class="btn btn-primary-outline ">
                                Opret manuelt
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <button @click="attachSupervisor" class="button light-green profil-button">godkend</button>
                    </div>
                </div>
            </div>
            <div class="wrapper-section-popUp">
                <form action="" @submit.prevent="addNewSupervisor" @keydown="deleteErrors($event.target.name)">
                    <div class="addNewSupervison-container">
                        <div class="col-md-6 addNewSection">
                            <div class="custom-block">
                                <input type="text" class="addresse-input" v-model="address" placeholder="Adresse">
                                <input type="text" class="postnr-input" v-model="postIndex" placeholder="Postnr.">
                                <input type="text" class="by-input" v-model="city" placeholder="By">
                                <input type="text" class="application-input" v-model="phone" placeholder="Tlf.nr.">
                            </div>
                        </div>
                        <div class="col-md-6 addNewSection">
                            <div class="custom-block right-side">
                                <input type="text" class="addresse-input" v-model="name_reg" placeholder="Fornavn">
                                <input type="text" class="postnr-input efternav" v-model="surname_reg"
                                       placeholder="Efternavn">
                                <input type="text" class="application-input" v-model="email" placeholder="E-mail">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 pop-Up-draft">
                        <hr>
                    </div>
                    <div class="col-md-6 pop-Up-draft">
                        <div class="left-dropdown-inPopUp">
                            <select class="application-select" v-model="special_preparation"
                                    @change="changeDropDownSelectSupervisorPreparation" id="special_preparation">
                                <option class="default-option" v-for="option in options" v-bind:value="option.value" :class="{'bold' : option.value==0 || option.value=='default'}"
                                        :disabled="option.value==0">
                                    {{ option.text }}
                                </option>
                            </select>
                        </div>
                        <div class="button-section">
                            <button type="submit" id="closePopUpRegister" class="button light-green profil-button ">
                                Opret
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6 right-input-block pop-Up-draft">
                        <input type="text" name="name" class="application-input" v-model="special_evidence"
                               placeholder="journalnummer på specialistbevis...">

                        <div class="check-box">
                    <span class="check-description">
                        Supervisoruddannet
                    </span>

                            <div class="customCheckbox">
                                <input type="checkbox" id="checkbox-1-10" class="regular-checkbox"
                                       v-model="special_trained"/>
                                <label for="checkbox-1-10"></label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--END SECTON POP UP-->
        <form action="" @submit.prevent="registerSupervision" @keydown="deleteErrors($event.target.name)">

            <div class="row custom-input-register-supervisor">
                <div class="col-md-6 find-supervisor-container">
                    <div class="row text-center">
                        <div>  
                        <select style="margin: 10px;" class="application-select" id="selectSupervisor" v-model="selectSupervisor"
                                @change="changeDropDownSelectSupervisor">
                            <option class="default-option" v-for="option in selectSupervisorOptions"
                                    v-bind:value="option.value + option.role">
                                {{ option.text }}
                            </option>
                        </select>
                        </div>
                    </div>
                    <div class="row text-center">
                        <date-picker :date="startTime" :option="option"></date-picker>
                    </div>
                </div>
                <div class="col-md-6 find-supervisor-container">
                    <div class="row btn-popup">
                        <a style="margin-left: 3.5%;" href="javascript:;" @click="showPopUp"
                           class="btn btn-primary-outline ">
                            Opret ny supervisor
                        </a>
                    </div>
                    <div class="row supervisorType">
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
                    <!--<vue-slider v-model="value" ></vue-slider>-->
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
                                               class="regular-checkbox" name="radio_btn_type_work" v-model="type_work"/>
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
                                        <input type="radio" id="checkbox-1-3" @change="hideDropDown" value="individuel"
                                               class="regular-checkbox" name="radio_btn_type_class"
                                               v-model="type_class"/>
                                        <label for="checkbox-1-3"></label>
                                    </div>
                                </div>
                                <div class="check-box">
                                    <span class="check-description">Gruppe</span>

                                    <div class="customCheckbox">
                                        <input type="radio" id="checkbox-1-6" value="gruppe" class="regular-checkbox"
                                               @change="hideDropDown('show')" name="radio_btn_type_class"
                                               v-model="type_class"/>
                                        <label for="checkbox-1-6"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row hide-select-register-supervisor" v-show="hideSelectGroupComposition">
                        <div class="col-md-offset-6 col-md-6">
                            <div class="row supervisorType">
                                <!--<select class="application-select" id="groupComposition" v-model="groupComposition"-->
                                <!--@change="changeDropDownGroupComposition">-->
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


            <div class="row register-supervisor-textarea">
            <textarea v-model="comment" name="SkrivKommentar" id="" cols="30" rows="1" placeholder="Skriv kommentar.../
            Beskriv kort overfor hvilke arbejdsopgaver supervisionen blev givet:"></textarea>
            </div>
            <div class="row">
                <button type="submit" class="button light-green profil-button ">Gem</button>
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
    <br />
    <br />
    <br />
    </div>
</template>

<script>
    import myDatepicker from 'vue-datepicker';
    import vueSlider from 'vue-slider-component';
    import {SortingData} from "../../helpers/SortingData";

    export default {
//        Collect information to vue.data
        data()
        {
            return {
                SortingData: {},
                bilag_files: [],
//                supervision registration section
                name_reg: '',
                surname_reg: '',
                email: '',
                password: '',
                address: '',
                postIndex: '',
                city: '',
                phone: '',
                special_evidence: '',
                special_trained: false,
                interventionSelected: false,
                eksternSelected: false,
                internSelected: false,

                special_preparation: 'default',
                options: [
                    {text: 'Hvilken specialistuddannelse ønsker du?', value: 0},
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
                    {text: '   * Psykoterapi med voksne', value: 'default'},
                    {text: '   * Psykopatologi', value: 'Psykopatologi'},
                    {text: '   * Klinisk Neuropsykologi', value: ' Klinisk Neuropsykologi'},
                    {text: '   * Gerontopsykolog', value: 'Gerontopsykolog'},
                    {text: '', value: 0},
                    {text: 'Arbejds- og organisationspsykologi: ', value: 0},
                    {text: '   * Arbejds- og organisationspsykologi', value: 'Arbejds- og organisationspsykologi'},
                ],
//              END  supervision registration section

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
                addMoreHoursProp: false,
                comment: '',
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
                    {text: 'Har du allerede oprettet supervisor?', value: 'default', role: ''},
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
                //id registered session
                sessionId: ''
            }
        }
        ,
        //        when component created get info about user
        created: function () {
            this.SortingData = new SortingData();
            //Reference to global data
            let mainData = this;
            axios.get('/getAllSupervisors')
                    .then(function (response) {
                        if (response.data.supervisors.length > 0) {
                            let supervisors = response.data.supervisors;
                            supervisors = mainData.SortingData.sortMineSupervisionData(supervisors, 'created_at');
                            supervisors.forEach(function (item) {
                                let fullName = item.name + ' ' + item.surname;
                                console.log(fullName)
//                                if user don't have id, this mean this user not created by psychology this is user with role supervisor
                                if (item.id == null) {
                                    item.id = item.user_id;
                                    mainData.selectSupervisorOptions.push({
                                        text: fullName,
                                        value: item.id,
                                        role: 'supervisor'
                                    });
                                } else {
                                    mainData.selectSupervisorOptions.push({
                                        text: fullName,
                                        value: item.id,
                                        role: 'selfCreated'
                                    });
                                }
                            });
//                        mainData.selectSupervisorOptions =  mainData.SortingData.sortMineSupervisionData(response.data, 'created_at');
//                            if (response.data.bilag_files.length > 0) {
//                                let bilag_files = response.data.bilag_files;
//                                bilag_files.forEach(function (item) {
//                                    mainData.bilag_files.push({
//                                        file_id: item.id,
//                                        file_name: item.file_name,
//                                        file_path: item.file_path,
//                                        file_extension: item.file_type,
//                                    });
//                                });
//                            }
                        }
                    })

                    .catch(function (error) {
                        console.log(error);
                    });
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
                            swal('Fejl!', 'Filen skal være unikt!', 'error')
                        });
            }
            ,
            uploadBilag()
            {
                if (this.sessionId != '') {
                    $('#uploadBilag').click();
                } else {
                    swal('Fejl!', 'Opret først lektion!', 'error')
                }
            }
            ,
            registerSupervision()
            {
                let mainData = this;
                let supervisorType = this.supervisionsType;
                let udredning_intervention = this.udredning_intervention;
                let type_work = this.type_work;
                let type_class = this.type_class;
                let antalTimer = this.datepicker.default.value;
                let dateTimer = this.startTime.time;
                let long_course = this.uddannelsesfor;
                let percentPsychology = this.percentPsychology;
                let groupCount = null;
                if (type_class == 'gruppe') {
                    groupCount = this.groupComposition;
                }
                let comment = this.comment;
                let data = {
                    'registration_date': dateTimer,
                    'supervision_type': supervisorType,
                    'number_of_hours': antalTimer,
                    'type_classes': type_class,
                    'udredning_intervention': udredning_intervention,
                    'type_work': type_work,
                    'group_composition': groupCount,
                    'comment': comment,
                    'long_course': long_course,
                    'percentPsychology': percentPsychology,
                };
                let supervisorId = this.selectSupervisor
                let supervisorIdWithoutRole;
                //            if supervision has role selfCreated...
                if (supervisorId.search("selfCreated") != -1) {
                    supervisorIdWithoutRole = (supervisorId.slice(0, supervisorId.search("selfCreated")))
                    data.supervision_id = supervisorIdWithoutRole;
                    data.role = 'selfCreated';
                }
                else {
                    supervisorIdWithoutRole = (supervisorId.slice(0, supervisorId.search("supervisor")));
                    data.supervision_id = supervisorIdWithoutRole;
                    data.role = 'supervisor';

                }
                axios.post('/registerSupervision', data)
                        .then(function (response) {
                            mainData.sessionId = response.data;
                            swal("", 'Godt arbejde, registrering godkendt!', 'success')
                                    .then(function () {
                                        mainData.$router.push('/oversigtSupervision');
                                    });

                        })
                        .catch(function (error) {
                            let listErrors = error.response.data;
                            mainData.showListError(listErrors);
                        });


            }
            ,
            attachSupervisor()
            {
                let mainData = this;
                let data = {'supervisorName': this.findSupervisorInput};
                axios.post('/attachSupervisor', data)
                        .then(function (response) {
                            console.log(response.data);
                            let supervisorName = response.data.name + " " + response.data.surname;
                            let supervisorToAdd = {text: supervisorName, value: response.data.id, role: 'selfCreated'};
                            mainData.selectSupervisorOptions.push(supervisorToAdd);
                            mainData.selectSupervisor = supervisorToAdd.value + supervisorToAdd.role;
                            mainData.findSupervisorInput = '';
                            swal('Godt arbejde!', 'Supervisor valgt!', 'success').then(() => {
                                window.location.reload();
                            })
                        })
                        .catch(function (error) {
                            swal('Godt arbejde!', 'Fejl, når du vælger vejleder!', 'error');
                        });
            }
            ,
            createDataList(supervisors)
            {
                $('#supervisor_list').empty();
                supervisors.forEach(function (item) {
                    $('#supervisor_list').append('<option>' + item + '</option>');
//                    console.log(item);
                });
            }
            ,
            findSupervisor()
            {
                var mainData = this;
                let querySearch = this.findSupervisorInput;
                let data = {'find': querySearch};
                axios.post('/findSupervisor', data)
                        .then(function (response) {
                            let supervisors = response.data;
                            var list = [];
                            supervisors.forEach(function (item, i) {
                                list[i] = item.name + ' ' + item.surname;
                            });
                            mainData.createDataList(list)
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
            }
            ,
            addNewSupervisor()
            {
                let mainData = this;
                let data = {
                    name: this.name_reg,
                    surname: this.surname_reg,
                    email: this.email,
                    address: this.address,
                    post: this.postIndex,
                    city: this.city,
                    phone: this.phone,
                    special_evidence: this.special_evidence,
                    special_trained: this.special_trained,
                    special_preparation: this.special_preparation,

                };
                axios.post('/psychologistRegSupervision', data)
                        .then(function (response) {
                            console.log(response.data);
                            let supervisorName = response.data.name + " " + response.data.surname;
                            let supervisorToAdd = {text: supervisorName, value: response.data.id, role: 'selfCreated'};
                            mainData.selectSupervisorOptions.push(supervisorToAdd);
                            mainData.selectSupervisor = supervisorToAdd.value + supervisorToAdd.role;
                            mainData.closePopUp();
                            swal({
                                title: 'Godt arbejde!',
                                text: 'Din profil opdateret!',
                                timer: 1500,
                                type: 'success'
                            });
                        })
                        .catch(function (error) {
                            let listErrors = error.response.data;
                            mainData.showListError(listErrors);
                        });
            }
            ,
            showListError(listErrors)
            {
                var array = $.map(listErrors, function (value, index) {
                    return [value];
                });
                var responce_errors = "<ul class='text-left'>";
                array.forEach(function (item, i, arr) {
                    responce_errors += "<li>" + item + "</li>";
                });
                responce_errors += "</ul>";
                swal({
                    title: 'Fejl List',
                    type: 'error',
                    html: responce_errors,
                });
            }
            ,
            showSupervisorCreate()
            {
                $('.popUpContainer').css('display', 'none');
                $('.wrapper-section-popUp').css('display', 'block');
            }
            ,
            closePopUp()
            {
                $('.popUp-Opret').css('display', 'none');
                $('.overlayMenu').fadeOut(200);
                $('.overlayMenu').css("backgroundColor", '');
                $('.popUpContainer').css('display', 'block');
                $('.wrapper-section-popUp').css('display', 'none');
            }
            ,
            showPopUp()
            {
                $('.popUp-Opret').css('display', 'block');
                $('.overlayMenu').fadeIn(200);
                $('.overlayMenu').css("display", "block");
                $('.overlayMenu').css("backgroundColor", 'rgba(0, 0, 0, 0.35)');
            }
            ,
            hideDropDown(obj)
            {
                if (typeof (obj) == 'string') {
                    this.hideSelectGroupComposition = true;
                } else {
                    this.hideSelectGroupComposition = false;
                }
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


            hideDropDownLong(obj)
            {
                if (typeof (obj) == 'string') {
                    this.hideSelectLongComposition = true;
                } else {
                    this.hideSelectLongComposition = false;
                    this.uddannelsesfor = '';
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
            }
            ,

//            delete field error
            deleteErrors(field)
            {
                if (this.errors[field]) {
                    delete this.errors[field];
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
            changeDropDownSelectSupervisor()
            {
                console.log(this.selectSupervisor);
                this.changeColorSelect($('#selectSupervisor'), $('#selectSupervisor').val());
            }
            ,
            changeDropDownSelectDate()
            {
                this.changeColorSelect($('#selectDate'), $('#selectDate').val());
            }
            ,
            changeDropDownSupervisionsType()
            {
                this.changeColorSelect($('#supervisionsType'), $('#supervisionsType').val());
            }
            ,
            changeDropDownGroupComposition()
            {
                this.changeColorSelect($('#groupComposition'), $('#groupComposition').val());
            }
            ,
            changeDropDownSelectSupervisorPreparation()
            {
                this.changeColorSelect($('#special_preparation'), $('#special_preparation').val());
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
