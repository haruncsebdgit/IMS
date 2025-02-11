@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section("admin_menu_settings", 'active')
@section("admin_menu_settings_financial_year", 'active')

{{-- display page title --}}
@section('page_title', __('Financial Year'))
@section('body_class', 'financial-year list')

{{-- display page header --}}
@section('page_header_icon', "icon-stats-growth")
@section('page_header', __('Financial Year'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        '#'                                              => __('Settings'),
        action('Settings\FinancialYearController@index') => __('Financial Year'),
    ];
@endphp

@section('breadcrumb_right')
    @if(hasUserCap('add_financial_year'))
        <a class="btn btn-sm btn-primary" href="{{ action('Settings\FinancialYearController@add') }}">
            <i class="icon-add mr-1" aria-hidden="true"></i>
            {{ __('Add Financial Year') }}
        </a>
    @endif
@endsection

{{-- page content --}}
@section('content')

    @include('errors.validation')

    @if(! $financialYears->isEmpty())

        <div class="border mb-1">
            <table class="table table-hover table-striped mb-0">
                <thead>
                <tr class="bg-secondary text-white">
                    <th>{{ __('Year Name') }}</th>
                    <th>{{ __('Start Date') }}</th>
                    <th>{{ __('End Date') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Is Current Financial Year?') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
                </thead>

                <tbody>
                @foreach($financialYears as $value)
                    <tr>
                        <td>
                            @if(hasUserCap('edit_financial_year'))
                                <a href="{{ action('Settings\FinancialYearController@edit', array('financial_year_id' => $value->id)) }}">
                                    <strong>{{ translateString($value->year_name) }}</strong>
                                </a>
                            @else
                                <strong>{{ $value->year_name }}</strong>
                            @endif
                        </td>

                        <td>
                            <time datetime="{{ $value->start_date }}">
                                {!! displayDateTime($value->start_date) !!}
                            </time>
                        </td>

                        <td>
                            <time datetime="{{ $value->end_date }}">
                                {!! displayDateTime($value->end_date) !!}
                            </time>
                        </td>

                        <td>
                            @if($value->is_active == 1)
                                <span class="badge badge-pill badge-success">{{ __('Active') }}</span>
                            @elseif($value->is_active == 0)
                                <span class="badge badge-pill badge-secondary">{{ __('Inactive') }}</span>
                            @endif
                        </td>

                        <td>
                            @if($value->is_current_fy == 1)
                                <span class="badge badge-primary">{{ __('Yes') }}</span>
                            @elseif($value->is_current_fy == 0)
                                <span class="badge badge-dark">{{ __('No') }}</span>
                            @endif
                        </td>

                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="row-action-button-{{ $value->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('Actions') }}
                                </button>

                                @if(hasUserCap(['edit_financial_year','delete_financial_year']))
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="row-action-button-{{ $value->id }}">
                                        @if(hasUserCap('edit_financial_year'))
                                            <a href="{{ action('Settings\FinancialYearController@edit', array('financial_year_id' => $value->id)) }}" class="dropdown-item">
                                                <i class="icon-pencil7" aria-hidden="true"></i>
                                                {{ __('Edit') }}
                                            </a>
                                        @endif

                                        @if(hasUserCap('delete_financial_year'))
                                            <div class="dropdown-divider"></div>

                                            <form action="{{ route('financialyear.delete', $value->id) }}" method="POST">
                                                <button type="submit" onclick="return confirm('Are you sure?')" class="delete-financial-year btn btn-link text-danger dropdown-item">
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
                    </tr>
                @endforeach
                </tbody>

                <tfoot>
                <tr class="bg-secondary text-white">
                    <th>{{ __('Year Name') }}</th>
                    <th>{{ __('Start Date') }}</th>
                    <th>{{ __('End Date') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Is Current Financial Year?') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
                </tfoot>
            </table>
        </div>

        {!! gridFooter($financialYears, $itemsPerPage) !!}

    @else

        <div class="alert alert-info alert-styled-left" role="alert">
            {{ __('No financial year found to display') }}
        </div>

    @endif

@endsection

