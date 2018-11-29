<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="/admin">Admin Panel</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav" id="users-list">
            
            <li class="nav-item {{ Request::path() == "psychologist" ? "active" : "" }}" data-toggle="tooltip" data-placement="right">
                <a class="nav-link "  href="/admin/users/psychologist">
                    <i class="fa fa-users"></i>
                    <span class="nav-link-text">Psychologists</span>
                </a>
            </li>
            
            <li class="nav-item {{ Request::path() == "supervisor" ? "active" : "" }}" >
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseCoursesNav"  href="/admin/users/supervisor">
                    <i class="fa fa-users"></i>
                    <span class="nav-link-text">Supervisors</span>
                </a>
                <ul class="sidenav-second-level collapse" id="collapseCoursesNav">
                    <li>
                        <a href="/admin/users/supervisor">Supervisors</a>
                    </li>
                    <li>
                        <a href="/admin/praksis/spv-educations">Education</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{ Request::path() == "courseOrganizer" ? "active" : "" }}" >
                <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseCourses"  href="/admin/users/courseOrganizer">
                    <i class="fa fa-users"></i>
                    <span class="nav-link-text">Courses</span>
                </a>
                
                <ul class="sidenav-second-level collapse" id="collapseCourses">
                    <li>
                        <a href="/admin/modules">Registered courses</a>
                    </li>
                    <li>
                        <a href="/admin/users/courseOrganizer">All courses</a>
                    </li>
                    <li>
                        <a href="/admin/course/educations">Education & Module link</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{ Request::path() == "admin" ? "active" : "" }}" >
                <a class="nav-link "  href="/admin/users/admin">
                    <i class="fa fa-users"></i>
                    <span class="nav-link-text">Admin</span>
                </a>               
            </li>

            <li class="nav-item {{ Request::path() == "praksis" ? "active" : "" }}" >
                <a class="nav-link "  href="/admin/praksis">
                    <i class="fa fa-edit"></i>
                    <span class="nav-link-text">Praksis</span>
                </a>               
            </li> 
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="javascript:;" id="signout">
                    <i class="fa fa-fw fa-sign-out"></i>Logout
                </a>
            </li>
        </ul>
    </div>
</nav>