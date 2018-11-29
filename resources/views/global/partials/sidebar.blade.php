<template id="greeting-template">
    <section class="avatar text-center">
        @php
            $educations = \App\Models\ApplicationModels\Educations::get()->keyBy("id");
            $informationAboutUser = \App\Models\ApplicationModels\User::with('fullInfoAboutUser','roles')->find(\Auth::user()->id);
        @endphp
        @if(isset($informationAboutUser->fullInfoAboutUser->avatar_path))
            <img src="{{$informationAboutUser->fullInfoAboutUser->avatar_path}}" alt="avatar">
        @else
            <img src="/image/avatar-placeholder.png" alt="avatar">
        @endif
    </section>
    <section class="user-info text-center">
        <h3>{{Auth::user()->getFullName()}}</h3>
        <p>SPECIALISTUDDANNELSE I <strong>
                @if(isset($informationAboutUser->fullInfoAboutUser->special_preparation))
                    {{ ! empty($educations[$informationAboutUser->fullInfoAboutUser->special_preparation]) ? $educations[$informationAboutUser->fullInfoAboutUser->special_preparation]->name : ""  }}
                @else
                    Vælg specialistuddannelse
                @endif
            </strong></p>
    </section>
    <section class="menu">
        <ul id="menu">
            <li>
                <router-link to="dashboard">OVERSIGT</router-link>
            </li>
            <img class="triangle" src="/image/triangle.png" alt="triangle">
            <li>
                <router-link data-type="sub" to="#">SUPERVISION</router-link>
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
                    <li>
                        <router-link to="/favoritliste">Favoritliste</router-link>
                    </li>
                    <li>
                        <router-link to="/mineSupervisorer">Mine Supervisorer</router-link>
                    </li>

                    {{--NEED COMPLETE CORRECT ROUTE--}}
                    @if(Auth::user()->hasRole('supervisor'))
                        @if(Auth::user()->fullInfoAboutUser->version !='pro')
                            <li>
                                <router-link
                                        :to="{ name: 'supervision.profile.managing.free', params: { idSupervision: '{{Auth::user()->id}}'}}">
                                    Supervisor panel
                                </router-link>
                            </li>
                        @else
                            <li>
                                <router-link
                                        :to="{ name: 'supervision.profile.managing.pro', params: { idSupervision: '{{Auth::user()->id}}'}}">
                                    Supervisor panel
                                </router-link>
                            </li>
                        @endif
                    @endif
                </ul>
            </li>
            <li>
                <router-link data-type="sub" to="#">TEORIKURSER</router-link>
                <ul>
                    <li>
                        <router-link to="/oversignKursus">
                            OVERSIGT KURSER
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/findKursus">FIND/REGISTRER KURSUS</router-link>
                    </li>
                    <li>
                        <router-link to="/registreringerKursus">
                            SE/RET REGISTRERINGER
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/favoritlisteKursus">Favoritliste</router-link>
                    </li>
                </ul>
            </li>
            <li>
                <router-link to="/parksisInfo">PRAKSIS</router-link>               
            </li>
            <li>
                <router-link to="/profile">MIN PROFIL</router-link>
            </li>

        </ul>
    </section>
</template>

