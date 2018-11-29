<template>
    <div>
    <article class="content-block-profil">
        <h3>FIND SUPERVISOR</h3>
        <!--<button @click="TEST">TEST</button>-->
        <hr>
        <form action="" @submit.prevent="findSupervisor" @keydown="deleteErrors($event.target.name)">
            <div class="col-md-6 find-supervisor-container">

                <div class="row text-center">
                    <select class="application-select" id="lookingSupervisor" v-model="lookingSupervisor"
                            @change="changeDropDownLookingSupervisor">
                        <option class="default-option" v-for="option in lookingSupervisorOptions"
                                v-bind:value="option.value" :disabled="option.value==0"  :class="{bold : option.value == 0 }">
                            {{ option.text }}
                        </option>
                    </select>
                </div>

                <div class="row">
                    <input type="text" name="name" class="application-input" id="findSupervisor"
                           list="supervisor_list" v-model="findSupervisorInput" placeholder="Søger du bestemt supervisor?"
                           @keyup="findSupervisorByName">
                    <datalist id="supervisor_list">
                        <option></option>
                    </datalist>

                </div>

                <div class="find-supervisor-btn" style="margin-left: 5px">
                    <button type="submit" class="button light-green profil-button ">Søg</button>
                </div>
            </div>
            <div class="col-md-6 find-supervisor-container">
                <div class="row text-center">
                    <select class="application-select" id="specialistDegree" v-model="specialistDegree"
                            @change="changeDropDownSpecialistDegree">
                        <option class="default-option" v-for="option in specialistDegreeOptions"
                                v-bind:value="option.value" :class="{bold : option.value == 0 }" :disabled="option.value==0">
                            {{ option.text }}
                        </option>
                    </select>
                </div>
                
                <div class="row">
                    <div class="check-box">
                    <span class="check-description">
                        Supervisoruddannet?
                    </span>
                        <div class="customCheckbox">
                            <input type="checkbox" id="checkbox-1-1" class="regular-checkbox"
                                   v-model="supervisorUddannet"/>
                            <label for="checkbox-1-1"></label>
                        </div>
                    </div>
                </div>

                <div class="row text-center">
                    <select class="application-select" id="theorXeticalPreference" v-model="theoreticalPreference"
                            @change="changeDropDownTheoreticalPreference">
                        <option class="default-option" v-for="option in theoreticalPreferenceOptions"
                                v-bind:value="option.value" :disabled="option.value==0">
                            {{ option.text }}
                        </option>
                    </select>
                </div>

                
            </div>
        </form>

        <div class="row col-md-12">
            <article class="content-block-result">
                <div class="scroll-box">
                    <div class="item-box" v-for="supervisor in supervisors">
                        <div class="avatar-section">
                            <div v-if="supervisor && supervisor.full_info_about_user && supervisor.full_info_about_user.avatar_path">
                                <img class="avatarImageFindResult" :src="supervisor.full_info_about_user.avatar_path" alt="avatar" />
                            </div>
                            <div v-else>
                                <img class="avatarImageFindResult" src="/image/avatar-placeholder.png"
                                     alt="avatar">
                            </div>
                        </div>
                        <div class="text-section">
                            <ul>
                                <li class="bold">{{supervisor.name}} {{supervisor.surname}}</li>
                                <!--<li>{{supervisor.address.address_name}}</li>-->
                                <li v-if="supervisor && supervisor.full_info_about_user && supervisor.full_info_about_user.city != null"><b>Praksis beliggenhed :</b> {{ supervisor.full_info_about_user.city }}</li>
                                <li v-if="supervisor && supervisor.full_info_about_user && supervisor.full_info_about_user.age  != null"><b>Alder</b>: {{ supervisor.full_info_about_user.age }}</li>

                                <li><b>Uddannelse i: </b> {{ supervisor.education && supervisor.education.primary_education ?  supervisor.education.primary_education : '' }}</li>
                                <li v-show="supervisor.education && supervisor.education.secondary_education != 'none'">{{ supervisor.education && supervisor.education.secondary_education ? supervisor.education.secondary_education : '' }}</li>
                                <li v-show="supervisor.education && supervisor.education.third_education != 'none'">{{ supervisor.education && supervisor.education.third_education ? supervisor.education.third_education : '' }}</li>

                                <li v-if="supervisor && supervisor.full_info_about_user && supervisor.full_info_about_user.trained_leader">
                                    Supervisoruddannet:ja
                                </li>

                                <li>
                                    <b>Teoretisk preference:</b>
                                    <span v-if="supervisor.speciality && supervisor.speciality.Eksistentiel_humanistisk">Eksistentiel/humanistisk, </span>
                                    <span v-if="supervisor.speciality && supervisor.speciality.Kognitiv_adfærdsterapeutisk">Kognitiv/adfærdsterapeutisk, </span>
                                    <span v-if="supervisor.speciality && supervisor.speciality.Psykodynamisk_psykoanalytisk">Psykodynamisk/psykoanalytisk, </span>
                                    <span v-if="supervisor.speciality && supervisor.speciality.Systemisk_strukturel">Systemisk/strukturel, </span>
                                </li>

                            </ul>
                            <div class="button-section">
                                <!--if supervision has pro account -->
                                <div v-if="supervisor && supervisor.full_info_about_user && supervisor.full_info_about_user.version == 'pro'">
                                    <router-link
                                            :to="{ name: 'supervision.profile', params: { idSupervision: supervisor.id  }}"
                                            class="btn btn-primary-outline ">
                                        profil
                                    </router-link>
                                </div>
                                <!--if supervision has free account -->
                                <div v-else>
                                    <router-link
                                            :to="{ name: 'supervision.profile.free', params: { idSupervision: supervisor.id  }}"
                                            class="btn btn-primary-outline ">
                                        profil
                                    </router-link>

                                </div>
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
    export default {
//        Collect information to vue.data
        data()
        {
            return {
                findSupervisorInput: '',
                lookingSupervisor: 'default',
                supervisorUddannet: false,
                lookingSupervisorOptions: [
                    {text: 'Hvor søger du supervisor?', value: 'default'},
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
                    {text: 'Specialistuddannet?', value: 'default'},
                    {text: '', value: 0},
                    {text: 'Børneområdet: ', value: 0},
                    {text: '   * Sundhedspsykologi med børn', value: 'Sundhedspsykologi med børn'},
                    {text: '   * Psykoterapi med børn', value: 'Psykoterapi med børn'},
                    {text: '   * Klinisk børnepsykologi', value: 'Klinisk børnepsykologi'},
                    {text: '   * Klinisk børneneuropsykologi', value: 'Klinisk børneneuropsykologi'},
                    {text: '   * Pædagogisk psykologi', value: 'Pædagogisk psykologi'},
                    {text: '', value: 0},
                    {text: 'Voksenområdet : ', value: 0},
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
                    {text: '   * Eksistentiel/humanistisk', value: 'Eksistentiel_humanistisk'},
                    {text: '   * Kognitiv/ adfærdsterapeutisk', value: 'Kognitiv_adfærdsterapeutisk'},
                    {text: '   * Psykodynamisk/psykoanalytisk', value: 'Psykodynamisk_psykoanalytisk'},
                    {text: '   * Systemisk/strukturel', value: 'Systemisk_strukturel'},
                ],
                supervisors: [],
                errors: [],
            }
        }
        ,
        //        when component created get info about user
        created: function () {


        }
        ,
        methods: {
            TEST(){
              this.$emit('increment');
            },

            findSupervisor (){
                let mainData = this;
                let supervisorName = mainData.findSupervisorInput;
                let supervisionPlace = mainData.lookingSupervisor;
                let supervisorDegree = mainData.specialistDegree;
                let supervisorTheoreticalPreference = mainData.theoreticalPreference;
                let supervisorUddannet = mainData.supervisorUddannet;
                let data = {
                    'userName': supervisorName,
                    'userPlace': supervisionPlace,
                    'userDegree': supervisorDegree,
                    'userTheoreticalPreference': supervisorTheoreticalPreference,
                    'userUddannet': supervisorUddannet,
                };
                console.log(data);
                axios.post('/findSupervisionProfile', data)
                        .then(function (response) {
                            mainData.supervisors = response.data;
                        })
                        .catch(function (error) {
                            console.log(error);
                        });

            },
            findSupervisorByName()
            {
                var mainData = this;
                let querySearch = this.findSupervisorInput;
                let data = {'find': querySearch};
                axios.post('/findGlobalSupervision', data)
                        .then(function (response) {
                            let supervisors = response.data;
//                            console.log(supervisors);
                            var list = [];
                            supervisors.forEach(function (item, i) {
                                list[i] = item.name + ' ' + item.surname;
                            });
                            mainData.createDataList(list)
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
            },
            createDataList(supervisors)
            {
                $('#supervisor_list').empty();
                supervisors.forEach(function (item) {
                    $('#supervisor_list').append('<option>' + item + '</option>');
//                    console.log(item);
                });
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
            },
            changeDropDownLookingSupervisor()
            {
                this.changeColorSelect($('#lookingSupervisor'), $('#lookingSupervisor').val());
            },
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

        }
    }


</script>
