@extends('admin.app')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="/admin/">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="/admin/modules">Modules</a>
    </li>
    <li class="breadcrumb-item active">
        Sub modules
    </li>
</ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <h3>Module : {{ $group }}</h3>
            </div>
            <div class="form-group">
                <form action="/admin/add-sub_groups">
                    <input type="hidden" data-field="groups_id" type="text" value="{{ request()->id }}" />
                    <div class="row">
                        <div class="col-4">
                            <input class="form-control" data-field="name" placeholder="Name" type="text" />
                        </div>
                        <div class="col-2">
                            <input class="form-control" data-field="number" placeholder="Number" type="text" />
                        </div>
                        <div class="col-2">
                            <input class="form-control" data-field="hours" placeholder="Hours" type="text" />
                        </div>
                        <div class="col-2">
                            <button class="btn btn-primary btn-block">
                                <i class="fa fa-plus"></i>
                                Add
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <table class="table table-bordered" id="numbersItems">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Name</th>
                        <th>Hours</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sub_groups as $n)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="/admin/sub_modules/{{$n->id}}/courses">{{ $n->number }}  {{ $n->name }}</a>
                            </td>
                            <td>
                                {{ $n->hours }}
                            </td>
                            <td>
                                <button class="btn btn-primary" type="button" data-edit="sub_groups" data-id="{{ $n->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-danger" type="button" data-delete="sub_groups" data-id="{{ $n->id }}">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </td>
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
                <form action="/admin/update-sub_groups">
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
                    </div>
                    
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Number</label>
                            <input type="text" class="form-control" data-field="number" id="number" placeholder="Number" />
                        </div>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Hours</label>
                            <input type="text" class="form-control" data-field="hours" id="hours" placeholder="Hours" />
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
        var numbers = {!! ! empty($sub_groups) ? json_encode($sub_groups) : "{}" !!};
        $(document).ready(function(){
            $("[data-edit]").click(function(){
                var id = $(this).data("id");
                $("#modalEdit [data-field=id]").val(id);
                var current = {};
                for(var i in numbers)
                {
                    if (numbers[i].id == id)
                    {
                        current = numbers[i];
                    }
                }
                
                $("#modalEdit").find("[data-field]").each(function(index, value){
                    $(value).val(current[$(value).data("field")]);
                });

                $("#modalEdit").modal("show");
            });
        })
    </script>
@endpush