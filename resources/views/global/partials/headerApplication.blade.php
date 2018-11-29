<div class="container-fluid header-info">
    <div class="row  main-logo-application">
        {{--if user has managing role(supervisor or course manager) we deny to redirect logo --}}
        @if(Auth::user()->roles->first()->name !='psychologist')
            <img src="/image/header-logo-specialist.png" alt="LOGO">
        @else
            <router-link to="/dashboard"><img src="/image/header-logo-specialist.png" alt="LOGO"></router-link>
        @endif
    </div>
    <div class="row log-ind-row">
        <div class="log-oud-application">
            <a href="{{ url('/logout') }}"> <span class="log-ind-text">LOG UD</span></a>
        </div>
    </div>
</div>


