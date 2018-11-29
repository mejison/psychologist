<template>
    <aside class="sidebarForManagers" v-bind:style="{ height: sidebarHeight + 'px' }">
    <div v-if="userVersion==null">
            <h1>Loading...</h1>
        </div>
        <div v-if="userVersion=='free'">
            <h1>VIl du have mere ud af siden? Go Pro</h1>
            <p>Opret en Pro-profil og nå ud til flere brugere. Få flere relevante henvendelser <b>+</b></p>
            <ul>
                <li>Se hvor mange der har besøgt din profil</li>
                <li>Se hvor mange har klikket på din hjemmeside?</li>
                <li>Opret videohilsen</li>
                <li> Profilbillede
                    med mere
                </li>
            </ul>
            <a href="javascript:;"
               class="btn btn-primary-outline" @click="updateUserProfileVersionToPro">
                skift profil
            </a>
        </div>
        <div v-if="userVersion=='pro'">
            <div class="user-pro text-center">
                <h1>{{visitors_count}}</h1>
                <p>Har besøgt profilen</p>
                <hr>
                <h2>{{website_link_count}}</h2>
                <p>Har klikket på hjemmesidelink</p>
            </div>
            <a href="javascript:;"
               class="btn btn-primary-outline" @click="updateUserProfileVersionToFree">
                tilbage til FREE?
            </a>
        </div>

    </aside>

</template>


<script>
    export default {


        data()
        {
            return {
                userId: null,
                userVersion: null,
                sidebarHeight:null,
                visitors_count:0,
                website_link_count:0,
                userRole:"",

            }
        },
        mounted() {
            let mainData = this;
            axios.get('/informationAboutUser')
                    .then(function (response) {
                        mainData.userId = response.data.id;
                        mainData.userVersion = response.data.full_info_about_user.version;
                        if (mainData.userVersion=='pro'){
                            mainData.sidebarHeight = 370;
                        }
                        mainData.visitors_count = response.data.full_info_about_user.visitors_count;
                        mainData.website_link_count = response.data.full_info_about_user.website_link_count;
                        mainData.userRole = response.data.roles.shift().name;

                    })
                    .catch(function (error) {});
        },
        methods: {
            updateUserProfileVersionToPro(){
                var mainData = this;
                swal({
                    title: 'Er du sikker?',
                    text: "Din profil vil blive ændret til PRO versionen!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ja tak!',
                    cancelButtonText: 'Nej annuller',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false
                }).then(function () {
                    axios.patch('/updateUserProfileVersionPro')
                            .then(function (response) { 
                                mainData.userVersion = 'pro'; 
                                mainData.sidebarHeight = 370;

                                if(mainData.userRole=="supervisor") {
                                    mainData.$router.push('/SupervisorProfilesideManagingPro/' + mainData.userId);
                                }

                                if(mainData.userRole=="courseOrganizer") {
                                    mainData.$router.push('/CourseOrganizerProfilesideManagingPro/' + mainData.userId);
                                }

                                swal('Godt arbejde', 'Godt arbejde” “Du har nu PRO versionen!', 'success');
                            })
                            .catch(function (error) {});

                });

            },
            updateUserProfileVersionToFree(){
                var mainData = this;
                swal({
                    title: 'Er du sikker?',
                    text: "Din profil vil blive ændret til FREE versionen - Men bare rolig, der går ikke data tabt, hvis du skulle fortryde og gerne vil vende tilbage igen.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ja tak',
                    cancelButtonText: 'Nej, annuller',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false
                }).then(function () {
                    axios.patch('/updateUserProfileVersionFree')
                            .then(function (response) {
                                mainData.userVersion = 'free';
                                mainData.sidebarHeight = 600;
                                 if(mainData.userRole=="supervisor"){
                                    mainData.$router.push('/SupervisorProfilesideManagingFree/' + mainData.userId);
                                }
                                 if(mainData.userRole=="courseOrganizer"){
                                    mainData.$router.push('/CourseOrganizerProfilesideManagingFree/' + mainData.userId);
                                }
                                swal('Godt arbejde', 'Du har nu FREE versionen!', 'success');
                            })
                            .catch(function (error) {
                                console.log(error);
                            });

                });
            }
        }
    }
</script>
