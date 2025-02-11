<?php
/**
 * Count how many parameters are active
 *
 * Known issue:
 * array_filter() removes blank, null, false, 0 (zero) values.
 * Function strlen() is passed to keep zeros if they are string.
 *
 * @link https://stackoverflow.com/a/38081606/1743124
 *
 * Variable $_filter_params needs to be passed from the list/grid page.
 */
$_filter_params = array();
$_count = count( array_filter($_filter_params, 'strlen') );
?>

<div class="card panel-theme panel-group-control report-parameters-card mb-3">
    <div class="card-header bg-secondary text-white">
        <div class="row">
            <div class="col-sm-8">
                <button data-toggle="collapse" class="collapsed btn btn-link btn-sm btn-block p-0 text-white text-left" aria-expanded="true" data-target="#report-parameters">
                    <i class="icon-list-unordered mr-1" aria-hidden="true"></i> {{ __('Report Parameters') }}
                </button>
            </div>
            <div class="col-sm-4 text-sm-right">
                @if( $_count )
                    {{ trans_choice(':count parameter is active|:count parameters are active', $_count, ['count' => $_count]) }}
                @endif
            </div>
        </div>
    </div>
    <div class="collapse show" id="report-parameters">
        <div class="card-body">

            <form id="report-form" action="@yield('report_route')" method="POST" class="needs-validation" target="_blank" novalidate>

                <?php
                /**
                 * ------------------------------------------------------
                 * PLACEHOLDER HOOK: report_form_body
                 * ------------------------------------------------------
                 *
                 * Pass the form fields to display inside the
                 * report generation form, from the report
                 * page using the @section('report_form_body')
                 * ------------------------------------------------------
                 */
                ?>
                @yield('report_form_body')

                @if (View::hasSection('report_form_columns'))
                    <div class="section-report-column-toggle card mb-2">
                        <button class="btn btn-light btn-sm btn-block text-left" type="button" data-toggle="collapse" data-target="#toggle-columns-section" aria-expanded="false" aria-controls="toggle-columns-section">
                            <span class="text-uppercase"><i class="icon-menu-open mr-1" aria-hidden="true"></i> {{ __('Toggle Columns') }}</span>
                            <span class="text-muted float-right d-none d-sm-block font-italic">{{ __('Show/Hide Columns in the Report') }}</span>
                        </button>
                        <div class="collapse pt-1 border-top" id="toggle-columns-section">
                            <?php
                            /**
                             * ------------------------------------------------------
                             * PLACEHOLDER HOOK: report_form_columns
                             * ------------------------------------------------------
                             *
                             * Pass the data columns to let the user show/hide,
                             * result columns from the report page using
                             * the @section('report_form_columns')
                             * ------------------------------------------------------
                             */
                            ?>
                            @yield('report_form_columns')
                        </div>
                    </div>
                @endif

                <div class="border-top pt-2">
                    <div class="row">
                        <div class="col-sm-6 small pt-sm-2 text-muted">
                            {!! __('Choose any parameter and hit the &lsquo;Preview&rsquo; button to generate the report') !!}
                        </div>
                        <div class="col-sm-6 text-sm-right">
                            <button type="reset" class="btn btn-link text-secondary btn-sm btn-clear-filter-no-reload">
                                <i class="icon-cancel-circle2 mr-1" aria-hidden="true"></i> {{ __('Clear') }}
                            </button>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="export-report" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-download mr-1" aria-hidden="true"></i>
                                    {{ __('Export') }}
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="export-report">
                                @foreach ($modes as $mode => $value)
                                    @php
                                    if ('preview' === $mode) {
                                        continue;
                                    }
                                    @endphp
                                    @if ('print' === $mode)
                                        <div class="dropdown-divider"></div>
                                    @endif
                                    <button type="button" class="dropdown-item report-trigger" name="mode" value="{{ $mode }}" title="{{ $value['acronym'] ?? '' }}" data-toggle="tooltip">
                                        <i class="{{ $value['icon'] }} mr-1" aria-hidden="true"></i>
                                        {{ $value['label'] }}
                                    </button>
                                @endforeach
                                </div>
                            </div>
                            @if(array_key_exists('preview', $modes))
                                <button type="button" class="btn btn-primary btn-sm report-trigger" name="mode" value="preview" title="{{ $value['acronym'] ?? '' }}" data-toggle="tooltip">
                                    <i class="{{ $modes['preview']['icon'] }} mr-1" aria-hidden="true"></i> {{ $modes['preview']['label'] }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                @csrf

            </form>

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.collapse -->
</div>
<!-- /.report-parameters-card -->

<div class="card">
    <div class="card-header">
        @yield('page_header')
    </div>

    <div class="card-body">

        <div id="progress-loader" class="d-none" style="height: 105px;">
            <?php showLoader(); ?>
        </div>

        <div id="report-viewport">
            <div class="alert alert-info alert-styled-left mb-0" role="alert">
                {!! __('Hit the <kbd>Preview</kbd> button to generate the report. You can also &lsquo;Export&rsquo; the report in different formats.') !!}
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        jQuery(document).ready(function($) {
            /**
             * AJAX Submission
             *
             * Handle the form AJAX submission, and display the retrieved data.
             * ---------------------------------------------------------------------
             */
            var report_form           = $('#report-form');
            var report_viewport       = $('#report-viewport');
            var report_default_notice = report_viewport.html();

            var progress_loader       = $('#progress-loader');

            $('.report-trigger').on('click', function(event) {
                var this_trigger = $(this);
                var mode         = this_trigger.val();

                if (false === report_form[0].checkValidity()) {

                    report_form.addClass('was-validated');

                } else {

                    if ('preview' === this_trigger.val()) {
                        report_viewport.empty();

                        var values = report_form.serialize();

                        // Set mode value on-the-fly instead of a hidden field.
                        values =  values + '&mode=' + mode;

                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                            url: report_form.attr('action'), // grab URL from the form's action attribute
                            data: values,
                            beforeSend: function() {
                                progress_loader.removeClass('d-none'); // show
                            },
                            success: function (response) {
                                progress_loader.addClass('d-none'); // hide
                                report_viewport.html(response);
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.error(textStatus, errorThrown);
                            }
                        });
                    } else {
                        // Set mode value using a hidden field in this case.
                        report_form.append('<input type="hidden" name="mode" value="'+ mode +'" /> ');

                        report_form.submit();
                    }
                }
            });
        });
    </script>
@endpush
