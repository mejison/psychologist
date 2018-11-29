<template>
    <div class="container-fluid">
        <div class="row headline-row">
            <div class="col-md-12 headline-block">
                <h3>Mine Supervisorer</h3>
                <hr class="supline">
            </div>
            <article class="content-block">
                <div class="scroll-box mine-box">
                    <div class="item-box" v-for="supervisor in supervisors">
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
                                <!--if we have supervisor with role supervisor-->
                              <div v-if="supervisor.version != null">
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
                              </div>
                                <!--if we have psychology -->
                                <div v-else>
                                    <li class="bold">{{supervisor.name}} {{supervisor.surname}}</li>
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
                                    <br>
                                    <div class="trash-mineSupervisor text-center pull-right">
                                        <div class="picture-wrapper">
                                            <img @click="deleteSupervisor(supervisor.user_id,'supervisor')"
                                                 class="trash" src="/image/vector-smart-trash.png"
                                                 alt="delete">
                                        </div>
                                    </div>
                                </div>
                                <!--if supervision has free account -->
                                <div v-else-if="supervisor.version =='free'">
                                    <router-link
                                            :to="{ name: 'supervision.profile.free', params: { idSupervision: supervisor.user_id }}"
                                            class="btn btn-primary-outline ">
                                        profil
                                    </router-link>
                                    <br>
                                    <div class="trash-mineSupervisor text-center pull-right">
                                        <div class="picture-wrapper">
                                            <img @click="deleteSupervisor(supervisor.user_id,'supervisor')"
                                                 class="trash" src="/image/vector-smart-trash.png"
                                                 alt="delete">
                                        </div>
                                    </div>
                                </div>
                                <!--if supervisor has role self Created supervision -->
                                <div v-else>
                                    <router-link
                                            :to="{ name: 'supervision.profile.psychology', params: { idSupervision: supervisor.user_id }}"
                                            class="btn btn-primary-outline ">
                                        profil
                                    </router-link>
                                    <br>
                                    <div class="trash-mineSupervisor text-center pull-right">
                                        <div class="picture-wrapper">
                                            <img @click="deleteSupervisor(supervisor.user_id,'psychology')"
                                                 class="trash" src="/image/vector-smart-trash.png"
                                                 alt="delete">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</template>

<script>
    import {SortingData} from "../../helpers/SortingData";
    export default {
//        Collect information to vue.data
        data()
        {
            return {
                supervisors: [],
                SortingData: {}
            }
        }
        ,
        //        when component created get info about user
        created: function () {
            this.SortingData = new SortingData();
            let mainData = this;
            axios.get('/getMineListSupervisors')
                    .then(function (response) {
                        mainData.supervisors = mainData.SortingData.sortMineSupervisionData(response.data.supervisors, 'created_at');
                    })
                    .catch(function (error) {
                    });
        },
        methods: {
            deleteSupervisor(idSupervisor, table){
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
                    let data = {
                        supervisorId: idSupervisor,
                        table: table
                    };
                    axios.delete('/deleteSupervisorFromMineList', {params: data})
                            .then(function (response) {
                                $.each(mainData.supervisors, function (i) {
                                    if (mainData.supervisors[i].user_id === idSupervisor) {
                                        mainData.supervisors.splice(i, 1);
                                        return false;
                                    }
                                });
                                swal('Godt arbejde!', 'Vejledere slettet!', 'success');
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
        }
    }


</script>
