@extends('admin.app')

@push("app-styles")
<link href="/libs/trumbowyg/ui/trumbowyg.min.css" rel="stylesheet" />
@endpush

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="/admin/">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">
        Praksis
    </li>
</ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <h3>Education</h3>
            </div>
        </div>
        <div class="col-md-12">
        
            <ul class="list-group">
                @foreach($educations as $e)
                    <li class="list-group-item">
                        <a href="javascript:void(0);">
                            {{ $e->name }}  
                        </a>
                        <button class="btn btn-outline-warning pull-right education-comment" data-id="{{ $e->id }}" type="button" >
                            <i class="fa fa-comment"></i>
                        </button>
                    </li>
                @endforeach
            </ul>

        </div>
    </div>

    <div class="modal fade" id="editDescEducation">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="/admin/update_praksis_education" method="post">
                    <input type="hidden" data-field="education_id" value="" />
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Edit praksis</h4>
                    </div>
                    <div class="modal-body" style="min-height: 300px; display: block;">
                        <textarea data-field="praksis" id="editor"></textarea>
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

@push("app-scripts")
<script src="/libs/trumbowyg/trumbowyg.min.js"></script>
<script>
    var education = {!! $educations->toJson() !!};
    $.trumbowyg.svgPath = '/trumbowyg/icons.svg';
    $(document).ready(function() {
        $(".education-comment").click(function() {
            var id = $(this).data("id");
            $("[data-field='education_id']").val(id);
            $("#editor").html(education[id] && education[id].praksis || '');
            
            $('#editor').trumbowyg('html', education[id].praksis);

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