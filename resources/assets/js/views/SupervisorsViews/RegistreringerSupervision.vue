<template>
    <article class="content-block-profil content-block container-fluid">
        <div class="row">
            <h3>Supervision alle registreringer</h3>
            <hr>
        </div>

        <div class="row border-row">
            <div class="col-md-3 block-value">
                <p><strong @click="sortBy('registration_date')">
                    <a href="javascript:;"> Dato</a>
                </strong></p>
            </div>
            <div class="col-md-3 block-value">
                <p><strong @click="sortByName()"><a href="javascript:;">Supervisor</a></strong></p>
            </div>
            <div class="col-md-1 block-value">
                <p><strong @click="sortBy('number_of_hours',true)"><a href="javascript:;">timer</a></strong></p>
            </div>
            <div class="col-md-2 block-value">
                <p><strong @click="sortBy('supervision_type')"><a href="javascript:;">Supervisionstype</a></strong></p>
            </div>
            <div class="col-md-1 block-value">
                <p class="text-center">ret/detaljer</p>
            </div>
            <div class="col-md-2 block-value">
                <p class="text-center">Slet registrering</p>
            </div>
        </div>

        <div class="row info-wrapper" v-for="option in supervision_options">
            <div class="col-md-3 list-wrapper">
                <p>{{option.registration_date}}</p>
            </div>
            <div v-if="option.supervision!=null">
                <div class="col-md-3 list-wrapper">
                    <p>{{option.supervision.name}} {{option.supervision.surname}}</p>
                </div>
            </div>
            <div v-else>
                <div class="col-md-3 list-wrapper">
                    <p>{{option.user.name}} {{option.user.surname}}</p>
                </div>
            </div>
            <div class="col-md-1 list-wrapper">
                <p>{{option.number_of_hours}}</p>
            </div>
            <div class="col-md-2 list-wrapper">
                <p>{{option.supervision_type}}</p>
            </div>
            <div class="col-md-1 text-center">
                <div class="picture-wrapper">
                    <router-link
                            :to="{ name: 'supervision.update', params: { idSupervision: option.id ,role:option.role}}">
                        <img class="edit-pic" src="/image/edit-ico.png" alt="edit">
                    </router-link>
                </div>

            </div>
            <div class="col-md-2 text-center">
                <div class="picture-wrapper">
                    <img @click="deleteRegistrering(option.id)" class="trash" src="/image/vector-smart-trash.png"
                         alt="delete">
                </div>

            </div>
        </div>
    </article>
</template>

<script>
    import {SortingData} from "../../helpers/SortingData";
    export default {
        data()
    {
        return {
            supervision_options: [],
            sortAsc: true,
            SortingData: {},
        }
    }
    ,
    mounted()
    {
        this.SortingData = new SortingData();
        let mainData = this;
        axios.get('/getSupervisionsSession')
                .then(function (response) {
                    mainData.supervision_options = response.data;
                    console.log(mainData.supervision_options);
                })
                .catch(function (error) {
                    console.log(error);
                });

    }
    ,
    methods: {
        sortByName()
        {
            this.supervision_options = this.SortingData.sortSupervisionByNameRegistering(this.supervision_options);
        }
    ,
        sortBy(sortKey, sortNumbers)
        {
            this.supervision_options = this.SortingData.sortSupervisionData(this.supervision_options, sortKey, sortNumbers);
        }
    ,
        deleteRegistrering(id)
        {
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
                axios.post('/deleteRegisterSupervisionsList', data)
                        .then(function (response) {
                            $.each(mainData.supervision_options, function (i) {
                                if (mainData.supervision_options[i].id === id) {
                                    mainData.supervision_options.splice(i, 1);
                                    return false;
                                }
                            });
                            swal('Godt arbejde!', 'Vellykket fjernelse!', 'success');
                        });

            }, function (dismiss) {
                if (dismiss === 'cancel') {
                    swal(
                            'Aflyst',
                            'Fjernelse annulleret!',
                            'error'
                    )
                }
            })
        }

    }
    }
</script>
