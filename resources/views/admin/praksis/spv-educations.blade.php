@extends('admin.app')

@push("app-styles")
<link href="/libs/trumbowyg/ui/trumbowyg.min.css" rel="stylesheet" />
@endpush

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="/admin/">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="/admin/users/supervisor">Supervisors</a>
    </li>
    <li class="breadcrumb-item active">
        Education
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
                        <button class="btn btn-outline-primary mb-3 mb-md-0 ml-md-3 pull-right sp-option-edit" data-id="{{ $e->id }}" type="button">
                            <i class="fa fa-cogs"></i>
                        </button>
                        <button class="btn btn-outline-warning mb-3 mb-md-0 ml-md-3 pull-right education-comment" data-id="{{ $e->id }}" type="button" >
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
                <form action="/admin/spv-educations-update" method="post">
                    <input type="hidden" data-field="education_id" value="" />
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Edit education</h4>
                    </div>
                    <div class="modal-body" style="min-height: 300px; display: block;">
                        <textarea data-field="spv_education" id="editor"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editOptionSv">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="/admin/sv-option-update" method="post">
                    <input type="hidden" data-field="education_id" value="" />
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Edit Option Supervision</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="antalSupervisionstimer">Antal supervisionstimer</label>
                            <input type="checkbox" name="antalSupervisionstimerCheck" data-field="antalSupervisionstimerCheck" />
                            <input id="antalSupervisionstimer" data-field="antalSupervisionstimer" class="form-control form-control-sm" type="text" placeholder="Antal supervisionstimer" />
                        </div>
                        <div class="form-group">
                            <label for="supervisionstimerIntervention">Supervisionstimer Intervention</label>
                            <input type="checkbox" name="supervisionstimerInterventionCheck" data-field="supervisionstimerInterventionCheck" />
                            <input id="supervisionstimerIntervention" data-field="supervisionstimerIntervention" class="form-control form-control-sm" type="text" placeholder="Supervisionstimer Intervention" />
                        </div>
                        <div class="form-group">
                            <label for="longtermEducation">Længerevarende uddannelsesforløb</label>
                            <input type="checkbox" name="longtermEducationCheck" data-field="longtermEducationCheck" />
                            <input id="longtermEducation" class="form-control form-control-sm" data-field="longtermEducation" type="text" placeholder="Længerevarende uddannelsesforløb" />
                        </div>
                        <div class="form-group">
                            <label for="liveVideoAudio">Live Video/Audio</label>
                            <input type="checkbox" name="liveVideoAudioCheck" data-field="liveVideoAudioCheck" />
                            <input id="liveVideoAudio" data-field="liveVideoAudio" class="form-control form-control-sm" type="text" placeholder="Live Video/Audio" />
                        </div>
                        <div class="form-group">
                            <label for="eksternSupervision">Ekstern supervision</label>
                            <input type="checkbox" name="eksternSupervisionCheck" data-field="eksternSupervisionCheck" />
                            <input id="eksternSupervision"  data-field="eksternSupervision" class="form-control form-control-sm" type="text" placeholder="Ekstern supervision" />
                        </div>
                        <div class="form-group">
                            <label for="supervisionstimerUdredning">Supervisionstimer udredning</label>
                            <input type="checkbox" name="supervisionstimerUdredningCheck" data-field="supervisionstimerUdredningCheck" />
                            <input id="supervisionstimerUdredning" data-field="supervisionstimerUdredning"  class="form-control form-control-sm" type="text" placeholder="Supervisionstimer udredning" />
                        </div>
                        <div class="form-group">
                            <label for="individuelSupervision">Individuel supervision</label>
                            <input type="checkbox" name="individuelSupervisionCheck" data-field="individuelSupervisionCheck" />
                            <input id="individuelSupervision" data-field="individuelSupervision" class="form-control form-control-sm" type="text" placeholder="Individuel supervision" />
                        </div>
                        <div class="form-group">
                            <label for="gruppeSupervision">Gruppe supervision</label>
                            <input type="checkbox" name="gruppeSupervisionCheck" data-field="gruppeSupervisionCheck" />
                            <input id="gruppeSupervision" data-field="gruppeSupervision" class="form-control form-control-sm" type="text" placeholder="Gruppe supervision" />
                        </div>

                        <div class="form-group">
                            <label for="timerIndividuelt">Timer individuelt</label>
                            <input type="checkbox" name="timerIndividueltCheck" data-field="timerIndividueltCheck" />
                            <input id="timerIndividuelt" data-field="timerIndividuelt" class="form-control form-control-sm" type="text" placeholder="Gruppe supervision" />
                        </div>

                        <div class="form-group">
                            <label for="timerGruppe">Timer gruppe</label>
                            <input type="checkbox" name="timerGruppeCheck" data-field="timerGruppeCheck" />
                            <input id="timerGruppe" data-field="timerGruppe" class="form-control form-control-sm" type="text" placeholder="Gruppe supervision" />
                        </div>

                        <div class="form-group">
                            <label for="timerKombinationIndividueltGruppe">Timer kombination individuelt & gruppe</label>
                            <input type="checkbox" name="timerKombinationIndividueltGruppeCheck" data-field="timerKombinationIndividueltGruppeCheck" />
                            <input id="timerKombinationIndividueltGruppe" data-field="timerKombinationIndividueltGruppe" class="form-control form-control-sm" type="text" placeholder="Gruppe supervision" />
                        </div>                       
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
            $("#editor").html(education[id] && education[id].spv_education || '');
            
            $('#editor').trumbowyg('html', education[id].spv_education);

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

        $(".sp-option-edit").click(function() {
            var education_id = $(this).data("id"),
                options = education[education_id] && education[education_id].options_sv ? JSON.parse(education[education_id].options_sv) : {};
                check_options = education[education_id] && education[education_id].check_options ? JSON.parse(education[education_id].check_options) : [];
            
            $("[data-field]").each(function(index, value) {
                index = $(value).data("field");
                $(value).val(options[index]);
            });
            
            $("input[type=checkbox]").prop("checked", false);

            $("[data-field]").each(function(index, value) {
                index = $(value).data("field");
                if (check_options.indexOf(index) + 1 ) {
                    $(value).prop("checked", true);
                }
            });
            
            $("#editOptionSv [data-field='education_id']").val(education_id);
            $("#editOptionSv").modal("show");
        });
    });
</script>
@endpush