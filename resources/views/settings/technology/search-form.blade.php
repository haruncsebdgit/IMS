<?php
/**
* Created by PhpStorm.
* User: Arif
* Date: 5/11/2020
* Time: 3:10 PM
*/

$_filter_params = array(
'param_name' => filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING),
'param_technology_type' => filter_input(INPUT_GET, 'technology_type_id', FILTER_SANITIZE_STRING),
'param_is_active' => filter_input(INPUT_GET, 'is_active', FILTER_SANITIZE_STRING),
);
?>

@section('admin_search_form_body')

<div class="row">

<div class="col-sm-4">
<!-- FIELD: YEAR NAME -->
<div class="form-group">
<label for="bank-name" class="font-weight-bold">
{{ __(' Name') }}
</label>
<input type="text" name="name" value="{{ $_filter_params['param_name'] }}"
class="form-control technology-name {{ $errors->has('name') ? 'is-invalid' : '' }}"
autocomplete="off">
</div>
</div>



<div class="col-sm-4">
<!-- FIELD: YEAR NAME -->
<div class="form-group">
<label for="technology-type--name" class="font-weight-bold">
{{ __('Technology Type') }}
</label>

<select name="technology_type_id" id="technology_type_id" class="form-control">
<option value="">{{ __('Select a Technology Type') }}</option>
@foreach($technologyTypeList as $key => $technologyTypeName)
<option
value="{{ $key }}" {{ $key == $_filter_params['param_technology_type'] ? 'selected="selected"' : '' }} >
{{ $technologyTypeName }}
</option>
@endforeach
</select>
</div>
</div>

<div class="col-sm-4">
<!-- FIELD: IS ACTIVE -->
<div class="form-group">

<label for="is-active" class="font-weight-bold">{{ __('Status') }}</label>

<select name="is_active" id="is-active" class="custom-select">
<option value="">{{ __('Select a Status') }}</option>
<option value="active" {{ "active" === $_filter_params['param_is_active'] ? 'selected="selected"' : '' }}>
{{ __('Active') }}
</option>

<option value="inactive" {{ "inactive" === $_filter_params['param_is_active'] ? 'selected="selected"' : '' }}>
{{ __('Inactive') }}
</option>
</select>
</div>
</div>

</div>

@endsection

@include('layouts.admin-search-form')