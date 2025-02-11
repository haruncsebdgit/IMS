@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section("admin_menu_settings", 'active')
@section("admin_menu_settings_common_labels", 'active')

{{-- display page title --}}
@section('page_title', __('Common Labels'))
@section('body_class', "common-labels list add")

{{-- display page header --}}
@section('page_header_icon', "icon-clipboard3")
@section('page_header', __('Common Labels'))

{{-- submit button label --}}
@section('common_label_form_submit_btn', __('Add'))

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
'#' => __('Settings'),
action('Settings\CommonLabelController@index') => __('Common Labels')
];

if($currentDataType) {
$breadcrumbs[$currentDataType] = $dataTypes[$currentDataType];
}
@endphp

<?php
$lang        = config('app.locale');
$column_name = "name_{$lang}";
?>

{{-- page content --}}
@section('content')

{{-- ADD: Common Labels --}}
<div class="card mb-3">
    <div class="card-body">

        <!-- FIELD: DATA TYPE -->
        <label for="data-type" class="sr-only">{{ __('Data Type') }}</label>

        <select name="data_type" id="data-type" class="custom-select {{ $errors->has('data_type') ? 'is-invalid' : '' }}" required>
            <option value="">{{ __('Select a Data Type') }}</option>
            @foreach( $dataTypes as $key_type => $value_type)
            <option value="{{ $key_type }}" {{ $key_type == $currentDataType ? 'selected="selected"' : '' }}>
                {{ $value_type }}
            </option>
            @endforeach
        </select>

    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

@if($currentDataType)
<h4 class="border-bottom border-primary h5 font-weight-bold text-primary pb-1">{{ $dataTypes[$currentDataType] }}</h4>
@endif

<div class="row">

    @if($currentDataType)

    <div class="col-sm-4">
        <form action="{{ route('commonlabels.save') }}" method="POST" class="needs-validation" novalidate>
            @include('settings/common-labels/form')
        </form>
    </div>

    {{-- LIST: Common Labels --}}
    <div class="col-sm-8">

        @if( ! $commonLabels->isEmpty() )

        <div class="border mb-1">
            <table class="table table-hover table-striped mb-0">
                <thead>
                    <tr class="bg-secondary text-white">
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Order') }}</th>
                        <th>{{ __('Code') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach( $commonLabels as $commonLabel )

                    <tr>
                        <td>
                            @if( hasUserCap("edit_common_labels"))
                            <a href="{{ action('Settings\CommonLabelController@edit', [$commonLabel->id]) }}" class="btn btn-link btn-xs pl-0">
                                <strong>{{ $commonLabel->$column_name ??  $commonLabel->name_en }}</strong>
                            </a>
                            @else
                            <strong>{{ $commonLabel->$column_name ??  $commonLabel->name_en }}</strong>
                            @endif

                            @if( hasUserCap(['edit_common_labels', 'delete_common_labels']) )
                            <br />

                            <div class="grid-utilities">

                                <form action="{{ route('commonlabels.delete', $commonLabel->id) }}" method="POST">

                                    <div class="btn-group">
                                        @if( hasUserCap('edit_common_labels') )
                                        <a href="{{ action('Settings\CommonLabelController@edit', [$commonLabel->id]) }}" class="btn btn-sm btn-link">
                                            {{ __('Edit') }}
                                        </a>
                                        @endif

                                        @if( hasUserCap('delete_common_labels') )
                                        @if($commonLabel->is_delatable == 1)
                                        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-link text-danger">
                                            {{ __('Delete') }}
                                        </button>
                                        @endif
                                        @endif
                                    </div>

                                    @if( hasUserCap('delete_common_labels') )
                                    @csrf
                                    @method('DELETE')
                                    @endif

                                </form>

                            </div>
                            @endif
                        </td>

                        <td>
                            @if($commonLabel->status == 1)
                            <span class="badge badge-pill badge-success">{{ __('Active') }}</span>
                            @elseif($commonLabel->status == 0)
                            <span class="badge badge-pill badge-secondary">{{ __('Inactive') }}</span>
                            @endif
                        </td>

                        @php
                        $order = ('bn' === app()->getLocale()) ? ENtoBN::translate_number($commonLabel->order) : $commonLabel->order;
                        @endphp
                        <td>
                            {{ $order }}
                        </td>

                        <td>
                            {{ ($commonLabel->code) ? $commonLabel->code : "―"}}
                        </td>

                    </tr>

                    @endforeach
                </tbody>

                <tfoot>
                    <tr class="bg-secondary text-white">
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Order') }}</th>
                        <th>{{ __('Code') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        {!! gridFooter($commonLabels, $itemsPerPage) !!}

        @else

        <div class="alert alert-info alert-styled-left" role="alert">
            {{ __('No common labels found to display') }}
        </div>

        @endif

    </div>
    @endif
</div>

@endsection
