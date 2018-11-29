@extends('admin.app')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="/admin/">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="javascript:;">Education & Module link</a>
    </li>
</ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-4">
            <h3 class="form-group">Education</h3>
            <ul class="list-group">
                @foreach($educations as $e)
                    <li class="list-group-item {{ (request()->input('current') && $e->id == request()->input('current') ? 'active' : ( ! request()->input('current') && $educations->first()->id == $e->id ? 'active' : '')) }}">
                        <a href="?current={{ $e->id }}" {{ (request()->input('current') && $e->id == request()->input('current') ? "style=color:#fff;" : ( ! request()->input('current') && $educations->first()->id == $e->id ? "style=color:#fff;" : '')) }}>
                            {{ $e->name }}  
                        </a>
                        <button class="btn btn-outline-warning pull-right education-comment" data-id="{{ $e->id }}" type="button" >
                            <i class="fa fa-comment"></i>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-4">
            <h3 class="form-group">Link</h3>

            <div id="groups" role="tablist">
                @foreach($educations[request()->input("current") ? : $educations->first()->id]->groups as $g)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <a data-toggle="collapse" href="#collapse-{{ $g->id }}" aria-expanded="true" aria-controls="collapseOne">
                                    {{ $g->name }}
                                </a>
                                <form style="display:inline-block;" action="/admin/delete_group_from_educations" method="post">
                                    <input type="hidden" value="{{ request()->input('current') ? : $educations->first()->id }}" data-field="education" />
                                    <input type="hidden" value="{{ $g->id }}" data-field="group" />
                                    <button type="submit" class="btn btn-danger" >
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                </form>
                            </h5>
                        </div>

                        <div id="collapse-{{ $g->id }}" class="collapse" data-parent="#groups" style="margin-left: 50px;">

                           <div id="sub" role="tablist">
                                @foreach($g->sub as $s)
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                <a data-toggle="collapse" href="#collapse-{{ $g->id }}-{{ $s->id }}" aria-expanded="true" aria-controls="collapseOne">
                                                    {{ $s->name }}
                                                </a>
                                            </h5>
                                        </div>
                                    </div>
                                    <div id="collapse-{{ $g->id }}-{{ $s->id }}" class="collapse" role="tabpanel"  data-parent="#sub">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        Name
                                                    </th>
                                                    <th>
                                                        Require
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($s->courses as $c)
                                                    <tr>
                                                        <td>
                                                            {{ $c->name }}
                                                        </td>
                                                        <td class="text-center">
                                                            <form action="/admin/add_require_course" method="post">
                                                                <input type="hidden" data-field="education" value="{{ request()->input('current') ? : $educations->first()->id }}" />
                                                                <input type="hidden" data-field="course" value="{{ $c->id }}" />
                                                                <input type="checkbox" data-check {{ in_array($c->id, $requires[request()->input("current") ? : $educations->first()->id]) ? 'checked' : '' }} />
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endforeach    
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        
            @if ( ! count($educations[request()->input("current") ? : $educations->first()->id]->groups))
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <strong>Warning!</strong> Better check yourself, you're not looking too good.
                </div>
            @endif

        </div>
        <div class="col-4">
            <h3 class="form-group">Module</h3>
            <ul class="list-group">
                @foreach($groups[request()->input("current") ? : $educations->first()->id]['groups'] as $g)
                    <li class="list-group-item">
                        <form style="display:inline-block" action="/admin/add_group_to_educations" method="post">
                            <input type="hidden" value="{{ request()->input('current') ? : $educations->first()->id }}" data-field="education" />
                            <input type="hidden" value="{{ $g->id }}" data-field="group" />
                            <button type="submit" class="btn btn-primary" >
                                <i class="fa fa-arrow-left"></i>
                            </button>
                        </form>
                        {{ $g->name }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="modal fade" id="editDescEducation">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="/admin/update_desc_education" method="post">
                    <input type="hidden" data-field="education_id" value="" />
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Edit description education</h4>
                    </div>
                    <div class="modal-body" style="min-height: 300px; display: block;">
                        <textarea data-field="desc" id="editor"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push("app-styles")
<link href="/libs/trumbowyg/ui/trumbowyg.min.css" rel="stylesheet" />
@endpush

@push("app-scripts")
<script src="/libs/trumbowyg/trumbowyg.min.js"></script>
<script>

    var education = {!! $educations->toJson() !!};
    $(document).ready(function() {
        $.trumbowyg.svgPath = '/trumbowyg/icons.svg';
        $(".education-comment").click(function() {
            var id = $(this).data("id");
            $("[data-field='education_id']").val(id);
            $("#editor").html(education[id] && education[id].desc || '');
            
            $('#editor').trumbowyg('html', education[id].desc);

            $("#editor").trumbowyg({
                lang: 'en',
                autogrow: true,
                btns : [
                    ['bold', 'italic'], ['link'],
                    ['viewHTML'],
                    ['formatting'],
                    ['removeformat']
                ]
            });

            $("#editDescEducation").modal("show");
        });

        $("#editDescEducation").on("hide.bs.modal", function(){
            $("#editor").trumbowyg('restoreRange');
        });
    });
</script>
@endpush