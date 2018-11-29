@extends('admin.app')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="/admin/">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">
        Modules
    </li>
</ol>
@endsection

@section('content')
    <div class="row ">
        <div class="col-12">
            <div class="form-group">
                <form action="/admin/add-groups">
                    <div class="row">
                        <div class="col-3">
                            <input class="form-control" data-field="name" placeholder="Name module" type="text" />
                        </div>
                        <div class="col-2">
                            <input class="form-control" data-field="hours" placeholder="Hours module" type="text" />
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fa fa-plus"></i>
                                Add
                            </button>
                        </div>
                    </div>
                </form>                
            </div>
            
            <table class="table table-bordered" id="groupsList">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Name</th>
                        <th>Hours</th>
                        <th>Show sub</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($groups as $g)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ url('admin/modules/sub_modules/' . $g->id) }}">{{ $g->name }}</a>
                            </td>
                            <td>
                                {{ $g->hours }}
                            </td>
                            <!-- <td class="text-center">
                                <input type="checkbox" {{ $g->dashboard ? "checked" : "" }} data-id="{{ $g->id }}" data-dashbaord  />
                            </td> -->
                            <td class="text-center">
                                <input type="checkbox" {{ $g->show_sub ? "checked" : "" }} data-id="{{ $g->id }}" data-show_sub  />
                            </td>
                            <td>
                                <button class="btn btn-primary" type="button" data-edit="gruops" data-id="{{ $g->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </td>
                            <th class="text-center">
                                <button class="btn btn-danger groups-item" type="button" data-delete="groups"  data-id="{{ $g->id }}">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </th>
                        </tr>
                    @endforeach
                </bbody>
                <tfoot>
                    <tr>
                        <th>№</th>
                        <th>Name</th>
                        <th>Hours</th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
       
    </div>
    
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="/admin/update-groups">
                    <input type="hidden" data-field="id" />
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" data-field="name" id="name" placeholder="Name" />
                        </div>
                        <div class="form-group">
                            <label for="number">Hours</label>
                            <input type="text" class="form-control" data-field="hours" id="number" placeholder="Hours" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" >Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('app-scripts')
    <script>
        var groups = {!! ! empty($groups) ? json_encode($groups) : "{}" !!};
        $(document).ready(function(){
            $("[data-edit]").click(function(){
                var id = $(this).data("id");
                $("#modalEdit [data-field=id]").val(id);
                var current = {};
                for(var i in groups)
                {
                    if (groups[i].id == id)
                    {
                        current = groups[i];
                    }
                }
                
                $("#modalEdit").find("[data-field]").each(function(index, value){
                    $(value).val(current[$(value).data("field")]);
                });

                $("#modalEdit").modal("show");
            });

            $("[data-dashbaord]").click(function(){
                var check = $(this).prop("checked");
                    id = $(this).data("id");
                $.ajax({
                    method : "post",
                    url : "{{ url('/api/admin/updateStatusGroup') }}",
                    data : {
                        id : id,
                        check : check ? 1 : 0
                    }
                })
            });

            $("[data-show_sub]").click(function(){
                var check = $(this).prop("checked");
                    id = $(this).data("id");
                $.ajax({
                    method : "post",
                    url : "{{ url('/api/admin/updateShowSubModules') }}",
                    data : {
                        id : id,
                        check : check ? 1 : 0
                    }
                })
            })
        })
    </script>
@endpush