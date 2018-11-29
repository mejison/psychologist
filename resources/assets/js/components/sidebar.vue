<template id="greeting-template">
    <div>
        <!-- Need remove this section and change laravel functions on Vue js methods and pass data into components-->
        <!--<section class="avatar text-center">-->
            <!--@php-->
            <!--$informationAboutUser =-->
            <!--\App\Models\ApplicationModels\User::with('fullInfoAboutUser','roles')->find(\Auth::user()->id);-->
            <!--@endphp-->
            <!--@if(isset($informationAboutUser->fullInfoAboutUser->avatar_path))-->
            <!--<img src="{{$informationAboutUser->fullInfoAboutUser->avatar_path}}" alt="avatar">-->
            <!--@else-->
            <!--<img src="/image/avatar-placeholder.png" alt="avatar">-->
            <!--@endif-->
        <!--</section>-->
        <!--<section class="user-info text-center">-->
            <!--<h3>{{Auth::user()->getFullName()}}</h3>-->
            <!--<p>SPECIALISTUDDANNELSE I <strong>-->
                <!--@if(isset($informationAboutUser->fullInfoAboutUser->special_preparation))-->
                <!--{{$informationAboutUser->fullInfoAboutUser->special_preparation}}-->
                <!--@else-->
                <!--Vælg specialistuddannelse-->
                <!--@endif-->
            <!--</strong></p>-->
        <!--</section>-->
        <section class="menu">
            <ul id="menu">
                <img class="triangle" src="/image/triangle.png" alt="triangle">
                <li>
                    <router-link to="#">SUPERVISION</router-link>
                    <ul id="supervisorUl">
                        <li>
                            <router-link to="/oversigtSupervision">OVERSIGT SUPERVISION</router-link>
                        </li>
                        <li>
                            <router-link to="/findSupervisor">FIND SUPERVISOR</router-link>
                        </li>
                        <li>
                            <router-link to="/registerSupervision">REGISTRER SUPERVISON</router-link>
                        </li>
                        <li>
                            <router-link to="/registreringer">SE/RET REGISTRERINGER</router-link>
                        </li>
                    </ul>
                </li>
                <li>
                    <router-link to="#">TEORIKURSER</router-link>
                    <ul>
                        <li>
                            <router-link to="/findKursus">FIND KURSUS</router-link>
                        </li>
                        <li><a href="#">REGISTRER KURSUS</a></li>
                        <li><a href="#">OVERSIGT KURSER</a></li>
                        <li><a href="#">SE/RET REGISTRERINGER</a></li>
                    </ul>
                </li>
                <li>
                    <router-link to="#">PRAKSIS</router-link>
                    <ul>
                        <li><a href="#">PRAKSIS INFO</a></li>
                        <li>
                            <router-link to="/mineSupervisorer">Mine Supervisorer</router-link>
                        </li>
                        <li>
                            <router-link to="/favoritliste">Favoritliste</router-link>
                        </li>
                        <li><a href="#"> &nbsp;</a></li>
                    </ul>
                </li>
                <li>
                    <router-link to="/profile">MIN PROFIL</router-link>
                </li>
                <li>
            <button >{{counter}}</button>
                </li>
            </ul>
        </section>
    </div>
</template>


<script>
    export default {

        data()
        {
            return {
            }
        },
        mounted() {
//            console.log(11111);
        }
    }
</script>
