<template>
    <div>
        <article class="content-block-profil content-block container-fluid" v-show="checksOpt.indexOf('antalSupervisionstimerCheck') + 1">
            <div class="row" >
                <h3>STATUS FOR SUPERVISION : <span v-if="user && user.ps && user.ps.name">{{ user.ps.name }}</span></h3>
                <hr>
            </div>
            <div class="row" >
                <div class="col-md-2 col-md-offset-5 block-value">
                    <p class="text-center"><strong>REGISTRERET</strong></p>
                </div>
                <div class="col-md-2 block-value">
                    <p class="text-center"><strong>OMREGNET</strong></p>
                </div>
                <div class="col-md-2 block-value">
                    <p class="text-center"><strong>KRAV</strong></p>
                </div>
            </div>
            <div class="row value-wrapper">
                <div class="col-md-5 block-value">
                    <p class="headline main-head"><strong>Antal supervisionstimer</strong></p>
                </div>
                <div class="col-md-2 block-value">
                    <p class="headline text-center"><strong>{{checkValueRegisteret(totalAntalTimer,1000)}}</strong></p>
                </div>
                <div class="col-md-2 block-value">
                    <p class="headline text-center"><strong>{{totalAntalTimerOmregnet}}</strong></p>
                </div>
                <div class="col-md-2 block-value">
                    <p class="headline text-center"><strong>{{ optionsSv['antalSupervisionstimer'] ? optionsSv['antalSupervisionstimer'] : 160  }}</strong></p>
                </div>
            </div>
            
           

            <div class="row">
                <div class="col-md-11">
                    <div class="progress out-space">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0"
                             aria-valuemin="0" aria-valuemax="100"
                             v-bind:style="{ width: calculateStatusSupervision(totalAntalTimerOmregnet, optionsSv['antalSupervisionstimer'] ? optionsSv['antalSupervisionstimer'] : 160)+ '%' }">
                            <strong>{{calculateStatusSupervision(totalAntalTimerOmregnet, optionsSv['antalSupervisionstimer'] ? optionsSv['antalSupervisionstimer'] : 160)}}%</strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 text-center">
                </div>
            </div>
            
             <br />

            <div class="require-wrapper">
                <p v-html="ps_text"></p>
            </div>

        </article>

        <!--Section to check supervision udredning_intervention  start-->

        <!--HOT FIX with duplicating code-->
        <!--have implemented methods for normal check status supervision-->
        <article  class="content-block-profil content-block container-fluid" >
            <section class="status">

                <div v-if="supervision_options.length>0" >
                    <div class="row headline-row" v-show="checksOpt.indexOf('supervisionstimerInterventionCheck') + 1">
                        <div class="col-md-5 block-value">
                            <p class="value-text main-head">Supervisionstimer Intervention</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">REGISTRERET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">OMREGNET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">KRAV</p>
                        </div>

                    </div>

                    <div class="row value-wrapper" v-show="checksOpt.indexOf('supervisionstimerInterventionCheck') + 1">
                        <div v-if="checkListType(supervision_options,'intervention')">
                            <div class="col-md-5">
                                <div class="progress out-space">
                                    <div class="progress-bar progress-bar-success" role="progressbar"
                                         aria-valuenow="100"
                                         aria-valuemin="0" aria-valuemax="100"
                                         v-bind:style="{ width: calculateStatusSupervision(interventionOmregnet, optionsSv['supervisionstimerIntervention'] ? optionsSv['supervisionstimerIntervention'] : 100) + '%' }">
                                        <strong>{{calculateStatusSupervision(interventionOmregnet, optionsSv['supervisionstimerIntervention'] ? optionsSv['supervisionstimerIntervention'] : 100)}}%</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                    {{checkValueRegisteret(interventionHours,1000)}}</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">{{interventionOmregnet}}</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                    {{ optionsSv['supervisionstimerIntervention'] ? optionsSv['supervisionstimerIntervention'] : 100  }}</p>
                            </div>
                            <div class="col-md-1 text-center">
                                <div v-if="intervationSupervisor">
                                    <!-- <img class="knap-pic" src="/image/info-knap-green.png" alt="info-knap"> -->
                                </div>
                                <div v-else>
                                    <!--<img class="knap-pic" @click="infoMessage()" src="/image/info-knap-red.png"
                                         alt="info-knap">-->
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <div class="col-md-5">
                                <div class="progress out-space">
                                    <div class="progress-bar progress-bar-success" role="progressbar"
                                         aria-valuenow="100"
                                         aria-valuemin="0" aria-valuemax="100"
                                         v-bind:style="{ width: 0 + '%' }">
                                        <strong>0%</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                    0</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">0</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                    {{ optionsSv['supervisionstimerIntervention'] ? optionsSv['supervisionstimerIntervention'] : 100  }}</p>
                            </div>
                            <div class="col-md-1 text-center">
                                <!--<img class="knap-pic" @click="infoMessage()" src="/image/info-knap-red.png"
                                     alt="info-knap">-->
                            </div>
                        </div>
                    </div>

                    <hr class="oversigtLine">

                    <div class="row headline-row" v-show="checksOpt.indexOf('longtermEducationCheck') + 1">
                        <div class="col-md-5 block-value">
                            <p class="value-text main-head">Længerevarende uddannelsesforløb</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">REGISTRERET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">OMREGNET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">KRAV</p>
                        </div>
                    </div>

                    <div class="row value-wrapper" v-show="checksOpt.indexOf('longtermEducationCheck') + 1">
                        <div v-if="checkListType(supervision_options,'ja')">
                            <div class="col-md-5">
                                <div class="progress out-space">
                                    <div class="progress-bar progress-bar-success" role="progressbar"
                                         aria-valuenow="60"
                                         aria-valuemin="0" aria-valuemax="100"
                                         v-bind:style="{ width: calculateStatusSupervision(LængerevarendeOmregnet, optionsSv['longtermEducation'] ? optionsSv['longtermEducation'] : 60 ) + '%' }">
                                        <strong>{{calculateStatusSupervision(LængerevarendeOmregnet, optionsSv['longtermEducation'] ? optionsSv['longtermEducation'] : 60 )}}%</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                    {{checkValueRegisteret(LængerevarendeHours,1000)}}</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">{{LængerevarendeOmregnet}}</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">{{ optionsSv['longtermEducation'] ? optionsSv['longtermEducation'] : 60 }}</p>
                            </div>
                            <div class="col-md-1 text-center">
                                <!-- <img class="knap-pic" src="/image/info-knap.png" alt="info-knap"> -->
                                <!-- </a> -->
                            </div>
                        </div>
                        <div v-else>
                            <div class="col-md-5">
                                <div class="progress out-space">
                                    <div class="progress-bar progress-bar-success" role="progressbar"
                                         aria-valuenow="60"
                                         aria-valuemin="0" aria-valuemax="100"
                                         v-bind:style="{ width: 0 + '%' }">
                                        <strong>0%</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                    0</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">0</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">{{ optionsSv['longtermEducation'] ? optionsSv['longtermEducation'] : 60 }}</p>
                            </div>
                            <div class="col-md-1 text-center">
                                <!-- <img class="knap-pic" src="/image/info-knap.png" alt="info-knap"> -->
                            </div>
                        </div>
                    </div>

                    <div class="row headline-row" v-show="checksOpt.indexOf('liveVideoAudioCheck') + 1">
                        <div class="col-md-5 block-value">
                            <p class="value-text main-head">Live Video/Audio</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">REGISTRERET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">OMREGNET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">KRAV</p>
                        </div>
                    </div>

                    <div class="row value-wrapper" v-show="checksOpt.indexOf('liveVideoAudioCheck') + 1">
                        <div v-if="checkListType(supervision_options,'Live Video/Audio')">
                            <div class="col-md-5">
                                <div class="progress out-space">
                                    <div class="progress-bar progress-bar-success" role="progressbar"
                                         aria-valuenow="60"
                                         aria-valuemin="0" aria-valuemax="100"
                                         v-bind:style="{ width: calculateStatusSupervision(LiveVideoOmregnet, optionsSv['liveVideoAudio'] ? optionsSv['liveVideoAudio'] : 30) + '%' }">
                                        <strong>{{calculateStatusSupervision(LiveVideoOmregnet,  optionsSv['liveVideoAudio'] ? optionsSv['liveVideoAudio'] : 30)}}%</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                    {{checkValueRegisteret(LiveVideoHours,1000)}}</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">{{LiveVideoOmregnet}}</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">{{  optionsSv['liveVideoAudio'] ? optionsSv['liveVideoAudio'] : 30 }}</p>
                            </div>
                            <div class="col-md-1 text-center">
                                <!-- <img class="knap-pic" src="/image/info-knap.png" alt="info-knap"> -->
                                <!-- </a> -->
                            </div>
                        </div>
                        <div v-else>
                            <div class="col-md-5">
                                <div class="progress out-space">
                                    <div class="progress-bar progress-bar-success" role="progressbar"
                                         aria-valuenow="60"
                                         aria-valuemin="0" aria-valuemax="100"
                                         v-bind:style="{ width: 0 + '%' }">
                                        <strong>0%</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                    0</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">0</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">{{  optionsSv['liveVideoAudio'] ? optionsSv['liveVideoAudio'] : 30 }}</p>
                            </div>
                            <div class="col-md-1 text-center">
                                <!-- <img class="knap-pic" src="/image/info-knap.png" alt="info-knap"> -->
                            </div>
                        </div>
                    </div>


                    <div class="row headline-row" v-show="checksOpt.indexOf('eksternSupervisionCheck') + 1">
                        <div class="col-md-5 block-value">
                            <p class="value-text main-head">Ekstern supervision</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">REGISTRERET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">OMREGNET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">KRAV</p>
                        </div>
                    </div>

                    <div class="row value-wrapper" v-show="checksOpt.indexOf('eksternSupervisionCheck') + 1">
                        <div v-if="checkListType(supervision_options,'ekstern')">
                            <div class="col-md-5">
                                <div class="progress out-space">
                                    <div class="progress-bar progress-bar-success" role="progressbar"
                                         aria-valuenow="100"
                                         aria-valuemin="0" aria-valuemax="100"
                                         v-bind:style="{ width: calculateStatusSupervision(eksternOmregnet,  optionsSv['eksternSupervision'] ? optionsSv['eksternSupervision'] :20) + '%' }">
                                        <strong>{{calculateStatusSupervision(eksternOmregnet, optionsSv['eksternSupervision'] ? optionsSv['eksternSupervision'] :20)}}%</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                    {{checkValueRegisteret(eksternHours,1000)}}</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">{{eksternOmregnet}}</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                    {{ optionsSv['eksternSupervision'] ? optionsSv['eksternSupervision'] :20 }}</p>
                            </div>
                            <div class="col-md-1 text-center">
                                <!-- <img class="knap-pic" src="/image/info-knap.png" alt="info-knap"> -->
                            </div>
                        </div>
                        <div v-else>
                            <div class="col-md-5">
                                <div class="progress out-space">
                                    <div class="progress-bar progress-bar-success" role="progressbar"
                                         aria-valuenow="100"
                                         aria-valuemin="0" aria-valuemax="100"
                                         v-bind:style="{ width: 0 + '%' }">
                                        <strong>0%</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                    0</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">0</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                    {{ optionsSv['eksternSupervision'] ? optionsSv['eksternSupervision'] :20 }}</p>
                            </div>
                            <div class="col-md-1 text-center">
                                <!-- <img class="knap-pic" src="/image/info-knap.png" alt="info-knap"> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else >
                    <div class="row headline-row"  v-show="checksOpt.indexOf('supervisionstimerInterventionCheck') + 1">
                        <div class="col-md-5 block-value">
                            <p class="value-text main-head">Supervisionstimer Intervention</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">REGISTRERET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">OMREGNET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">KRAV</p>
                        </div>
                    </div>
                    <div class="row value-wrapper"  v-show="checksOpt.indexOf('supervisionstimerInterventionCheck') + 1">
                        <div class="col-md-5">
                            <div class="progress out-space">
                                <div class="progress-bar progress-bar-success" role="progressbar"
                                     aria-valuenow="100"
                                     aria-valuemin="0" aria-valuemax="100"
                                     v-bind:style="{ width:0+ '%' }">
                                    <strong>0%</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">
                                0</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">0</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">
                                {{ optionsSv['supervisionstimerIntervention'] ? optionsSv['supervisionstimerIntervention'] : 100 }}</p>
                        </div>
                        <div class="col-md-1 text-center">
                            <!--<img class="knap-pic" @click="infoMessage()" src="/image/info-knap-red.png" alt="info-knap">-->
                        </div>
                    </div>
                    <hr>
                    <div class="row headline-row"  v-show="checksOpt.indexOf('longtermEducationCheck') + 1">
                        <div class="col-md-5 block-value">
                            <p class="value-text main-head">Længerevarende uddannelsesforløb</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">REGISTRERET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">OMREGNET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">KRAV</p>
                        </div>
                    </div>
                    <div class="row value-wrapper"  v-show="checksOpt.indexOf('longtermEducationCheck') + 1">
                        <div class="col-md-5">
                            <div class="progress out-space">
                                <div class="progress-bar progress-bar-success" role="progressbar"
                                     aria-valuenow="60"
                                     aria-valuemin="0" aria-valuemax="100"
                                     v-bind:style="{ width: 0 + '%' }">
                                    <strong>0%</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 block-value">
                            <p class="text-center headline">0</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">0</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">{{ optionsSv['longtermEducation'] ? optionsSv['longtermEducation'] : 60 }}</p>
                        </div>
                        <div class="col-md-1 text-center">
                            <!--<img class="knap-pic" src="/image/info-knap.png" alt="info-knap">
                            </a>-->
                        </div>
                    </div>

                    <div class="row headline-row" v-show="checksOpt.indexOf('liveVideoAudioCheck') + 1">
                        <div class="col-md-5 block-value">
                            <p class="value-text main-head">Live Video/Audio</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">REGISTRERET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">OMREGNET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">KRAV</p>
                        </div>
                    </div>
                    <div class="row value-wrapper" v-show="checksOpt.indexOf('liveVideoAudioCheck') + 1">
                        <div class="col-md-5">
                            <div class="progress out-space">
                                <div class="progress-bar progress-bar-success" role="progressbar"
                                     aria-valuenow="60"
                                     aria-valuemin="0" aria-valuemax="100"
                                     v-bind:style="{ width: 0 + '%' }">
                                    <strong>0%</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">0</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">0</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">{{ optionsSv['liveVideoAudio'] ? optionsSv['liveVideoAudio'] : 30 }}</p>
                        </div>
                        <div class="col-md-1 text-center">
                            <!--<img class="knap-pic" src="/image/info-knap.png" alt="info-knap">-->
                        </div>
                    </div>

                    <div class="row headline-row" v-show="checksOpt.indexOf('eksternSupervisionCheck') + 1">
                        <div class="col-md-5 block-value">
                            <p class="value-text main-head">Ekstern supervision</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">REGISTRERET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">OMREGNET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">KRAV</p>
                        </div>
                    </div>
                    <div class="row value-wrapper" v-show="checksOpt.indexOf('eksternSupervisionCheck') + 1">
                        <div class="col-md-5">
                            <div class="progress out-space">
                                <div class="progress-bar progress-bar-success" role="progressbar"
                                     aria-valuenow="60"
                                     aria-valuemin="0" aria-valuemax="100"
                                     v-bind:style="{ width: 0 + '%' }">
                                    <strong>0%</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">0</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">0</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">{{ optionsSv['eksternSupervision'] ? optionsSv['eksternSupervision'] : 20 }}</p>
                        </div>
                        <div class="col-md-1 text-center">
                            <!--<img class="knap-pic" src="/image/info-knap.png" alt="info-knap">-->
                        </div>
                    </div>
                </div>
            </section>
        </article>
        <!--ARTICLE UDRED-->
        <article   v-show="(checksOpt.indexOf('supervisionstimerUdredningCheck') + 1)" class="content-block-profil content-block container-fluid">
            <div v-if="supervision_options.length>0" v-show="checksOpt.indexOf('supervisionstimerUdredningCheck') + 1">
                <div class="row headline-row">
                    <div class="col-md-5 block-value">
                        <p class="value-text main-head">Supervisionstimer udredning</p>
                    </div>
                    <div class="col-md-2 block-value">
                        <p class="text-center">REGISTRERET</p>
                    </div>
                    <div class="col-md-2 block-value">
                        <p class="text-center">OMREGNET</p>
                    </div>
                    <div class="col-md-2 block-value">
                        <p class="text-center">KRAV</p>
                    </div>
                </div>
                <div class="row value-wrapper" v-show="checksOpt.indexOf('supervisionstimerUdredningCheck') + 1">
                    <div v-if="checkListType(supervision_options,'udredning')">
                        <div class="col-md-5">
                            <div class="progress out-space">
                                <div class="progress-bar progress-bar-success" role="progressbar"
                                     aria-valuenow="100"
                                     aria-valuemin="0" aria-valuemax="100"
                                     v-bind:style="{ width: calculateStatusSupervision(udredningOmregnet, optionsSv['supervisionstimerUdredning'] ? optionsSv['supervisionstimerUdredning'] : 60) + '%' }">
                                    <strong>{{calculateStatusSupervision(udredningOmregnet, optionsSv['supervisionstimerUdredning'] ? optionsSv['supervisionstimerUdredning'] : 60 )}}%</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">
                                {{checkValueRegisteret(udredningHours,1000)}}</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">{{udredningOmregnet}}</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">
                                {{ optionsSv['supervisionstimerUdredning'] ? optionsSv['supervisionstimerUdredning'] : 60 }}</p>
                        </div>
                        <div class="col-md-1 text-center">
                            <div v-if="udredningSupervisor">
                                <!-- <img class="knap-pic" src="/image/info-knap-green.png" alt="info-knap"> -->
                            </div>
                            <div v-else>
                                <!--<img class="knap-pic" @click="infoMessage()" src="/image/info-knap-red.png"
                                     alt="info-knap">-->
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <div class="col-md-5">
                            <div class="progress out-space">
                                <div class="progress-bar progress-bar-success" role="progressbar"
                                     aria-valuenow="100"
                                     aria-valuemin="0" aria-valuemax="100"
                                     v-bind:style="{ width: 0 + '%' }">
                                    <strong>0%</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">
                                0</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">0</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">
                                {{ optionsSv['supervisionstimerUdredning'] ? optionsSv['supervisionstimerUdredning'] : 60 }}</p></p>
                        </div>
                        <div class="col-md-1 text-center">
                            <!--<img class="knap-pic" @click="infoMessage()" src="/image/info-knap-red.png"
                                 alt="info-knap">-->
                        </div>
                    </div>
                </div>
            </div>

            <div v-else>
                <div class="row headline-row" v-show="checksOpt.indexOf('supervisionstimerUdredningCheck') + 1">
                    <div class="col-md-5 block-value">
                        <p class="value-text main-head">Supervisionstimer udredning</p>
                    </div>
                    <div class="col-md-2 block-value">
                        <p class="text-center">REGISTRERET</p>
                    </div>
                    <div class="col-md-2 block-value">
                        <p class="text-center">OMREGNET</p>
                    </div>
                    <div class="col-md-2 block-value">
                        <p class="text-center">KRAV</p>
                    </div>
                </div>
                <div class="row value-wrapper" v-show="checksOpt.indexOf('supervisionstimerUdredningCheck') + 1">
                    <div class="col-md-5">
                        <div class="progress out-space">
                            <div class="progress-bar progress-bar-success" role="progressbar"
                                 aria-valuenow="100"
                                 aria-valuemin="0" aria-valuemax="100"
                                 v-bind:style="{ width:0+ '%' }">
                                <strong>0%</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 block-value">
                        <p class="text-center headline">
                            0</p>
                    </div>
                    <div class="col-md-2 block-value">
                        <p class="text-center headline">0</p>
                    </div>
                    <div class="col-md-2 block-value">
                        <p class="text-center headline">
                            {{ optionsSv['supervisionstimerUdredning'] ? optionsSv['supervisionstimerUdredning'] : 40 }}
                        </p>
                    </div>
                    <div class="col-md-1 text-center">
                        <!--<img class="knap-pic" @click="infoMessage()" src="/image/info-knap-red.png" alt="info-knap">-->
                    </div>
                </div>
            </div>
        </article>


        <!--Section to check supervision udredning_intervention  END-->

        <!--Section to check supervision induvidual and group START-->
        <article v-show="(checksOpt.indexOf('individuelSupervisionCheck') + 1) || (checksOpt.indexOf('gruppeSupervisionCheck') + 1) " class="content-block-profil content-block container-fluid">
            <section class="status">
                <div v-if="supervision_options.length>0">
                    <div class="row headline-row"  v-show="checksOpt.indexOf('individuelSupervisionCheck') + 1">
                        <div class="col-md-5 block-value">
                            <p class="value-text main-head">Individuel supervision</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">REGISTRERET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">OMREGNET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">KRAV</p>
                        </div>
                    </div>
                    <div class="row value-wrapper" v-show="checksOpt.indexOf('individuelSupervisionCheck') + 1">
                        <div v-if="checkListType(supervision_options,'individuel')">
                            <div class="col-md-5">
                                <div class="progress out-space">
                                    <div class="progress-bar progress-bar-success" role="progressbar"
                                         aria-valuenow="100"
                                         aria-valuemin="0" aria-valuemax="100"
                                         v-bind:style="{ width: calculateStatusSupervision(individuelOmregnet, optionsSv['individuelSupervision'] ? optionsSv['individuelSupervision'] : 40 ) + '%' }">
                                        <strong>{{calculateStatusSupervision(individuelOmregnet, optionsSv['individuelSupervision'] ? optionsSv['individuelSupervision'] : 40 )}}%</strong>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                    {{checkValueRegisteret(individuelHours,1000)}}</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">{{individuelOmregnet}}</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">{{ optionsSv['individuelSupervision'] ? optionsSv['individuelSupervision'] : 40 }}</p>
                            </div>
                            <div class="col-md-1 text-center">
                                <!-- <img class="knap-pic" src="/image/info-knap.png" alt="info-knap"> -->
                                <!-- </a> -->
                            </div>
                        </div>
                        <div v-else>
                            <div class="col-md-5">
                                <div class="progress out-space">
                                    <div class="progress-bar progress-bar-success" role="progressbar"
                                         aria-valuenow="100"
                                         aria-valuemin="0" aria-valuemax="100"
                                         v-bind:style="{ width: 0 + '%' }">
                                        <strong>0%</strong>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                    0</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">0</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">{{ optionsSv['individuelSupervision'] ? optionsSv['individuelSupervision'] : 40 }}</p>
                            </div>
                            <div class="col-md-1 text-center">
                                <!-- <img class="knap-pic" src="/image/info-knap.png" alt="info-knap"> -->
                                <!-- </a> -->
                            </div>
                        </div>
                    </div>

                    <div class="row headline-row" v-show="checksOpt.indexOf('gruppeSupervisionCheck') + 1">
                        <div class="col-md-5 block-value">
                            <p class="value-text main-head">Gruppe supervision</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">REGISTRERET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">OMREGNET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">KRAV</p>
                        </div>
                    </div>
                    <div class="row value-wrapper" v-show="checksOpt.indexOf('gruppeSupervisionCheck') + 1">
                        <div v-if="checkListType(supervision_options,'gruppe')">
                            <div class="col-md-5">
                                <div class="progress out-space">
                                    <div class="progress-bar progress-bar-success" role="progressbar"
                                         aria-valuenow="100"
                                         aria-valuemin="0" aria-valuemax="100"
                                         v-bind:style="{ width: calculateStatusSupervision(gruppeOmregnet, optionsSv['gruppeSupervision'] ? optionsSv['gruppeSupervision'] : 40) + '%' }">
                                        <strong>{{calculateStatusSupervision(gruppeOmregnet, optionsSv['gruppeSupervision'] ? optionsSv['gruppeSupervision'] : 40)}}%</strong>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                    {{checkValueRegisteret(gruppeHours,1000)}}</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">{{gruppeOmregnet}}</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">{{ optionsSv['gruppeSupervision'] ? optionsSv['gruppeSupervision'] : 40 }}</p>
                            </div>
                            <div class="col-md-1 text-center">
                                <!-- <img class="knap-pic" src="/image/info-knap.png" alt="info-knap"
                                     @click="groupInfoMessage">
                                </a> -->
                            </div>
                        </div>
                        <div v-else>
                            <div class="col-md-5">
                                <div class="progress out-space">
                                    <div class="progress-bar progress-bar-success" role="progressbar"
                                         aria-valuenow="100"
                                         aria-valuemin="0" aria-valuemax="100"
                                         v-bind:style="{ width: 0 + '%' }">
                                        <strong>0%</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                    0</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">0</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">{{ optionsSv['gruppeSupervision'] ? optionsSv['gruppeSupervision'] : 40 }}</p>
                            </div>
                            <div class="col-md-1 text-center">
                                <!-- <img class="knap-pic" src="/image/info-knap.png" alt="info-knap"> -->
                                <!-- </a> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <div class="row headline-row" v-show="checksOpt.indexOf('individuelSupervisionCheck') + 1">
                        <div class="col-md-5 block-value" >
                            <p class="value-text main-head">Individuel supervision</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">REGISTRERET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">OMREGNET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">KRAV</p>
                        </div>
                    </div>
                    <div class="row value-wrapper" v-show="checksOpt.indexOf('individuelSupervisionCheck') + 1">
                        <div class="col-md-5">
                            <div class="progress out-space">
                                <div class="progress-bar progress-bar-success" role="progressbar"
                                     aria-valuenow="100"
                                     aria-valuemin="0" aria-valuemax="100"
                                     v-bind:style="{ width:0+ '%' }">
                                    <strong>0%</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">
                                0</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">0</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">
                                {{ optionsSv['individuelSupervision'] ? optionsSv['individuelSupervision'] : 40 }}</p>
                        </div>
                        <div class="col-md-1 text-center">
                            
                        </div>
                    </div>

                    <div class="row headline-row" v-show="checksOpt.indexOf('gruppeSupervisionCheck') + 1">
                        <div class="col-md-5 block-value">
                            <p class="value-text main-head">Gruppe supervision</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">REGISTRERET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">OMREGNET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">KRAV</p>
                        </div>
                    </div>
                    <div class="row value-wrapper" v-show="checksOpt.indexOf('gruppeSupervisionCheck') + 1">
                        <div class="col-md-5">
                            <div class="progress out-space">
                                <div class="progress-bar progress-bar-success" role="progressbar"
                                     aria-valuenow="100"
                                     aria-valuemin="0" aria-valuemax="100"
                                     v-bind:style="{ width:0+ '%' }">
                                    <strong>0%</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">
                                0</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">0</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">
                                {{ optionsSv['gruppeSupervision'] ? optionsSv['gruppeSupervision'] : 40 }}</p>
                        </div>
                        <div class="col-md-1 text-center">
                            
                        </div>
                    </div>
                </div>
            </section>
        </article>
<!--HERE-->
        <!--Section to check supervision Personligt START-->
        <article v-show="(checksOpt.indexOf('timerIndividueltCheck') + 1) || (checksOpt.indexOf('timerGruppeCheck') + 1) || (checksOpt.indexOf('timerKombinationIndividueltGruppeCheck') + 1) " class="content-block-profil content-block container-fluid">
            <section class="status">
                <div class="row headline-row">
                    <div class="col-md-5 block-value" v-show="checksOpt.indexOf('timerIndividueltCheck') + 1 || checksOpt.indexOf('timerIndividueltCheck') + 1 || checksOpt.indexOf('timerGruppeCheck') + 1">
                        <p class="value-text main-head">Personligt udviklingsarbejde</p>
                    </div>
                </div>
                <div v-if="supervision_options.length>0">
                    <div class="row headline-row" v-show="checksOpt.indexOf('timerIndividueltCheck') + 1">
                        <div class="col-md-5 block-value">
                            <p class="value-text main-head">timer individuelt</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">REGISTRERET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">OMREGNET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">KRAV</p>
                        </div>
                    </div>

                    <div class="row value-wrapper" v-show="checksOpt.indexOf('timerIndividueltCheck') + 1">
                        <div v-if="checkListType(supervision_options,'individuel')">
                            <div class="col-md-5">
                                <div class="progress out-space">
                                    <div class="progress-bar progress-bar-success" role="progressbar"
                                         aria-valuenow="100"
                                         aria-valuemin="0" aria-valuemax="100"
                                         v-bind:style="{ width: calculateStatusSupervision(personligtIndividueltOmregnet, optionsSv['timerIndividuelt'] ? optionsSv['timerIndividuelt'] : 40) + '%' }">
                                        <strong>{{calculateStatusSupervision(personligtIndividueltOmregnet, optionsSv['timerIndividuelt'] ? optionsSv['timerIndividuelt'] : 40)}}%</strong>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                    {{checkValueRegisteret(personligtIndividuelt,1000)}}</p>
                            </div>

                            <div class="col-md-2 block-value">
                                <p class="text-center headline">{{personligtIndividueltOmregnet}}</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">{{ optionsSv['timerIndividuelt'] ? optionsSv['timerIndividuelt'] : 40 }}</p>
                            </div>
                            <div class="col-md-1 text-center">
                                <!-- <img class="knap-pic" src="/image/info-knap.png" alt="info-knap"> -->
                            </div>
                        </div>
                        <div v-else>
                            <div class="col-md-5">
                                <div class="progress out-space">
                                    <div class="progress-bar progress-bar-success" role="progressbar"
                                         aria-valuenow="100"
                                         aria-valuemin="0" aria-valuemax="100"
                                         v-bind:style="{ width: 0 + '%' }">
                                        <strong>0%</strong>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                    0</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">0</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                    {{ optionsSv['timerIndividuelt'] ? optionsSv['timerIndividuelt'] : 80 }}
                                </p>
                            </div>
                            <div class="col-md-1 text-center">
                                
                            </div>
                        </div>
                    </div>


                    <div class="row headline-row"  v-show="checksOpt.indexOf('timerGruppeCheck') + 1">
                        <div class="col-md-5 block-value">
                            <p class="value-text main-head">timer gruppe</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">REGISTRERET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">OMREGNET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">KRAV</p>
                        </div>
                    </div>
                    <div class="row value-wrapper"  v-show="checksOpt.indexOf('timerGruppeCheck') + 1">
                        <div v-if="checkListType(supervision_options,'gruppe')">
                            <div class="col-md-5">
                                <div class="progress out-space">
                                    <div class="progress-bar progress-bar-success" role="progressbar"
                                         aria-valuenow="100"
                                         aria-valuemin="0" aria-valuemax="100"
                                         v-bind:style="{ width: calculateStatusSupervision(personligtGroupOmregnet,  optionsSv['timerGruppe'] ? optionsSv['timerGruppe'] : 96 ) + '%' }">
                                        <strong>{{calculateStatusSupervision(personligtGroupOmregnet,  optionsSv['timerGruppe'] ? optionsSv['timerGruppe'] : 96 )}}%</strong>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                    {{checkValueRegisteret(personligtGroup,1000)}}</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">{{personligtGroupOmregnet}}</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                    {{ optionsSv['timerGruppe'] ? optionsSv['timerGruppe'] : 96 }}
                                </p>
                            </div>
                            <div class="col-md-1 text-center">
                                <!-- <img class="knap-pic" src="/image/info-knap.png" alt="info-knap"
                                     @click="groupInfoMessage"> -->
                            </div>
                        </div>
                        <div v-else>
                            <div class="col-md-5">
                                <div class="progress out-space">
                                    <div class="progress-bar progress-bar-success" role="progressbar"
                                         aria-valuenow="100"
                                         aria-valuemin="0" aria-valuemax="100"
                                         v-bind:style="{ width: 0 + '%' }">
                                        <strong>0%</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                    0</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">0</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                     {{ optionsSv['timerGruppe'] ? optionsSv['timerGruppe'] : 96 }}
                                </p>
                            </div>
                            <div class="col-md-1 text-center">
                                
                            </div>
                        </div>
                    </div>


                    <div class="row headline-row" v-show="checksOpt.indexOf('timerKombinationIndividueltGruppeCheck') + 1">
                        <div class="col-md-5 block-value">
                            <p class="value-text main-head">timer kombination individuelt & gruppe</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">REGISTRERET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">OMREGNET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">KRAV</p>
                        </div>
                    </div>
                    <div class="row value-wrapper" v-show="checksOpt.indexOf('timerKombinationIndividueltGruppeCheck') + 1">
                        <!--HERE-->
                        <div v-if="(checkListType(supervision_options,'gruppe')||checkListType(supervision_options,'individuel'))">
                            <div class="col-md-5">
                                <div class="progress out-space">
                                    <div class="progress-bar progress-bar-success" role="progressbar"
                                         aria-valuenow="100"
                                         aria-valuemin="0" aria-valuemax="100"
                                         v-bind:style="{ width: calculateStatusSupervision(personligtTotalOmregnet(), optionsSv['timerKombinationIndividueltGruppe'] ? optionsSv['timerKombinationIndividueltGruppe'] : 80) + '%' }">
                                        <strong>{{calculateStatusSupervision(personligtTotalOmregnet(), optionsSv['timerKombinationIndividueltGruppe'] ? optionsSv['timerKombinationIndividueltGruppe'] : 80)}}%</strong>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                    {{checkValueRegisteret(personligtTotal(),1000)}}</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">{{personligtTotalOmregnet()}}</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline"> {{ optionsSv['timerKombinationIndividueltGruppe'] ? optionsSv['timerKombinationIndividueltGruppe'] : 80 }}</p>
                            </div>
                            <div class="col-md-1 text-center">
                                <!-- <img class="knap-pic" src="/image/info-knap.png" alt="info-knap"
                                     @click="groupInfoMessage"> -->
                            </div>
                        </div>
                        <div v-else>
                            <div class="col-md-5">
                                <div class="progress out-space">
                                    <div class="progress-bar progress-bar-success" role="progressbar"
                                         aria-valuenow="100"
                                         aria-valuemin="0" aria-valuemax="100"
                                         v-bind:style="{ width: 0 + '%' }">
                                        <strong>0%</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                    0</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">0</p>
                            </div>
                            <div class="col-md-2 block-value">
                                <p class="text-center headline">
                                    {{ optionsSv['timerGruppe'] ? optionsSv['timerGruppe'] : 80 }}
                                </p>
                            </div>
                            <div class="col-md-1 text-center">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <div class="row headline-row" v-show="checksOpt.indexOf('timerIndividueltCheck') + 1">
                        <div class="col-md-5 block-value">
                            <p class="value-text main-head">timer individuelt</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">REGISTRERET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">OMREGNET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">KRAV</p>
                        </div>
                    </div>
                    <div class="row value-wrapper" v-show="checksOpt.indexOf('timerIndividueltCheck') + 1">
                        <div class="col-md-5">
                            <div class="progress out-space">
                                <div class="progress-bar progress-bar-success" role="progressbar"
                                     aria-valuenow="100"
                                     aria-valuemin="0" aria-valuemax="100"
                                     v-bind:style="{ width:0+ '%' }">
                                    <strong>0%</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">
                                0</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">0</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">
                                {{ optionsSv['timerGruppe'] ? optionsSv['timerGruppe'] : 80 }}
                            </p>
                        </div>
                        <div class="col-md-1 text-center">
<!--                             
                            </a> -->
                        </div>
                    </div>

                    <div class="row headline-row" v-show="checksOpt.indexOf('timerGruppeCheck') + 1">
                        <div class="col-md-5 block-value">
                            <p class="value-text main-head">timer gruppe</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">REGISTRERET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">OMREGNET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">KRAV</p>
                        </div>
                    </div>
                    <div class="row value-wrapper" v-show="checksOpt.indexOf('timerGruppeCheck') + 1">
                        <div class="col-md-5">
                            <div class="progress out-space">
                                <div class="progress-bar progress-bar-success" role="progressbar"
                                     aria-valuenow="100"
                                     aria-valuemin="0" aria-valuemax="100"
                                     v-bind:style="{ width:0+ '%' }">
                                    <strong>0%</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">
                                0</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">0</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">
                                {{ optionsSv['timerGruppe'] ? optionsSv['timerGruppe'] : 80 }}
                            </p>
                        </div>
                        <div class="col-md-1 text-center">
                            
                        </div>
                    </div>

                    <div class="row headline-row" v-show="checksOpt.indexOf('timerKombinationIndividueltGruppeCheck') + 1">
                        <div class="col-md-5 block-value">
                            <p class="value-text main-head">timer kombination individuelt & gruppe</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">REGISTRERET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">OMREGNET</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center">KRAV</p>
                        </div>
                    </div>
                    <div class="row value-wrapper" v-show="checksOpt.indexOf('timerKombinationIndividueltGruppeCheck') + 1">
                        <div class="col-md-5">
                            <div class="progress out-space">
                                <div class="progress-bar progress-bar-success" role="progressbar"
                                     aria-valuenow="100"
                                     aria-valuemin="0" aria-valuemax="100"
                                     v-bind:style="{ width:0+ '%' }">
                                    <strong>0%</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">
                                0</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">0</p>
                        </div>
                        <div class="col-md-2 block-value">
                            <p class="text-center headline">
                                {{ optionsSv['timerKombinationIndividueltGruppe'] ? optionsSv['timerKombinationIndividueltGruppe'] : 80 }}
                            </p>
                        </div>
                        <div class="col-md-1 text-center">
                           
                        </div>
                    </div>
                </div>
            </section>
        </article>
        <br />
        <br />
        <br />
    </div>
</template>

<script>
    export default {
        data(){
            return {
                ps_text : "",
                supervision_options: [],
                totalAntalTimer: 0,
                totalAntalTimerOmregnet: 0,
                currentUser: {},
                userSpecialPreparation: "",
                user : {},
                interventionHours: 0,
                udredningHours: 0,
                individuelHours: 0,
                gruppeHours: 0,
                LængerevarendeHours: 0,
                LiveVideoHours: 0,
                eksternHours: 0,
                personligtIndividuelt: 0,
                personligtGroup: 0,

                gruppeOmregnet: 0,
                individuelOmregnet: 0,
                interventionOmregnet: 0,
                udredningOmregnet: 0,
                LængerevarendeOmregnet: 0,
                LiveVideoOmregnet: 0,
                eksternOmregnet: 0,
                personligtIndividueltOmregnet: 0,
                personligtGroupOmregnet: 0,


                intervationSupervisor: false,
                udredningSupervisor: false,

                optionsSv : {},
                checksOpt : []
            }
        },
        mounted() {
            let mainData = this;

            axios.get('/getSupervisionOptions')
                .then(function (response) {
                        mainData.optionsSv = response.data;
                    }).catch(function (error) {
                        console.log(error);
                    });

            axios.get('/getSupervisionOptionsChecks')
                .then(function (response) {
                        mainData.checksOpt = response.data;
                    }).catch(function (error) {
                        console.log(error);
                    });

            axios.get('/getSupervisionPsText')
                    .then(function (response) {
                        mainData.ps_text = response.data;
                    }).catch(function (error) {
                        console.log(error);
                    });

            axios.get('/getSupervisionPsText')
                    .then(function (response) {
                        mainData.ps_text = response.data;
                    }).catch(function (error) {
                        console.log(error);
                    });

            axios.get('/getSupervisionStatus')
                    .then(function (response) {
//                        response data statuses supervision in [0] key
                        mainData.supervision_options = response.data[0];
                        console.log(response.data);
//                        mainData.calculateTotalAntalTimer(mainData.supervision_options);
                        mainData.calculateTotalDataForTimer(mainData.supervision_options);
//                        response data info about current user in key [1]
                        mainData.currentUser = response.data[1];
                        mainData.userSpecialPreparation = mainData.currentUser.full_info_about_user.educations;

                    })
                    .catch(function (error) {
                        console.log(error);
                    });
             
                axios.get('/getUser')
                    .then(function (response) {
                        mainData.user = response.data;
                    });
        },
        methods: {

            personligtTotalOmregnet(){
                return parseFloat(((this.personligtGroupOmregnet * 0.83333) + (this.personligtIndividueltOmregnet)).toFixed(2));
            },
//            personligtTotal(){
//                return parseFloat(((this.personligtGroup * 0.83333) + (this.personligtIndividuelt)).toFixed(2));
//            },
    personligtTotal(){
        return parseFloat(((this.personligtGroupOmregnet) + (this.personligtIndividuelt)).toFixed(2));
    },
            infoMessage(){
                swal('Du skal have mindst 2 forskellige supervisor på denne kategori, hvoraf en skal være ekstern', '', 'error')
            },
            antalMessagePopUp(){
                swal('Gruppesupervision med over 12 personer tæller ikke timer', '', 'info')
            },
            groupInfoMessage(){
                swal('Gruppesupervision med over 12 personer tæller ikke timer.<br>' +
                        'Hvis mere end 25% ikke-psykologer i gruppen betyder, at supervisionen ikke tæller med', '', 'info')
            },

            calculateTotalDataForTimer(arraySupervisionOptions){
                let mainData = this;
//                calculating total hours for session type
                $.each(arraySupervisionOptions, function (i) {
//                  COUNTING normal hours
                    mainData.calculatingWithFullHours(arraySupervisionOptions[i]);
                    //                  COUNTING Omregnet hours
                    if (arraySupervisionOptions[i].percentPsychology != 'ja') {
                        if (arraySupervisionOptions[i].group_composition == '0-8' || arraySupervisionOptions[i].group_composition == '2-12'
                                || arraySupervisionOptions[i].type_classes == 'individuel') {
                            mainData.calculatingWithFullHoursOmregnet(arraySupervisionOptions[i]);
                        } else if (arraySupervisionOptions[i].group_composition == '9-12') {
//                        we counting half hours 0x5
                            mainData.calculatingWithHalfHoursOmregnet(arraySupervisionOptions[i]);
                        } else {
//                        we do not counting data if group have over 12 psychologist
                        }
                    }
                });
            },

//                        calculateTotalDataForTimer(arraySupervisionOptions){
//                let mainData = this;
////                calculating total hours for session type
//                $.each(arraySupervisionOptions, function (i) {
////                    if we have in group more not psychology users (over 25%) we don't count it
//                    if (arraySupervisionOptions[i].percentPsychology != 'ja') {
////                    we counting normal hours 1:1
//                        if (arraySupervisionOptions[i].group_composition == '0-8' || arraySupervisionOptions[i].type_classes == 'individuel') {
//                            mainData.calculatingWithFullHours(arraySupervisionOptions[i]);
//                        } else if (arraySupervisionOptions[i].group_composition == '9-12') {
////                        we counting half hours 0x5
//                            mainData.calculatingWithHalfHours(arraySupervisionOptions[i]);
//                        } else {
////                        we do not counting data if group have over 12 psychologist
//                        }
//                    }
//
//                });
//            },
            calculatingWithFullHoursOmregnet(object){
                let mainData = this;
                if (object.udredning_intervention == 'udredning') {
                    mainData.udredningOmregnet += (parseFloat(object.number_of_hours));
//                        check if supervision session has  role supervisor than we show green info-knap
                    if (object.role == 'supervisor') {
                        mainData.udredningSupervisor = true;
                    }
                }
                if (object.udredning_intervention == 'intervention') {
                    mainData.interventionOmregnet += (parseFloat(object.number_of_hours));
//                        check if supervision session has  role supervisor than we show green info-knap
                    if (object.role == 'supervisor') {
                        mainData.intervationSupervisor = true;
                    }
                }
                if (object.type_classes == 'individuel' && object.supervision_type != 'Personligt udviklingsarbejde/egenterapi') {
                    mainData.individuelOmregnet += (parseFloat(object.number_of_hours));
                }
                if (object.type_classes == 'gruppe' && object.supervision_type != 'Personligt udviklingsarbejde/egenterapi') {
                    if (object.group_composition == '9-12') {
                        mainData.gruppeOmregnet += (parseFloat(object.number_of_hours) / 2);
                    } else if (object.group_composition == '0-8') {
                        mainData.gruppeOmregnet += (parseFloat(object.number_of_hours));
                    } else {
                        //if group_composition == over 12 we no added hours
                    }
                }
                if (object.type_work == 'ekstern') {
                    mainData.eksternOmregnet += (parseFloat(object.number_of_hours));
                }
                if (object.long_course == 'ja') {
                    mainData.LængerevarendeOmregnet += (parseFloat(object.number_of_hours));
                }
                if (object.supervision_type == 'Personligt udviklingsarbejde/egenterapi') {
                    if (object.type_classes == 'individuel') {
                        mainData.personligtIndividueltOmregnet += (parseFloat(object.number_of_hours));
                    }
                    if (object.type_classes == 'gruppe') {
                        if (object.group_composition == '2-12') {
                            mainData.personligtGroupOmregnet += (parseFloat(object.number_of_hours));
                        }
                        else {
                            //if group_composition == over 13 we no added hours
                        }
                    }

                    mainData.eksternHours = 0;
                    mainData.eksternOmregnet = 0;

                    mainData.udredningHours = 0;
                    mainData.udredningOmregnet = 0;

                    mainData.interventionHours = 0;
                    mainData.interventionOmregnet = 0;

                    mainData.LængerevarendeHours = 0;
                    mainData.LængerevarendeOmregnet = 0;
                }

                if ((object.supervision_type == 'Live Video/Audio' && object.udredning_intervention != 'udredning')) {
                    mainData.LiveVideoOmregnet += (parseFloat(object.number_of_hours));
                }
                if (object.supervision_type != 'Personligt udviklingsarbejde/egenterapi') {
                    mainData.totalAntalTimerOmregnet += parseFloat(object.number_of_hours);
                }

            }
            ,


            calculatingWithHalfHoursOmregnet(object)
            {
                let mainData = this;
                if (object.udredning_intervention == 'udredning') {
                    mainData.udredningOmregnet += (parseFloat(object.number_of_hours) / 2);
//                        check if supervision session has  role supervisor than we show green info-knap
                    if (object.role == 'supervisor') {
                        mainData.udredningSupervisor = true;
                    }
                }
                if (object.udredning_intervention == 'intervention') {
                    mainData.interventionOmregnet += (parseFloat(object.number_of_hours) / 2);
//                        check if supervision session has  role supervisor than we show green info-knap
                    if (object.role == 'supervisor') {
                        mainData.intervationSupervisor = true;
                    }
                }
                if (object.type_classes == 'individuel') {
                    mainData.individuelOmregnet += (parseFloat(object.number_of_hours) / 2);
                }
                if (object.type_classes == 'gruppe') {
                    if (object.group_composition == '9-12') {
                        mainData.gruppeOmregnet += (parseFloat(object.number_of_hours) / 2);
                    } else if (object.group_composition == '0-8') {
                        mainData.gruppeOmregnet += (parseFloat(object.number_of_hours));
                    } else {
                        //if group_composition == over 12 we no added hours
                    }
                }
                if (object.long_course == 'ja') {
                    mainData.LængerevarendeOmregnet += (parseFloat(object.number_of_hours) / 2);
                }
                if (object.type_work == 'ekstern') {
                    mainData.eksternOmregnet += (parseFloat(object.number_of_hours) / 2);
                }
                if ((object.supervision_type == 'Live Video/Audio' && object.udredning_intervention != 'udredning')) {
                    mainData.LiveVideoOmregnet += (parseFloat(object.number_of_hours) / 2);
                }
                mainData.totalAntalTimerOmregnet += parseFloat(object.number_of_hours) / 2;


                if (object.supervision_type == 'Personligt udviklingsarbejde/egenterapi') {
                   
                    mainData.eksternHours = 0;
                    mainData.eksternOmregnet = 0;

                    mainData.udredningHours = 0;
                    mainData.udredningOmregnet = 0;

                    mainData.interventionHours = 0;
                    mainData.interventionOmregnet = 0;

                    mainData.LængerevarendeHours = 0;
                    mainData.LængerevarendeOmregnet = 0;
                }
            }
            ,
            calculatingWithFullHours(object)
            {
                let mainData = this;
                if (object.udredning_intervention == 'udredning') {
                    mainData.udredningHours += parseFloat(object.number_of_hours);
//                        check if supervision session has  role supervisor than we show green info-knap
                    if (object.role == 'supervisor') {
                        mainData.udredningSupervisor = true;
                    }
                }
                if (object.udredning_intervention == 'intervention') {
                    mainData.interventionHours += parseFloat(object.number_of_hours);
//                        check if supervision session has  role supervisor than we show green info-knap
                    if (object.role == 'supervisor') {
                        mainData.intervationSupervisor = true;
                    }  
                    
                }
                if (object.type_classes == 'individuel' && object.supervision_type != 'Personligt udviklingsarbejde/egenterapi') {
                    mainData.individuelHours += parseFloat(object.number_of_hours);
//                    mainData.individuelOmregnet += (parseFloat(object.number_of_hours));
                }
                if (object.type_classes == 'gruppe' && object.supervision_type != 'Personligt udviklingsarbejde/egenterapi') {
                    mainData.gruppeHours += parseFloat(object.number_of_hours);
                }

                if (object.supervision_type == 'Personligt udviklingsarbejde/egenterapi') {
                    if (object.type_classes == 'individuel') {
                        mainData.personligtIndividuelt += parseFloat(object.number_of_hours);
                    }
                    if (object.type_classes == 'gruppe') {
                        mainData.personligtGroup += parseFloat(object.number_of_hours);
                    }
                }


                if (object.type_work == 'ekstern') {
                    mainData.eksternHours += parseFloat(object.number_of_hours);
                }
                if (object.long_course == 'ja') {
                    mainData.LængerevarendeHours += parseFloat(object.number_of_hours);
                }
                if (object.supervision_type == 'Live Video/Audio') {
                    mainData.LiveVideoHours += parseFloat(object.number_of_hours);
                }
                if (object.supervision_type != 'Personligt udviklingsarbejde/egenterapi') {
//                    calculating total data (antal timer)
                    mainData.totalAntalTimer += parseFloat(object.number_of_hours);
                }

                if (object.supervision_type == 'Personligt udviklingsarbejde/egenterapi') {
                   
                    mainData.eksternHours = 0;
                    mainData.eksternOmregnet = 0;

                    mainData.udredningHours = 0;
                    mainData.udredningOmregnet = 0;

                    mainData.interventionHours = 0;
                    mainData.interventionOmregnet = 0;

                    mainData.LængerevarendeHours = 0;
                    mainData.LængerevarendeOmregnet = 0;
                }
            }
            ,


//            calculateTotalAntalTimer(arraySupervisionOptions){
//                let mainData = this;
//                $.each(arraySupervisionOptions, function (i) {
//                    mainData.totalAntalTimer += parseFloat(arraySupervisionOptions[i].number_of_hours);
//                });
//            },
            calculateStatusSupervision(currentValue, totalValue)
            {
                let result = Math.floor((currentValue * 100 / totalValue) * 100) / 100;
                return result >= 100 ? 100 : result;
            }
            ,
            checkValueRegisteret(currentValue, totalValue)
            {
                return currentValue >= totalValue ? totalValue : currentValue;
            }
            ,
            checkUdredningIntervention(typeSupervisor)
            {
                return typeSupervisor == 'intervention' ? 100 : 60;
            }
            ,
            checkListType(list, type)
            {
// check if list statuses supervisor contains  dynamic property for v-show block
                let mark = false;
                $.each(list, function (index, supervisor_list) {
                    $.each(supervisor_list, function (index, item) {
                        if (type == item) {
                            mark = true;
                        }
                    });
                });
                return mark;
            }
            ,
            checkListTypeAudio(list)
            {
                let mark = false;
                $.each(list, function (index, supervisor_list) {
                    $.each(supervisor_list, function (index, item) {
                        if (item.supervision_type == 'Live Video/Audio') {
                            mark = true;
                        }
                    });
                });
                return mark;
            }
            ,
            checkListTypeLongCourse(list)
            {
                let mark = false;
                $.each(list, function (index, item) {
                    if (item.long_course == 'ja') {
                        mark = true;
                    }
                });
                return mark;
            }
            ,

        }
    }
</script>
