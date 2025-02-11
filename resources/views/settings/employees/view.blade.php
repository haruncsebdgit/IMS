@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_settings', 'active')
@section('admin_menu_settings_employee', 'active')
@section('admin_menu_settings_employee_view', 'active')

{{-- display page title --}}
@section('page_title', __('View Employee Information'))
@section('body_class', 'employee view')

{{-- display page header --}}
@section('page_header_icon', 'icon-users2')
@section('page_header', __('View Employee Information'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        'javascript:'                               => __('Settings'),
        action('Settings\EmployeeController@index') => __('Employees'),
    ];

    if(hasUserCap('view_employees')){
        $breadcrumbs[action('Settings\EmployeeController@view', ['employee_id' => $employeeInformation->id])] = __('View');
    }
@endphp

@section('breadcrumb_right')
    @if(hasUserCap(['view_employees','edit_employees','delete_employees']))
        <a class="btn btn-sm btn-outline-primary" href="{{ action('Settings\EmployeeController@index') }}">
            <i class="icon-list mr-1" aria-hidden="true"></i>
            {{ __('List') }}
        </a>
    @endif

    @if(hasUserCap('add_employees'))
        <a class="btn btn-sm btn-outline-primary" href="{{ action('Settings\EmployeeController@add') }}">
            <i class="icon-add mr-1" aria-hidden="true"></i>
            {{ __('Add') }}
        </a>
    @endif

    @if(hasUserCap('view_employees'))
        <a class="btn btn-sm btn-primary" href="{{ action('Settings\EmployeeController@edit', ['employee_id' => $employeeInformation->id]) }}">
            <i class="icon-pencil7 mr-1" aria-hidden="true"></i>
            {{ __('Edit') }}
        </a>
    @endif
@endsection

{{-- page content --}}
@section('content')

    @include('errors.validation')

    <section class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3 text-sm-right order-sm-2">
                    <div class="text-center mb-1">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ __('Status') . ':' }}

                        @if(1 === $employeeInformation->is_active)
                            <span class="badge badge-success">{{ __("Active") }}</span>
                        @elseif(0 === $employeeInformation->is_active)
                            <span class="badge badge-danger"> {{ __("Inactive") }}</span>
                        @endif
                    </div>

                    @php
                        $lang              = config('app.locale');
                        $name              = "name_{$lang}";
                        $employee_name     = $employeeInformation->$name ?? $employeeInformation->name_en;

                        $employee_image    = $employeeInformation->employee_image ?? old('employee_image');
                        $employeeImagePath = url("/storage/uploads/images/" . $employee_image);
                        $imageSrc          = ($employeeImagePath) ? $employeeImagePath : asset('images/placeholder-person.png');
                    @endphp

                    <a href="{{ $imageSrc }}" class="d-block" target="_blank" rel="noopener noreferrer">
                        <img src="{{ $imageSrc }}" width="150" class="mw-100 border rounded mb-3" alt="{{ __('Image of :name', ['name'=> $employee_name]) }}">
                    </a>
                </div>

                <div class="col-sm-9 order-sm-1">
                    <h3 class="font-weight-bold">{{ $employee_name }}</h3>

                    <div>
                        @if(isset($employeeInformation->designation))
                            {{ $employeeInformation->designation }}
                        @elseif(isset($employeeInformation->designation_name))
                            {{ $employeeInformation->designation_name }}
                        @endif
                    </div>
                </div>
            </div>

            <br/>

            <div class="row">
                <div class="{{ empty($employeeOrganogramIds) ? 'col-sm-6' : 'col-sm-4' }}">
                    <div class="font-weight-bold">{{ __("Father's Name") }}:</div>

                    <p>
                        {!! !empty($employeeInformation->father_name) ? $employeeInformation->father_name : '_' !!}
                    </p>

                    <div class="font-weight-bold"> {{ __('Date of Birth') }}:</div>

                    <p>
                        {!! !empty($employeeInformation->date_of_birth) ? displayDateTime($employeeInformation->date_of_birth) : '_' !!}
                    </p>

                    <div class="font-weight-bold">{{ __('National Identification (NID) Number') }}:</div>

                    <p>
                        {{ !empty($employeeInformation->nid) ? translateString($employeeInformation->nid) : '_' }}
                    </p>

                    <div class="font-weight-bold">{{ __('Gender') }}:</div>

                    <p>
                        {{ !empty($employeeInformation->gender) ? genderLabel($employeeInformation->gender) : '_' }}
                    </p>

                    <div class="font-weight-bold">{{ __('Joining Date') }}:</div>

                    <p>
                        {!! !empty($employeeInformation->joining_date) ? displayDateTime($employeeInformation->joining_date) : '_' !!}
                    </p>

                    <div class="font-weight-bold">{{ __('Employee Type') }}:</div>

                    <p>
                        @if(isset($employeeInformation->employee_type))
                            {{ $employeeInformation->employee_type }}<br>
                        @elseif(isset($employeeInformation->employee_type_name))
                            {{ $employeeInformation->employee_type_name }}<br>
                        @endif
                    </p>

                    <div class="font-weight-bold">{{ __('Employee Class') }}:</div>

                    <p>
                        @if(isset($employeeInformation->employee_class))
                            {{ $employeeInformation->employee_class }}<br>
                        @elseif(isset($employeeInformation->employee_class_name))
                            {{ $employeeInformation->employee_class_name }}<br>
                        @endif
                    </p>
                </div>

                <div class="{{ empty($employeeOrganogramIds) ? 'col-sm-6' : 'col-sm-4' }}">
                    <div class="font-weight-bold">{{ __("Mother's Name") }}:</div>

                    <p>
                        {!! !empty($employeeInformation->mother_name) ? $employeeInformation->mother_name : '_' !!}
                    </p>

                    <div class="font-weight-bold">{{ __('Mobile Number') }}:</div>

                    <p>
                        {{ !empty($employeeInformation->mobile) ? translateString($employeeInformation->mobile) : '_' }}
                    </p>

                    <div class="font-weight-bold">{{ __('E-mail') }}:</div>

                    <p>
                        {{ !empty($employeeInformation->email) ? translateString($employeeInformation->email) : '_' }}
                    </p>

                    <div class="font-weight-bold">{{ __('Religion') }}:</div>

                    <p>
                        {{ !empty($employeeInformation->religion) ? religionLabel($employeeInformation->religion) : '_' }}
                    </p>

                    <div class="font-weight-bold">{{ __('Retirement Date') }}:</div>

                    <p>
                        {!! !empty($employeeInformation->retirement_date) ? displayDateTime($employeeInformation->retirement_date) : '_' !!}
                    </p>

                    <div class="font-weight-bold">{{ __('Employee Category') }}:</div>

                    <p>
                        @if(isset($employeeInformation->employee_category))
                            {{ $employeeInformation->employee_category }}<br>
                        @elseif(isset($employeeInformation->employee_category_name))
                            {{ $employeeInformation->employee_category_name }}<br>
                        @endif
                    </p>

                    <div class="font-weight-bold">{{ __('Address') }}:</div>

                    <p>
                        {!! !empty($employeeInformation->address) ? nl2br($employeeInformation->address) : '_' !!}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="card mt-3">
        <div class="card-body border border-0 small">
            <div class="row">
                <div class="col-sm-3">
                    {{ __("Created by") }}

                    <div class="text-muted">
                        {{ ($employeeInformation->created_by) ? getUserNameById($employeeInformation->created_by) : '-'}}
                    </div>
                </div>

                <div class="col-sm-3">
                    {{ __("Created at") }}

                    <div class="text-muted">
                        {!! displayDateTime($employeeInformation->created_at, 'd F Y h:i A') !!}
                    </div>
                </div>

                <div class="col-sm-3">
                    {{ __("Updated by") }}

                    <div class="text-muted">
                        {{ ($employeeInformation->updated_by) ? getUserNameById($employeeInformation->updated_by) : '-' }}
                    </div>
                </div>

                <div class="col-sm-3">
                    {{ __("Updated at") }}

                    <div class="text-muted">
                        {!! displayDateTime($employeeInformation->updated_at, 'd F Y h:i A') !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
