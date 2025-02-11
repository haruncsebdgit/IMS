<style>

    /*  
        For placing button at the end of select2 dropdown box.
        Without these css code, button broken down and placed in down of select box
    */
    .input-group>.select2-container--default {
        width: auto !important;
        flex: 1 1 auto !important;
    }

</style>
<div class="row">
    <div class="col-sm-{{ $cols }}">
        <div class="form-group">
            <label for="organization_id" class="d-block">
                <span class="font-weight-bold">{{ __('Organization') }}</span>
                <span class="text-danger {{ $isRequiredOrganization ? '' : 'd-none' }}">*</span>
            </label>
            {!! Form::select('organization_id', $organizations, count($organizations) == 1 ? $organizations->keys()->first() : null, [$isRequiredOrganization, 'id'=>'organization', 'class' => 'form-control enable-select2 ' . ($errors->has('organization_id') ? 'is-invalid' : ''), 'placeholder' => __('Select'), '']) !!}
            @if ($errors->has('organization_id'))
            <div class="invalid-feedback">{{ $errors->first('organization_id') }}</div>
            @endif
        </div>
    </div>
    <div class="col-sm-{{ $cols * 2 }}">
        <div class="form-group">
            <label for="organogram_id" class="d-block">
                <span class="font-weight-bold">{{ __('Organogram') }}</span>
                <span class="text-danger {{ $isRequiredOrganogram ? '' : 'd-none' }}">*</span>
            </label>
            <div class="input-group">
                {!! Form::select('organogram_id', $organograms, null, [$isRequiredOrganogram, 'id'=>'organogram', 'class' => 'form-control enable-select2 ' . ($errors->has('organogram_id') ? 'is-invalid' : ''), 'placeholder' => __('Select'), '']) !!}
                <div class="input-group-text">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                        <label class="custom-control-label" for="customCheck1">
                            {{ __('Compiled ?') }}
                        </label>
                    </div>
                </div>
            </div>
            @if ($errors->has('organogram_id'))
            <div class="invalid-feedback">{{ $errors->first('organogram_id') }}</div>
            @endif
        </div>
    </div>
    
    <div class="col-sm-{{ $cols }}">
        <div class="form-group">
            <label for="project_id" class="d-block">
                <span class="font-weight-bold">{{ __('Project') }}</span>
                <span class="text-danger {{ $isRequiredProject ? '' : 'd-none' }}">*</span>
            </label>
            {!! Form::select('project_id', $projects, null, [$isRequiredProject, 'id'=>'project', 'class' => 'form-control enable-select2 ' . ($errors->has('project_id') ? 'is-invalid' : ''), 'placeholder' => __('Select'), '']) !!}
            @if ($errors->has('project_id'))
            <div class="invalid-feedback">{{ $errors->first('project_id') }}</div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function(){
            var app = jQuery.parseJSON(app_data);
            $('#organization').change(function (e, selectedItemsCompany) {
                let app_locale = app.app_locale;
                
                var organizationId = $(this).val();
                if (organizationId) {
                    $.get(app.app_url + 'admin/organization/organograms/getOrganogramByOrganizationId/' + organizationId, function (data) {
                        let organogram = $('#organogram');
                        //data = JSON.parse(data);
                        console.log(data);
                        if(organogram.length > 0) {
                            //success data
                            organogram.empty();
                            organogram.append('<option value="">' + app.label_select + '</option>');

                            $.each(data, function (index, value) {
                                organogram.append('<option value="' + index + '">' + value + '</option>');
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
