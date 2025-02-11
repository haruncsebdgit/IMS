@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_settings', 'active')
@section('admin_menu_settings_employee_list', 'active')

{{-- display page title --}}
@section('page_title', __('Employees'))
@section('body_class', 'employee list')

{{-- display page header --}}
@section('page_header_icon', 'icon-users2')
@section('page_header', __('Employees'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        'javascript:'                               => __('Settings'),
        action('Settings\EmployeeController@index') => __('Employees')
    ];
@endphp

@section('breadcrumb_right')
    @if(hasUserCap('add_employees'))
        <a class="btn btn-sm btn-primary" href="{{ action('Settings\EmployeeController@add') }}">
            <i class="icon-add mr-1" aria-hidden="true"></i>
            {{ __('Add') }}
        </a>
    @endif
@endsection

{{-- add necessary styles --}}
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/libs/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/libs/datepicker.min.css') }}">
@endpush

{{-- page content --}}
@section('content')

    @if(! $employeeLists->isEmpty() || filter_input(INPUT_GET, 'filter'))
        @include('settings.employees.search')
    @endif

    @include('errors.validation')

    @if(!$employeeLists->isEmpty())

        <div class="border mb-1">
            <table class="table table-hover table-striped mb-0">
                <thead>
                <tr class="bg-secondary small text-white">
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Designation') }}</th>
                    <th>{{ __('Date of Birth') }}</th>
                    <th>{{ __('Mobile Number') }}</th>
                    <th>{{ __('NID') }}</th>
                    <th>{{ __('E-mail') }}</th>
                    <th>{{ __('Gender') }}</th>
                    <th>{{ __('Joining & Retirement Date') }}</th>
                    <th>{{ __('Status') }}</th>

                    @if(hasUserCap(["edit_employees","view_employees","delete_employees"]))
                        <th>{{ __('Actions') }}</th>
                    @endif
                </tr>
                </thead>

                <tbody>
                @foreach($employeeLists as $value)
                <?php 
                    $lang = config('app.locale'); 
                    $name = "name_{$lang}";
                ?>

                    <tr>
                        <td class="font-weight-bold">
                            @if(hasUserCap('edit_employees'))
                                <a href="{{ action('Settings\EmployeeController@view', ['employee_id' => $value->id]) }}" target='_blank' rel='noopener noreferrer'>
                                    @if(isset($value->$name))
                                        {{ $value->$name }}
                                    @elseif(isset($value->name_en))
                                        {{ $value->name_en }}
                                    @endif
                                </a>
                            @else
                                @if(isset($value->$name))
                                    {{ $value->$name }}
                                @elseif(isset($value->name_en))
                                    {{ $value->name_en }}
                                @endif
                            @endif
                        </td>

                        <td>
                            @if(isset($value->designation))
                                {{ $value->designation }}
                            @elseif(isset($value->designation_name))
                                {{ $value->designation_name }}
                            @endif
                        </td>

                        <td>
                            <time datetime="{{ $value->date_of_birth }}">
                                {!! !empty($value->date_of_birth) ? displayDateTime($value->date_of_birth) : '_' !!}
                            </time>
                        </td>

                        <td>
                            {{ $value->mobile ? translateString($value->mobile) : '_' }}
                        </td>

                        <td>
                            {{ translateString($value->nid) }}
                        </td>

                        <td>
                            {{ $value->email }}
                        </td>

                        <td>
                            {{ genderLabel($value->gender) }}
                        </td>
                        
                        <td>
                            @if((isset($value->joining_date) && !empty($value->joining_date)) || (isset($value->retirement_date) && !empty($value->retirement_date)))
                                @if(isset($value->joining_date) && !empty($value->joining_date))
                                    <div class="d-inline-block" title="{{ __('Joining Date') }}" data-toggle="tooltip" data-placement="right">
                                        <time datetime="{{ $value->joining_date }}">
                                            {!! displayDateTime($value->joining_date) !!}
                                        </time>
                                    </div>
                                @endif

                                @if((isset($value->joining_date) && !empty($value->joining_date)) && (isset($value->retirement_date) && !empty($value->retirement_date)))
                                    <br/>
                                @endif

                                @if(isset($value->retirement_date) && !empty($value->retirement_date))
                                    <div class="d-inline-block" title="{{ __('Retirement Date') }}" data-toggle="tooltip" data-placement="right">
                                        <time datetime="{{ $value->retirement_date }}">
                                            {!! displayDateTime($value->retirement_date) !!}
                                        </time>
                                    </div>
                                @endif
                            @else
                                &mdash;
                            @endif
                        </td>

                        <td>
                            @if(1 === $value->is_active)
                                <span class="badge badge-success">{{ __("Active") }}</span>
                            @elseif(0 === $value->is_active)
                                <span class="badge badge-danger"> {{ __("Inactive") }}</span>
                            @endif
                        </td>

                        @if(hasUserCap(["edit_employees","view_employees","delete_employees"]))
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="row-action-button-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ __('Actions') }}
                                    </button>

                                    @if(hasUserCap(["edit_employees","view_employees","delete_employees"]))
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="row-action-button-1">
                                            @if(hasUserCap("edit_employees"))
                                                <a href="{{ action('Settings\EmployeeController@edit', ['employee_id' => $value->id]) }}" class="dropdown-item">
                                                    <i class="icon-pencil7" aria-hidden="true"></i>
                                                    {{ __('Edit') }}
                                                </a>
                                            @endif

                                            @if(hasUserCap('view_employees'))
                                                <a href="{{ action('Settings\EmployeeController@view', array('employee_id' => $value->id)) }}" class="dropdown-item" target='_blank' rel='noopener noreferrer'>
                                                    <i class="icon-eye" aria-hidden="true"></i>
                                                    {{ __('View') }}
                                                </a>
                                            @endif

                                            @if(hasUserCap("delete_employees"))
                                                <div class="dropdown-divider"></div>

                                                <form action="{{ route('employees.delete', $value->id) }}" method="POST">
                                                    <button type="submit" onclick="return confirm('Are you sure?')" class="delete-employee btn btn-link text-danger dropdown-item">
                                                        <i class="icon-trash" aria-hidden="true"></i>
                                                        {{ __('Delete') }}
                                                    </button>

                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>

                <tfoot>
                <tr class="bg-secondary small text-white">
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Designation') }}</th>
                    <th>{{ __('Date of Birth') }}</th>
                    <th>{{ __('Mobile Number') }}</th>
                    <th>{{ __('NID') }}</th>
                    <th>{{ __('E-mail') }}</th>
                    <th>{{ __('Gender') }}</th>
                    <th>{{ __('Joining & Retirement Date') }}</th>
                    <th>{{ __('Status') }}</th>

                    @if(hasUserCap(["edit_employees","view_employees","delete_employees"]))
                        <th>{{ __('Actions') }}</th>
                    @endif
                </tr>
                </tfoot>
            </table>
        </div>

        {!! gridFooter($employeeLists, $itemsPerPage) !!}

    @else

        <div class="alert alert-info alert-styled-left" role="alert">
            {{ __('Sorry! No data found to display') }}
        </div>

    @endif

@endsection

{{-- add necessary scripts --}}
@push('scripts')
    <script src="{{ asset('js/libs/select2.min.js') }}"></script>
    <script src="{{ asset('js/libs/datepicker.min.js') }}"></script>
    <script src="{{ asset('js/pages/employee_form_page.js') }}"></script>
@endpush

