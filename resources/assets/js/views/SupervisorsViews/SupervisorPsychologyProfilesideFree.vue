<template>
    <article class="content-block-profil content-block container-fluid">
        <div class="row border-row">
            <div class="col-md-6">
                <h3>SUPERVISOR PROFILSIDE</h3>
            </div>
            <div class="col-md-6">
                <div class="btn-wrapper pull-right">
                    <p>selvoprettet supervisor</p>
                    <!--<div class="supervisor-free-wrapper">-->
                    <!--<p>Supervisor</p>-->
                    <!--</div>-->
                    <!--<div class="free-wrapper">-->
                    <!--<p>Free</p>-->
                    <!--</div>-->
                </div>
            </div>
        </div>
        <div class="row bio-row">
            <div class="col-md-6">
                <div class="bio-info-free">
                    <h5>{{supervisorName}} {{supervisorSurname}}</h5>
                    <p><b>Uddannelse i:</b></p>
                    <p>{{special_preparation}}</p>

                    <p v-show="special_trained==1"><b>Supervisoruddannet :</b>
                        <span>ja</span>
                    </p>
                </div>
                <div v-show="showEditForm">
                    <div class="picture-wrapper bio-edit text-center">
                        <a href="javascript:;" @click="editName()">
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
                        <li>{{address}}</li>
                        <li>{{post}}</li>
                        <li>{{city}}</li>
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
                <p><strong>Fritekst / præsentation:</strong><pre class="pre-style"> {{presentation_description}}</pre></p>
                <div v-show="showEditForm">
                    <div class="picture-wrapper edit-ico text-center">
                        <a href="javascript:;" @click="editPresentationDescription()">
                            <img class="edit-pic" src="/image/edit-ico.png" alt="edit">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <!--<div class="inform-wrapper">-->
                <!--<p><strong>Tilbyder former for supervision:</strong> {{form_type}}</p>-->
                <!--</div>-->
                <!--<div class="picture-wrapper edit-ico text-center">-->
                <!--<a href="javascript:;" @click="editFormType()">-->
                <!--<img class="edit-pic" src="/image/edit-ico.png" alt="edit">-->
                <!--</a>-->
                <!--</div>-->
            </div>
        </div>
        <!--<div class="specialist-wrapper">-->
        <!--<div class="row list-wrapper">-->
        <!--<div class="col-md-2 headline-block">-->
        <!--<p>specialistbevis:</p>-->
        <!--</div>-->
        <!--<div class="col-md-2 text-center">-->
        <!--<img src="/image/list-ico.png" alt="avatar">-->
        <!--<p>Specialist i Psykoterapi</p>-->
        <!--</div>-->
        <!--<div class="col-md-2 text-center">-->
        <!--<img src="/image/list-ico.png" alt="avatar">-->
        <!--<p>Specialist i Neuropsykologi</p>-->
        <!--</div>-->
        <!--<div class="picture-wrapper edit-ico text-center">-->
        <!--<a href="javascript:;">-->
        <!--<img class="edit-pic" src="/image/edit-ico.png" alt="edit">-->
        <!--</a>-->
        <!--</div>-->
        <!--</div>-->
        <!--</div>-->
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
                supervisionId: null,
                supervisorName: "",
                supervisorSurname: "",
                special_preparation: "",
                special_trained: null,
                address: "",
                post: "",
                email: "",
                city: "",
                phone: "",
                presentation_description: "",
                form_type: "",
                showEditForm: false,
            }
        }
        ,
        //        when component created get info about user
        created: function () {
            let supervisionsId = (this.$route.params.idSupervision);
            let data = {
                supervisionsId: supervisionsId
            };
            let mainData = this;
            axios.post('/getSupervisionPsychologyInformation', data)
                    .then(function (response) {
                        mainData.supervisionId = response.data.id;
                        mainData.supervisorName = response.data.name;
                        mainData.supervisorSurname = response.data.surname;
                        mainData.special_preparation = response.data.special_preparation;
                        mainData.address = response.data.address;
                        mainData.special_trained = response.data.special_trained;
                        mainData.email = response.data.email;
                        mainData.city = response.data.city;
                        mainData.phone = response.data.phone;
                        mainData.post = response.data.post;
                        mainData.presentation_description = response.data.presentation_description;
                        mainData.form_type = response.data.form_type;
                        console.log(response.data);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
        }
        ,
        methods: {
            showEditPencils(){
                this.showEditForm = !this.showEditForm;
            },
            editName(){
                var mainData = this;
                swal({
                    title: 'Skift navn',
                    showCancelButton: true,
                    html: '<label class="pull-left" for="supervisorName">Navn</label><Br>' +
                    '<input id="supervisorName" class="swal2-input" autofocus placeholder="Navn" value="' + this.supervisorName + '">' +
                    '<label class="pull-left" for="supervisorSurname">Efternavn</label><Br>' +
                    '<input id="supervisorSurname" class="swal2-input" placeholder="Efternavn" value="' + this.supervisorSurname + '"><br>'+
                    '<label class="pull-left" for="primary_education">Specialistuddannelse</label><Br><Br>' +

                    '<select class="form-control" id="primary_education">' +
//                    '<option value="none" selected="selected">ingen</option>' +
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

                    '<label class="pull-left" for="trained_leader">Supervisoruddannet</label><Br>' +
                    '<div class="managingTrainedLeader">' +
                    '<label class="radio-inline"><input id="trained_leader_ja" type="radio"  value="1" name="optradio">ja</label>' +
                    '<label class="radio-inline"><input id="trained_leader_nej" type="radio"  value="0" name="optradio">nej</label>' +
                    '</div><br>' ,
                    onOpen: function () {
                        if (mainData.special_trained == 1) {
                            document.getElementById('trained_leader_ja').checked = true;
                        } else {
                            document.getElementById('trained_leader_nej').checked = true;
                        }

                        document.querySelector('#primary_education [value="' + mainData.special_preparation + '"]').selected = true;

                    },


                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            if (true) {
                                var primary_education_list = document.getElementById("primary_education");
                                var special_preparation = primary_education_list.options[primary_education_list.selectedIndex].value;

                                if (document.getElementById('supervisorName').value != '' && document.getElementById('supervisorSurname').value != '') {
                                    resolve([
                                        document.getElementById('supervisorName').value,
                                        document.getElementById('supervisorSurname').value,
                                        document.querySelector('input[name="optradio"]:checked').value,
                                        special_preparation
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
                    var special_trained = result[2];
                    var special_preparation = result[3];

                    let data = {
                        supervisionId: mainData.supervisionId,
                        name: name,
                        surname: surname,
                        special_trained: special_trained,
                        special_preparation: special_preparation,

                    };
                    axios.post('/updateSupervisionPsychologyName', data)
                            .then(function (response) {
                                mainData.supervisorName = name;
                                mainData.supervisorSurname = surname;
                                mainData.special_trained = special_trained;
                                mainData.special_preparation = special_preparation;
                                
                                swal('Godt arbejde', 'Data, ændret!', 'success')
                               
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                });
            },
            editAddress(){
                var mainData = this;
                swal({
                    title: 'Skift address',
                    showCancelButton: true,
                    html:
                    '<label class="pull-left" for="supervisorAddress">Address</label><Br>' +
                    '<input id="supervisorAddress" class="swal2-input" autofocus placeholder="Address" value="' + this.address + '">'+
                    '<label class="pull-left" for="supervisorPostnummer">Postnummer</label><Br>' +
                    '<input id="supervisorPostnummer" class="swal2-input"  placeholder="Postnummer" value="' + this.post + '">'+
                    '<label class="pull-left" for="supervisorBy">By</label><Br>' +
                    '<input id="supervisorBy" class="swal2-input"  placeholder="By" value="' + this.city + '">',
                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            if (true) {
                                if (document.getElementById('supervisorAddress').value != ''
                                        && document.getElementById('supervisorPostnummer').value != ''
                                        && document.getElementById('supervisorBy').value != ''

                                ) {
                                    resolve([
                                              document.getElementById('supervisorAddress').value,
                                              document.getElementById('supervisorPostnummer').value,
                                              document.getElementById('supervisorBy').value
                                            ]);
                                }
                                else {
                                    swal('Fejl', 'Felt kan ikke være tom!', 'error');
                                }
                            }
                        });
                    }
                }).then(function (result) {
                    var address = result[0];
                    var post = result[1];
                    var city = result[2];
                    let data = {
                        supervisionId: mainData.supervisionId,
                        address: address,
                        post: post,
                        city: city
                    };
                    axios.post('/updateSupervisionPsychologyAddress', data)
                            .then(function (response) {
                                mainData.address = address;
                                mainData.post = post;
                                mainData.city = city;
                                
                                swal('Godt arbejde', 'Data, ændret!', 'success')
                                    
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
                    axios.post('/updateSupervisionPsychologyEmailPhone', data)
                            .then(function (response) {
                                mainData.email = email;
                                mainData.phone = phone;
                                swal('Godt arbejde', 'Data, ændret!', 'success')
                                    
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                });
            },
            editPresentationDescription(){
                var mainData = this;
                swal({
                    title: 'Skift præsentation',
                    showCancelButton: true,
                    html: '<label class="pull-left" for="supervisorPresentation">Præsentation</label><Br>' +
                    '<textarea id="supervisorPresentation" style="height:100px" class="swal2-input" autofocus placeholder="Præsentation" >' + this.presentation_description + '</textarea>',
                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            if (true) {
                                if (document.getElementById('supervisorPresentation').value != '') {
                                    resolve(
                                            document.getElementById('supervisorPresentation').value
                                    );
                                }
                                else {
                                    swal('Fejl', 'Felt kan ikke være tom!', 'error');
                                }
                            }
                        });
                    }
                }).then(function (result) {
                    var presentationDescription = result;
                    let data = {
                        supervisionId: mainData.supervisionId,
                        presentationDescription: presentationDescription
                    };
                    axios.post('/updateSupervisionPsychologyPresentationDescription', data)
                            .then(function (response) {
                                mainData.presentation_description = presentationDescription;
                                swal('Godt arbejde', 'Data, ændret!', 'success');
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                });
            },
            editFormType(){
                var mainData = this;
                swal({
                    title: 'Skift tilbyder',
                    showCancelButton: true,
                    html: '<label class="pull-left" for="supervisorTilbyder">Tilbyder former for supervision</label><Br>' +
                    '<input id="supervisorTilbyder" class="swal2-input" autofocus placeholder="Tilbyder" value="' + this.form_type + '">',
                    preConfirm: function () {
                        return new Promise(function (resolve) {
                            if (true) {
                                if (document.getElementById('supervisorTilbyder').value != '') {
                                    resolve(
                                            document.getElementById('supervisorTilbyder').value
                                    );
                                }
                                else {
                                    swal('Fejl', 'Felt kan ikke være tom!', 'error');
                                }
                            }
                        });
                    }
                }).then(function (result) {
                    var form_type = result;
                    let data = {
                        supervisionId: mainData.supervisionId,
                        form_type: form_type
                    };
                    axios.post('/updateSupervisionPsychologyFormType', data)
                            .then(function (response) {
                                mainData.form_type = form_type;
                                swal('Godt arbejde', 'Data, ændret!', 'success');
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                });
            },
        }
    }


</script>