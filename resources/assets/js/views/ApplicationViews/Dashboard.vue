<template>
    <div>
        <article class="content-block form-group">
            <h3>SUPERVISION</h3>
            <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0"
                     aria-valuemin="0" aria-valuemax="100"
                     v-bind:style="{ width: calculateStatusSupervision(totalAntalTimer,160)+ '%' }">
                    <strong>{{calculateStatusSupervision(totalAntalTimer,160)}}%</strong>
                </div>
            </div>
            <section class="buttons-container">
                <router-link :to="{ name: 'oversigt.supervisors'}" class="btn btn-primary-outline ">
                    oversigt
                </router-link>
                <router-link :to="{ name: 'register.supervisors'}" class="btn btn-primary-outline ">
                    registrer
                </router-link>
            </section>
        </article>

        <article class="content-block">
            <h3>TEORIKURSER</h3>
            <div class="progress">
                <!-- <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                     aria-valuemin="0" aria-valuemax="100" style="width:30%">
                    <strong>30%</strong>
                </div> -->
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0"
                     aria-valuemin="0" aria-valuemax="100"
                     v-bind:style="{ width:  Math.floor(get_all_registers_coursers() / get_all_hours_coursers() * 100) + '%' }">
                    <strong>{{ Math.floor(get_all_registers_coursers() / get_all_hours_coursers() * 100) }}%</strong>
                </div>
            </div>
            <section class="buttons-container">
                <router-link to='/oversignKursus' class="btn btn-primary-outline">
                    oversigt
                </router-link>

                <router-link to='/findKursus' class="btn btn-primary-outline">
                    registrer
                </router-link>
            </section>
        </article>


        <!--<article class="content-block">-->
        <!--<h3>REMINDER</h3>-->
        <!--<div class="col-md-6 text-block">X bliver forældet om 6 måneder</div>-->
        <!--<div class="col-md-6 buttons-container">-->
        <!--<a href="#" class="btn btn-primary-outline ">-->
        <!--tjek-->
        <!--</a>-->
        <!--</div>-->
        <!--</article>-->


        <article class="content-block">
            <div class="col-md-6 text-block-header">
                <h3 class="text-uppercase" style="color: #636b6f;">Supervisorer</h3>
                <p>Dine seneste supervisorforhold</p>
            </div>
            <div class="col-md-6 buttons-container-header">
                <router-link :to="{ name: 'mine.supervisors'}" class="btn btn-primary-outline ">
                    se komplet liste
                </router-link>
            </div>
            <div class="scroll-box" :style=" ! supervisors.length ? 'height:50px;' : '' " >
                <div class="item-box"  v-if=" ! supervisors.length">
                    tom ...
                </div>
                <div class="item-box" v-if="supervisors.length" v-for="supervisor in supervisors">
                    <div class="avatar-section">
                        <div v-if="supervisor.avatar_path != null">
                            <img :src="supervisor.avatar_path"
                                 alt="avatar">
                        </div>
                        <div v-else>
                            <img src="/image/avatar-placeholder.png"
                                 alt="avatar">
                        </div>
                    </div>
                    <div class="text-section">
                        <ul>
                            <li class="bold">{{supervisor.name}} {{supervisor.surname}}</li>
                           <!--if we have real supervisor not created psychology-->
                            <div v-if="supervisor.version!=null">
                                <!--<li>{{supervisor.address_name}}</li>-->
                                <li>{{supervisor.city}}</li>
                                <li>Alder:{{supervisor.age}}</li>
                                <li><b>Specialistgrad:</b></li>
                                <li>
                                    <span>{{supervisor.primary_education}}, </span>
                                    <span v-show="supervisor.secondary_education!='none'">{{supervisor.secondary_education}}, </span>
                                    <span v-show="supervisor.third_education!='none'">{{supervisor.third_education}}, </span>
                                </li>
                                
                                <li v-if="supervisor.trained_leader==1">
                                    Supervisoruddannet: ja
                                </li>

                                <li><b>Teoretisk preference:</b></li>
                                
                                <li>
                                    <span v-if="supervisor.Eksistentiel_humanistisk">Eksistentiel_humanistisk, </span>
                                    <span v-if="supervisor.Kognitiv_adfærdsterapeutisk">Kognitiv/adfærdsterapeutisk, </span>
                                    <span v-if="supervisor.Psykodynamisk_psykoanalytisk">Psykodynamisk/psykoanalytisk, </span>
                                    <span v-if="supervisor.Systemisk_strukturel">Systemisk/strukturel, </span>
                                </li>

                               
                            </div>


                        </ul>
                        <div class="button-section">
                            <!--if supervision has pro account -->
                            <div v-if="supervisor.version =='pro'">
                                <router-link
                                        :to="{ name: 'supervision.profile', params: { idSupervision: supervisor.user_id }}"
                                        class="btn btn-primary-outline ">
                                    profil
                                </router-link>
                            </div>
                            <!--if supervision has free account -->
                            <div v-else-if="supervisor.version =='free'">
                                <router-link
                                        :to="{ name: 'supervision.profile.free', params: { idSupervision: supervisor.user_id }}"
                                        class="btn btn-primary-outline ">
                                    profil
                                </router-link>
                            </div>
                            <!--if supervisor has role self Created supervision -->
                            <div v-else>
                                <router-link
                                        :to="{ name: 'supervision.profile.psychology', params: { idSupervision: supervisor.user_id }}"
                                        class="btn btn-primary-outline ">
                                    profil
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>


        <article class="content-block">
            <div class="col-md-6 text-block-header">
                <h3 class="text-uppercase" style="color: #636b6f;">Kurser</h3> 
                <p style="color: #636b6f;">Seneste kurser du har registreret</p>
            </div>
            <div class="col-md-6 buttons-container-header">
                 <router-link :to="{ name: 'registreringerKursus'}" class="btn btn-primary-outline ">
                    se komplet liste
                </router-link>
            </div>
            <div class="scroll-box" :style=" ! courses.length ? 'height:50px;' : '' ">
                <div class="item-box"   v-if=" ! courses.length">
                    tom ...
                </div>
                <div class="item-box" v-if="courses.length" v-for="c in courses.slice(0, 4)">
                    <div class="avatar-section">
                        <img :src="c.course.user.full_info_about_user.avatar_path ? c.course.user.full_info_about_user.avatar_path : '/image/avatar-placeholder.png'" alt="avatar" />
                    </div>
                    <div class="text-section">
                        <ul>
                            <li class="bold">{{ c.course.course_name }}</li>
                            <li>Kursusnummer: {{ c.course.course_number }}</li>
                            <li>Dato {{ c.course.course_date }}</li>
                            <li v-show="c.course.course_approved">Godkendt af DP</li>
                        </ul>
                        <div class="button-section">
                            <router-link :to="{ name: 'course.profile', params: { idCourse: c.course.user_id }}" class="btn btn-primary-outline "> 
                                se profil
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        
        <br />
        <br />
        <br />

    </div>
</template>

<script>
    import {SortingData} from "../../helpers/SortingData";

    export default {
        data()
        {
            return {
                supervisors: [],
                totalAntalTimer: 0,
                SortingData: {},
                courses : [],
                groups : [],
                registers : []
            }
        }
        ,
        mounted() {
            this.SortingData = new SortingData();
            let mainData = this;

            axios.post('/getDashbaordGroups', {})
                .then(function (response) {
                    mainData.groups = response.data.gropus;
                    mainData.registers = response.data.registers;
                });

            this.getRegisterCourses();
        }
        ,
        methods : {
            get_all_hours_coursers() {
                var count = 0;
                for(var i in this.groups) {
                    count += this.groups[i].hours;
                }
                return count;
            },
             get_all_registers_coursers() {
                var count = 0;
                for(var i in this.registers) {
                    count += this.registers[i];
                }
                return count;
            },
            calculateStatusSupervision(currentValue, totalValue){
                let result = Math.floor((currentValue * 100 / totalValue) * 100) / 100;
                return result >= 100 ? 100 : result;
            },
            calculateStatusTeorikurser(currentValue, totalValue) {
                let result = parseInt(Math.floor((currentValue * 100 / totalValue) * 100) / 100, 0);
                return result >= 100 ? 100 : result;
            },
            getRegisterCourses()
            {
                let mainInfo = this;
                for(var c in mainInfo.courses) {
                    mainInfo.totalAntalTimerCourser = mainInfo.courses[c].course.course_hours;
                }
                
                axios.get('/getMineListSupervisors') 
                        .then(function (response) {
                            mainInfo.totalAntalTimer = response.data.totalHoursSession;
                            mainInfo.supervisors = mainInfo.SortingData.sortMineSupervisionData(response.data.supervisors, 'created_at').slice(0, 4);
                        });

                axios.get('/getRegisterCourses')
                        .then(function (response) {
                            mainInfo.courses = response.data;
                        });
            }
        }
    }
</script>
