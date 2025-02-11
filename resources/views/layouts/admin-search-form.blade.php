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
$_count = count( array_filter($_filter_params, 'strlen') );
?>

<div class="card panel-theme panel-group-control filter-card mb-3">
    <div class="card-header bg-secondary text-white position-relative">
        @if( $_count )
            <button type="button" class="btn-clear-filter-outside bg-transparent border-0 rounded-pill text-white hide-if-no-js" data-toggle="tooltip" title="{{ __('Discard Filter') }}">
                <i class="icon-cancel-circle2 mr-1" aria-hidden="true"></i>
            </button>
        @endif

        <button data-toggle="collapse" class="collapsed btn btn-link btn-sm btn-block p-0 text-white text-left" aria-expanded="false" data-target="#filter-list">
            <i class="icon-filter4 mr-1" aria-hidden="true"></i> {{ __('Filter') }}
            @if( $_count )
                <span class="float-right mr-3">
                    {{ trans_choice('master.filters_are_active', $_count, ['count' => translateString($_count)]) }}
                </span>
            @endif
        </button>
    </div>
    <div class="collapse" id="filter-list">
        <div class="card-body">

            <form method="get">

                <?php
                /**
                 * ------------------------------------------------------
                 * PLACEHOLDER HOOK: admin_search_form_body
                 * ------------------------------------------------------
                 *
                 * Pass the content to display inside the search form
                 * from the list/grid page using the
                 * @section('admin_search_form_body')
                 * ------------------------------------------------------
                 */
                ?>
                @yield('admin_search_form_body')

                <input type="hidden" name="filter" class="d-none" value="yes">
                <input type="hidden" name="ipp" class="d-none" value="{{ intval(Request::input('ipp')) }}"> {{-- Items per page if present --}}

                <div class="border-top pt-2">
                    <div class="row">
                        <div class="col-sm-7 small pt-sm-2 text-muted">
                            {!! __('Choose any parameter and hit the &lsquo;Filter&rsquo; button to <em>filter</em> the result') !!}
                        </div>
                        <div class="col-sm-5 text-sm-right">
                            <button type="reset" class="btn btn-link text-secondary btn-sm btn-clear-filter">
                                <i class="icon-cancel-circle2 mr-1" aria-hidden="true"></i> {{ __('Clear Filter') }}
                            </button>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="icon-filter4 mr-1" aria-hidden="true"></i> {{ __('Filter') }}
                            </button>
                        </div>
                    </div>
                </div>

            </form>

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.collapse -->
</div>
<!-- /.filter-card -->
