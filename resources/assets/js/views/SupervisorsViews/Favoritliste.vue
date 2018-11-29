<template>
    <div class="container-fluid">
        <div class="row headline-row">
            <div class="col-md-12 headline-block">
                <h3>Supervisor Favoritliste</h3>
                <hr class="supline">
            </div>
            <article class="content-block">
                <div class="scroll-box">
                    <div class="item-box" v-for="supervisor in supervisors">
                        <div class="like-section">
                            <!--<a href="javascript:;">-->
                            <img class="download" src="/image/favorit.png" alt="favorit">
                            <!--</a>-->
                        </div>
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
                                <!--<li>{{supervisor.address_name}}</li>-->
                                <li>{{supervisor.city}}</li>
                                <li>Alder:{{supervisor.age}}</li>

                                <li>Specialistgrad:{{supervisor.primary_education}}</li>
                                <li v-show="supervisor.secondary_education!='none'">Specialistgrad:{{supervisor.secondary_education}}</li>
                                <li v-show="supervisor.third_education!='none'">Specialistgrad:{{supervisor.third_education}}</li>

                                <li v-if="supervisor.trained_leader==1">
                                    Supervisoruddannet: ja
                                </li>


                                <li v-if="supervisor.Eksistentiel_humanistisk">Teoretisk preference:Eksistentiel/humanistisk</li>
                                <li v-if="supervisor.Kognitiv_adfærdsterapeutisk">Teoretisk preference:Kognitiv/adfærdsterapeutisk</li>
                                <li v-if="supervisor.Psykodynamisk_psykoanalytisk">Teoretisk preference:Psykodynamisk/psykoanalytisk	</li>
                                <li v-if="supervisor.Systemisk_strukturel">Teoretisk preference:Systemisk/strukturel</li>
                            </ul>
                        </div>
                        <div class="button-section">

                            <!--if supervision has pro account -->
                            <div v-if="supervisor.version =='pro'">
                                <router-link
                                        :to="{ name: 'supervision.profile', params: { idSupervision: supervisor.user_id }}"
                                        class="btn btn-primary-outline ">
                                    profil
                                </router-link>
                                <button type="button" @click="deleteSupervision(supervisor.user_id)"
                                        class="btn btn-default tool-btn" data-toggle="tooltip"
                                        data-placement="top" title="fjern fra liste">
                                    <img class="trash" src="/image/vector-smart-trash.png" alt="delete">
                                </button>
                            </div>
                            <!--if supervision has free account -->
                            <div v-else-if="supervisor.version =='free'">
                                <router-link
                                        :to="{ name: 'supervision.profile.free', params: { idSupervision: supervisor.user_id }}"
                                        class="btn btn-primary-outline ">
                                    profil
                                </router-link>
                                <button type="button" @click="deleteSupervision(supervisor.user_id)"
                                        class="btn btn-default tool-btn" data-toggle="tooltip"
                                        data-placement="top" title="fjern fra liste">
                                    <img class="trash" src="/image/vector-smart-trash.png" alt="delete">
                                </button>
                            </div>
                            <!--if supervisor has role self Created supervision -->
                            <div v-else>
                                <router-link
                                        :to="{ name: 'supervision.profile.psychology', params: { idSupervision: supervisor.user_id }}"
                                        class="btn btn-primary-outline ">
                                    profil
                                </router-link>
                                <button type="button" @click="deleteSupervision(supervisor.user_id)"
                                        class="btn btn-default tool-btn" data-toggle="tooltip"
                                        data-placement="top" title="fjern fra liste">
                                    <img class="trash" src="/image/vector-smart-trash.png" alt="delete">
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</template>


<!-- bring a separate function -->
<script>
    import {SortingData} from "../../helpers/SortingData";

    export default {
        data()
        {
            return {
                supervisors: [],
                SortingData: {}

            }
        }
        ,
        mounted() {
            this.SortingData = new SortingData();
            //TODO need  fix when data upload from server tooltip do not work because data not render yet!!!!
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });
            let mainData = this;
            axios.get('/getFavoriteListSupervisors')
                    .then(function (response) {
//                        mainData.supervisors = response.data;
                        mainData.supervisors = mainData.SortingData.sortMineSupervisionData(response.data, 'created_at');

                    })
                    .then(function () {
                        $('[data-toggle="tooltip"]').tooltip();
                    });
        },
        methods: {
            deleteSupervision(id){
                let mainData = this;
//                console.log(this.supervisors);
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
                    let data = {'supervisionId': id};
                    axios.post('/deleteSupervisionFromFavoriteList', data)
                            .then(function (response) {
                                $.each(mainData.supervisors, function (i) {
                                    if (mainData.supervisors[i].user_id === id) {
                                        mainData.supervisors.splice(i, 1);
                                        return false;
                                    }
                                });
                                swal('Godt arbejde!', 'Vellykket fjernelse!', 'success');
                            });

                }, function (dismiss) {
                    if (dismiss === 'cancel') {
                        swal(
                                'Aflyst',
                                'Du og afvise fjernelse!',
                                'error'
                        )
                    }
                })
            }
        }
    }
</script>