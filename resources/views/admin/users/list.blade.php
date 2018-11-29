@extends('admin.app')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="/admin/">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">
        {{ $roles_by_name[request()->segment(3)]->display_name }}
    </li>
</ol>
@endsection

@section('content')
    <div class="form-group">
        <h3> {{ $roles_by_name[request()->segment(3)]->display_name}} ( {{ count($users) }} )</h3>
    </div>
    
    <table class="table table-bordered" id="usersList"  cellspacing="0">
        <thead>
            <tr>
                <th>№</th>
                @if (request()->segment(3) != 'courseOrganizer')
                    <th>First name</th>
                    <th>Last Name</th>
                @else
                    <th>Name</th>
                @endif
                <th>Day of registration</th>
                <th orderable="false"></th>
                <th orderable="false"></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>№</th>
                @if (request()->segment(3) != 'courseOrganizer')
                    <th>First name</th>
                    <th>Last Name</th>
                @else
                    <th>Name</th>
                @endif
                <th>Day of registration</th>
                <th orderable="false"></th>
                <th orderable="false"></th>
            </tr>
        </tfoot>
        <tbody>
            @foreach($users as $u)
                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>
                    @if (request()->segment(3) != 'courseOrganizer')
                        <td>
                            {{ $u->name }}
                        </td>
                        <td>
                            {{ $u->surname }}
                        </td>
                    @else
                        <td >
                            {{ $u->name }}
                        </td>
                    @endif

                    <td>
                        {{ $u->created_at }}
                    </td>
                    <td class="text-center">
                        <a class="btn btn-secondary" href="/admin/users/view/{{ $u->id }}">
                            <i class="fa fa-user"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-danger delete-user" type="button"  data-id="{{ $u->id }}">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            @if ( ! count($users))
                <tr>
                    <td colspan="6">
                        Records not found
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
@endsection

@push('app-scripts')
    <script>
        $(document).ready(function(){
            if ($('#usersList tbody td').length - 1) {
                $('#usersList').DataTable({
                    "columnDefs": [ 
                        {
                            "targets":  $('#usersList thead tr th').length - 1,
                            "orderable": false
                        },
                        {
                            "targets":  $('#usersList thead tr th').length - 2,
                            "orderable": false
                        }
                    ]
                });
            }

            $(".delete-user").click(function(){
                var id = $(this).data("id");
                $.ajax({
                    url : "/api/admin/delete-user",
                    method : "post",
                    data : {
                        id : id
                    },
                    success : function(response){
                        window.location.reload();
                    }
                })
            })
        });        
    </script>
@endpush