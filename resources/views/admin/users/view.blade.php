@extends('admin.app')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="/admin/">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="/admin/users/{{ $user->roles->first()->name }}">
            {{ $user->roles->first()->display_name }}
        </a>
    </li>
    <li class="breadcrumb-item active">
        View
    </li>
</ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-3">
            <div class="card" style="width: 20rem;">
                <img class="card-img-top" src="{{ $user->fullInfoAboutUser && $user->fullInfoAboutUser->avatar_path ? $user->fullInfoAboutUser->avatar_path : "//placehold.it/250" }}" alt="Card image cap">
            </div>
        </div>
        <div class="col-9">

            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href data-target="#main" >Main</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href data-target="#other">Other</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="main" >

                    <br />
                    @if ($user->roles->first()->name == "courseOrganizer")
                        <h4 class="card-title">
                        @if ( ! empty($user->getCourseInfo($user->id)->course_name))
                            {{ $user->getCourseInfo($user->id)->course_name }} #{{ $user->getCourseInfo($user->id)->course_number }}
                        @endif
                        ( {{ $user->roles->first()->display_name }} )
                        </h4>
                    @else
                        <h4 class="card-title">{{ $user->name }} {{ $user->surname }} ( {{ $user->roles->first()->display_name }} )</h4>
                    @endif
                    <p class="card-text">Day of registration: {{ $user->created_at }}</p>
                    <p class="card-text">Email: {{ $user->email }}</p>
                    
                </div>
                <div class="tab-pane fade" id="other" >

                </div>
            </div>

        </div>
    </div>
@endsection