@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/libs/select2.min.css') }}">
@endpush
 <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="meeting-tracker" class="d-block">
                    <span class="font-weight-bold">{{ __('Parent Node') }}</span>
                    <span class="small text-danger">*</span>
                </label>
                <div class="">
                    {!! Form::select('parent_id', $parentOffice, $parentId, ['id'=>'parent-office','class'=>'form-control enable-select2 '. ($errors->has('parent_id') ? 'is-invalid' : '') ,'placeholder' => __('Select'), 'required' ]) !!}
                </div>

                @if ($errors->has('parent_id'))
                <div class="invalid-feedback">{{ $errors->first('parent_id') }}</div>
                @endif
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="meeting-tracker" class="d-block">
                    <span class="font-weight-bold">{{ __('Office Type') }}</span>
                    <span class="small text-danger">*</span>
                </label>
                <div class="">
                    {!! Form::select('office_type', $officeTypes, null, ['id'=>'office-type','class'=>'form-control select2 '. ($errors->has('office_type') ? 'is-invalid' : '') ,'placeholder' => __('Select'), 'required' ]) !!}
                </div>

                @if ($errors->has('office_type'))
                <div class="invalid-feedback">{{ $errors->first('office_type') }}</div>
                @endif
            </div>
        </div>
        
        <div class="col-sm-6">
            <div class="form-group">
                <label for="meeting-tracker" class="d-block">
                    <span class="font-weight-bold">{{ __('Name (English)') }}</span>
                    <span class="small text-danger">*</span>
                </label>
                <div class="">
                    {!! Form::text('name_en', null, ['id'=>'name_en','class'=>'form-control '. ($errors->has('name_en') ? 'is-invalid' : '') ,'placeholder' => '', 'required' ]) !!}
                </div>

                @if ($errors->has('name_en'))
                <div class="invalid-feedback">{{ $errors->first('name_en') }}</div>
                @endif
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="meeting-tracker" class="d-block">
                    <span class="font-weight-bold">{{ __('Name (Bengali)') }}</span>
                    <span class="small text-danger">*</span>
                </label>
                <div class="">
                    {!! Form::text('name_bn', null, ['id'=>'name_bn','class'=>'form-control '. ($errors->has('name_bn') ? 'is-invalid' : '') ,'placeholder' => '', 'required' ]) !!}
                </div>

                @if ($errors->has('name_bn'))
                <div class="invalid-feedback">{{ $errors->first('name_bn') }}</div>
                @endif
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="division" class="d-block">
                @if(auth()->user()->organization_id == config('app.organization_id_dae'))
                    <span class="font-weight-bold">{{ __('Regions') }}</span>
                @else 
                    <span class="font-weight-bold">{{ __('Division') }}</span>
                @endif
                    {{-- <span class="small text-danger">*</span> --}}
                </label>
                <div class="">
                    {!! Form::select('division_region_id', $divisions, null, ['id'=>'division','class'=>'form-control select2 '. ($errors->has('division_region_id') ? 'is-invalid' : '') ,'placeholder' => __('Select') ]) !!}
                </div>

                @if ($errors->has('division_region_id'))
                <div class="invalid-feedback">{{ $errors->first('division_region_id') }}</div>
                @endif
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="division" class="d-block">
                    <span class="font-weight-bold">{{ __('District') }}</span>
                    {{-- <span class="small text-danger">*</span> --}}
                </label>
                <div class="">
                    {!! Form::select('district_id', $districts, null, ['id'=>'district','class'=>'form-control select2 '. ($errors->has('district_id ') ? 'is-invalid' : '') ,'placeholder' => __('Select') ]) !!}
                </div>

                @if ($errors->has('district_id '))
                <div class="invalid-feedback">{{ $errors->first('district_id ') }}</div>
                @endif
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="upazila" class="d-block">
                    <span class="font-weight-bold">{{ __('Upazila') }}</span>
                    {{-- <span class="small text-danger">*</span> --}}
                </label>
                <div class="">
                    {!! Form::select('upazila_id', $upazilla, null, ['id'=>'thana-upazila','class'=>'form-control select2 '. ($errors->has('upazila_id ') ? 'is-invalid' : '') ,'placeholder' => __('Select') ]) !!}
                </div>

                @if ($errors->has('upazila_id '))
                <div class="invalid-feedback">{{ $errors->first('upazila_id ') }}</div>
                @endif
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                <label for="union_id" class="d-block">
                    <span class="font-weight-bold">{{ __('Union') }}</span>
                    {{-- <span class="small text-danger">*</span> --}}
                </label>
                <div class="">
                    {!! Form::select('union_id', $unions, null, ['id'=>'union-ward','class'=>'form-control select2 '. ($errors->has('union_id ') ? 'is-invalid' : '') ,'placeholder' => __('Select') ]) !!}
                </div>

                @if ($errors->has('union_id '))
                <div class="invalid-feedback">{{ $errors->first('union_id ') }}</div>
                @endif
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="meeting-tracker" class="d-block">
                    <span class="font-weight-bold">{{ __('Office Code') }}</span>
                    {{-- <span class="small text-danger">*</span> --}}
                </label>
                <div class="">
                    {!! Form::text('code', null, ['id'=>'code','class'=>'form-control '. ($errors->has('code') ? 'is-invalid' : '') ,'placeholder' => '' ]) !!}
                </div>

                @if ($errors->has('code'))
                <div class="invalid-feedback">{{ $errors->first('code') }}</div>
                @endif
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="meeting-tracker" class="d-block">
                    <span class="font-weight-bold">{{ __('Phone') }}</span>
                    <span class="small text-danger">*</span>
                </label>
                <div class="">
                    {!! Form::text('phone', null, ['id'=>'phone','class'=>'form-control '. ($errors->has('phone') ? 'is-invalid' : '') ,'placeholder' => '', 'required' ]) !!}
                </div>

                @if ($errors->has('phone'))
                <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                @endif
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="meeting-tracker" class="d-block">
                    <span class="font-weight-bold">{{ __('Fax') }}</span>
                    {{-- <span class="small text-danger">*</span> --}}
                </label>
                <div class="">
                    {!! Form::text('fax', null, ['id'=>'fax','class'=>'form-control '. ($errors->has('fax') ? 'is-invalid' : '') ,'placeholder' => '' ]) !!}
                </div>

                @if ($errors->has('fax'))
                <div class="invalid-feedback">{{ $errors->first('fax') }}</div>
                @endif
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="meeting-tracker" class="d-block">
                    <span class="font-weight-bold">{{ __('Address') }}</span>
                    <span class="small text-danger">*</span>
                </label>
                <div class="">
                    {!! Form::textarea('address', null, ['id'=>'address', 'rows'=>'2', 'class'=>'form-control '. ($errors->has('address') ? 'is-invalid' : '') ,'placeholder' => '', 'required' ]) !!}
                </div>

                @if ($errors->has('address'))
                <div class="invalid-feedback">{{ $errors->first('address') }}</div>
                @endif
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="up_engineer_mobile" class="d-block">
                    <span class="font-weight-bold">{{ __('Is Active') }}</span>
                    <span class=" text-danger">*</span>
                </label>
                <div class="custom-control custom-radio custom-control-inline">
                    {!! Form::radio('is_active', 1, false, ['id'=>"status0",'class'=>'custom-control-input '. ($errors->has('is_active') ? 'is-invalid' : ''), 'required' ]) !!}
                    <label class="custom-control-label" for="status0">{{ __("Yes") }}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    {!! Form::radio('is_active', 0, false, ['id'=>"status1",'class'=>'custom-control-input '. ($errors->has('is_active') ? 'is-invalid' : ''), 'required' ]) !!}
                    <label class="custom-control-label" for="status1">{{ __("No") }}</label>
                </div>
                @if ($errors->has('is_active'))
                <div class="invalid-feedback">{{ $errors->first('is_active') }}</div>
                @endif
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="up_engineer_mobile" class="d-block">
                    <span class="font-weight-bold">{{ __('Is Inventory Center') }}</span>
                    <span class=" text-danger">*</span>
                </label>
                <div class="custom-control custom-radio custom-control-inline">
                    {!! Form::radio('is_inventory_center', 1, false, ['id'=>"is_inventory_center0",'class'=>'custom-control-input '. ($errors->has('is_inventory_center') ? 'is-invalid' : ''), 'required' ]) !!}
                    <label class="custom-control-label" for="is_inventory_center0">{{ __("Yes") }}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    {!! Form::radio('is_inventory_center', 0, false, ['id'=>"is_inventory_center1",'class'=>'custom-control-input '. ($errors->has('is_inventory_center') ? 'is-invalid' : ''), 'required' ]) !!}
                    <label class="custom-control-label" for="is_inventory_center1">{{ __("No") }}</label>
                </div>
                @if ($errors->has('is_inventory_center'))
                <div class="invalid-feedback">{{ $errors->first('is_inventory_center') }}</div>
                @endif
            </div>
        </div>
    </div>
    <div class="text-right">
        <button type="submit" class="btn btn-primary">
            <i class="icon-floppy-disk mr-1" aria-hidden="true"></i>
            {{ __('Save') }}
        </button>
    </div>
  
<script src="{{ asset('js/libs/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {

        $("#parent-office").select2({
            dropdownParent: $('#myModal .modal-content')
        });

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });

    });
</script>