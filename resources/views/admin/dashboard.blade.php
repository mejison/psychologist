@extends('admin.app')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="/admin/">Dashboard</a>
    </li>
</ol>
@endsection

@section('content')
     <div class="row">
        
        @foreach($counts as $i => $c)
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-{{ $colors[$loop->index] }} o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-user"></i>
                        </div>
                        <div class="mr-5">{{ count($c) }} {{ $groups[$i]->display_name }}</div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="/admin/users/{{ $groups[$i]->name }}">
                        <span class="float-left">View Details</span>
                        <span class="float-right">
                            <i class="fa fa-angle-right"></i>
                        </span>
                    </a>
                </div>
            </div>
        @endforeach

      </div>
@endsection