<template>
    <div>
    <article class="content-block-profil wrapper-find-course">
        <h3>FIND TEORIKURSUS</h3>
        <hr>
        <div class="col-md-6">
            <form action="" @submit.prevent="findKursus" @keydown="deleteErrors($event.target.name)">

                <div class="row text-center">
                    <div class="col-md-12">
                        <select class="application-select" id="lookingKursus" v-model="lookingKursus"
                                @change="changeDropDownLookingKursus">
                            <option class="default-option" v-for="option in lookingKursusOptions"
                                    v-bind:value="option.value" :disabled="option.value==0">
                                {{ option.text }}
                            </option>
                        </select>
                    </div>
                </div>
 
                <div class="row text-center">
                    <div class="col-md-12 search-wrapper">
                        <select class="application-select" v-model="modules.modul" @change="selectModule()">
                            <option value="0" class="bold" selected>Til hvilket modul søger du kursus?</option>
                            <option :value="m.id" v-for="m in modules.list">{{ m.name }}</option>
                        </select>
                    </div>
                </div>

                
                <div class="row text-center">
                    <div class="col-md-6">
                        <date-picker @change="setFromDate()" :limit="limit.from" :date="date.from" :option="optionDatepickerFrom"></date-picker>
                    </div>
                    <div class="col-md-6">
                        <date-picker :limit="limit.to"  :date="date.to" :option="optionDatepickerTo"></date-picker>
                    </div>
                </div>
            </form>
        </div>
         <form action="" @submit.prevent="findKursus">
        <div class="col-md-6">
                
                <div class="row text-center">
                    <div class="col-md-12">
                        <input type="text" name="name" class="application-input" id="findTeorikursus"
                            list="teorikursus_list"  v-model="findTeorikursusInput"  @keyup="findTeorikursusByName" placeholder="Hvad er navnet på kurset du søger?">
                        <datalist id="teorikursus_list">
                            <option></option>
                        </datalist>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-md-12">
                        <select class="application-select" id="specialistDegree" v-model="specialistDegree"
                            @change="changeDropDownSpecialistDegree">
                            <option class="default-option" v-for="option in specialistDegreeOptions"
                                    v-bind:value="option.value"  :class="{bold : option.value == 0 }" :disabled="option.value==0">
                                {{ option.text }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="row text-center">
                    <div class="col-md-12">
                        <div class="check-box">
                            <span class="check-description">
                                Forhåndsgodkendt af Dansk Psykologforening
                            </span>
                            <div class="customCheckbox">
                                <input type="checkbox" id="checkbox-1-1" class="regular-checkbox" v-model="kursusUddannet"/>
                                <label for="checkbox-1-1"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-md-12">
                        <input type="text" name="name" class="application-input" id="findTeachers"
                            list="teachers_list"  v-model="findTeachersInput"  @keyup="findTeachersByName" placeholder="Søger du en bestemt underviser?" @change="select();">
                    </div>
                </div>
            
        </div>
        
        <div class="col-md-12">
            <button type="submit" class="button light-green">Søg</button>
        </div>
        </form>

        <div class="row col-md-12">
            <article class="content-block-result">
                <div class="scroll-box">

                    <div class="item-box" v-for="(c, i) in courses">
                        <div class="avatar-section">
                            <div v-if="c.info.avatar_path != null">
                                <img  :src="c.info.avatar_path"
                                      alt="avatar" />
                            </div>
                            <div v-else>
                                <img src="/image/avatar-placeholder.png"
                                     alt="avatar" />
                            </div>
                        </div>
                        <div class="text-section">
                            <ul>
                                <li class="bold"> {{ c.course.course_name }}</li>
                                <li>Teorikursus</li>
                                <li>
                                    <b>Kursusdato</b>
                                    
                                    <p v-if=" ! c.course.course_date.length">
                                        --
                                    </p>
                                    
                                    <p v-if="c.course.course_date.length > 0 && c.course.course_date.length <= 2">
                                        {{ c.course.course_date.join(' - ') }}
                                    </p>

                                    <p v-if="c.course.course_date.length >= 3">
                                        <span v-show=" ! c.toggle_date"> {{ c.course.course_date ? sort(c.course.course_date, "range").join(" - ") : "" }}</span>
                                        <span v-show="c.toggle_date">{{ c.course.course_date ? sort(c.course.course_date, "min").join(", ") : "" }}</span>
                                        <span v-show=" ! c.toggle_date"> 
                                            <a href="javascript:;" @click="c.toggle_date ^= 1">
                                                Vis alle datoer
                                            </a>
                                        </span>
                                        <span v-show="c.toggle_date">
                                            <a href="javascript:;" @click="c.toggle_date ^= 1">
                                                Vis kun start- og slutdato
                                            </a>
                                        </span>
                                    </p>
                                    
                                </li>
                                <li><b>Kursusnummer</b> {{ c.course.course_number }}</li>
                                <li><b>Timer</b> {{ c.course.course_hours }}</li>
                                <li><b>Modul</b> {{ c.course.groups && c.course.groups.groups && c.course.groups.groups.groups ? c.course.groups.groups.groups.name : "" }}</li>
                                <li><b>Uddannelse</b> <span v-if="c.info.educations" v-for="sp in c.info.educations">{{ sp }}, </span></li>
                                <li><b>Undervisere</b> <span v-if="c.teachers.length" v-for="t in c.teachers">{{ t.teacher_name }}, </span><span v-if=" ! c.teachers.length">--</span></li>
                            </ul> 
                            <div class="button-section">
                                <router-link :to="{ name: 'course.profile', params: { idCourse: c.user.id }}" class="btn btn-primary-outline btn-right"> 
                                    profil
                                </router-link>
                                <router-link :to="{ name: 'register.course', params: { idCourse: c.user.id }}" class="btn btn-primary-outline "> 
                                    register kursus
                                </router-link> 
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </article>
        <br />
        <br />
        <br />
    </div>
</template>

<script>
    import Datepicker from 'vue-datepicker';
    
    export default {
        data()
        {
            return {
                findTeachersInput: "",
                TeachersResultList: [],
                findTeorikursusInput:"",
                kursus:[],
                courses:[],
                lookingKursus: 'default',
                kursusUddannet: false,
                lookingKursusOptions: [
                    {text: 'Hvor søger du kursus?', value: 'default'},
                    {text: '', value: 0},
                    {text: 'By: ', value: 0},
                    {text: '   * Århus', value: 'Århus'},
                    {text: '   * København', value: 'København'},
                    {text: '   * Odense', value: 'Odense'},
                    {text: '   * Ålborg', value: 'Ålborg'},
                    {text: '', value: 0},
                    {text: 'Region: ', value: 0},
                    {text: '   * Nordjylland', value: 'Nordjylland'},
                    {text: '   * Midtjylland', value: 'Midtjylland'},
                    {text: '   * Sønderjylland', value: 'Sønderjylland'},
                    {text: '   * Fyn', value: 'Fyn'},
                    {text: '   * Sjælland', value: 'Sjælland'},
                ],
                specialistDegree: 'default',
                specialistDegreeOptions: [
                    {text: 'Godkendt til hvilken uddannelse?', value: 'default'},
                    {text: '', value: 0},
                    {text: 'Børneområdet: ', value: 0},
                    {text: '   * Sundhedspsykologi med børn', value: 'Sundhedspsykologi med børn'},
                    {text: '   * Psykoterapi med børn', value: 'Psykoterapi med børn'},
                    {text: '   * Klinisk børnepsykologi', value: 'Klinisk børnepsykologi'},
                    {text: '   * Klinisk børneneuropsykologi', value: 'Klinisk børneneuropsykologi'},
                    {text: '   * Pædagogisk psykologi', value: 'Pædagogisk psykologi'},
                    {text: '', value: 0},
                    {text: 'Voksenområdet: ', value: 0},
                    {text: '   * Sundhedspsykologi med voksne', value: 'Sundhedspsykologi med voksne'},
                    {text: '   * Psykoterapi med voksne', value: 'Psykoterapi med voksne'},
                    {text: '   * Psykopatologi', value: 'Psykopatologi'},
                    {text: '   * Psykotraumatologi', value: 'Psykotraumatologi'},
                    {text: '   * Klinisk Neuropsykologi', value: 'Klinisk Neuropsykologi'},
                    {text: '   * Gerontopsykologi', value: 'Gerontopsykologi'},
                    {text: '', value: 0},
                    {text: 'Arbejds- og organisationspsykologi: ', value: 0},
                    {text: '   * Arbejds- og organisationspsykologi', value: 'Arbejds- og organisationspsykologi'},
                ],
                theoreticalPreference: 'default',
                theoreticalPreferenceOptions: [
                    {text: 'Teoretisk Præference', value: 'default'},
                    {text: '   * Eksistentiel/humanistisk', value: 'Eksistentiel/humanistisk'},
                    {text: '   * Kognitiv/ adfærdsterapeutisk', value: 'Kognitiv/ adfærdsterapeutisk'},
                    {text: '   * Psykodynamisk/psykoanalytisk', value: 'Psykodynamisk/psykoanalytisk'},
                    {text: '   * Systemisk/strukturel', value: 'Systemisk/strukturel'},
                ],
                lookingTeacher: 0,
                errors: [],
                date: {
                    from : {
                        time : ""
                    },
                    to : {
                        time : ""
                    }
                }
                ,
                starttime: '',
                limit: {
                    from : [],
                    to : []                    
                }, 
                optionDatepickerFrom : {
                    type: 'day',
                    week: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
                    month: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    format: 'YYYY-MM-DD',
                    placeholder: 'Dato fra',
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
                optionDatepickerTo : {
                    type: 'day',
                    week: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
                    month: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    format: 'YYYY-MM-DD',
                    placeholder: 'Dato til',
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
                modules : {
                    modul : 0,
                    list : [],
                    result : []
                }
            }
        }
        ,
        created: function () {
            let data = this;
            axios.post('/api/getModulesAll')
                .then(function(response) {
                    data.modules.list = response.data.modules;
                });
        }
        ,
        methods: {
            findModule()
            {
                let data = this;
                data.modules.result = [];
                for(var m in data.modules.list)
                {
                    if(RegExp("^" + data.modules.query + "", "i").test(data.modules.list[m].name))
                    {
                        data.modules.result.push( data.modules.list[m] );
                    }
                }
            },
            selectModule()
            {
                let data = this;
                
                axios.post('/getAllCourseByModule', {module_id : data.modules.modul})
                        .then(function (response) {
                            data.modules.result = [];
                            data.courses = [];
                            for(var i in response.data)
                            {
                                response.data[i].toggle_date = 0;
                                response.data[i].course.course_date = JSON.parse(response.data[i].course.course_date);
                                data.courses.push(response.data[i]);
                            }
                        });
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
            setFromDate()
            { 
                this.limit.to = [{ type : 'fromto', from : this.date.from.time }]; 
            },
            findKursus(){
                let mainData = this;
                let kursusName = mainData.findTeorikursusInput;
                let kursusPlace = mainData.lookingKursus;
                let kursusDegree = mainData.specialistDegree;
                let kursusTheoreticalPreference = mainData.theoreticalPreference;
                let kursusUddannet = mainData.kursusUddannet;
                let kursusTeacher = mainData.findTeachersInput;
                let data = {
                    'userPlace': kursusPlace,
                    'userDegree': kursusDegree,
                    'approved' : kursusUddannet,
                    'dateFrom' : mainData.date.from.time,
                    'dateTo' : mainData.date.to.time
                };
                axios.post('/findKursusProfile', data)
                        .then(function (response) {
                            mainData.courses = [];
                            for(var i in response.data)
                            {
                                response.data[i].toggle_date = 0;
                                if (response.data[i].info.educations) {
                                    response.data[i].info.educations = JSON.parse(response.data[i].info.educations);
                                }
                                
                                mainData.courses.push(response.data[i]);
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
            },
            findTeorikursusByName(){
                let self = this;
                self.findTeachersInput = "";
                axios.post('/findGlobalTeorikurser', {'find': self.findTeorikursusInput})
                        .then(function (response) {
                            self.courses = response.data;
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
            },
            findTeachersByName()
            {
                var mainData = this;
                mainData.findTeorikursusInput = "";
                let querySearch = this.findTeachersInput;
                let data = {'find': querySearch};
                axios.post('/searchGlobalCoursesByTeachers', data)
                        .then(function (response) {
                            mainData.courses = response.data;
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
            },
            createDataList(kursus)
            {
                $('#teorikursus_list').empty();
                kursus.forEach(function (item) {
                    $('#teorikursus_list').append('<option>' + item + '</option>');
                });
            },
            deleteErrors(field)
            {
                if (this.errors[field]) {
                    delete this.errors[field];
                }
            },
            hasError(field)
            {
                return this.errors[field] !== undefined;
            },
            changeColorSelect(select, selectedValue){
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
            changeDropDownLookingKursus()
            {
                this.changeColorSelect($('#lookingKursus'), $('#lookingKursus').val());
            }
            ,
            changeDropDownSpecialistDegree()
            {
                this.changeColorSelect($('#specialistDegree'), $('#specialistDegree').val());
            }
            ,
            changeDropDownTheoreticalPreference()
            {
                this.changeColorSelect($('#theoreticalPreference'), $('#theoreticalPreference').val());
            }
            ,
            getError(field)
            {
                if (this.errors[field]) {
                    return this.errors[field][0];
                }
            }
            ,
            changeTeacher()
            {
            }
        },
        components: {
            'date-picker': Datepicker
        }
    }


</script>
