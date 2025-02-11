<div class="container-fluid">
    <div class="table-responsive-sm">

        @include('layouts.report--head')

        @yield('report_content')

        <div class="small text-muted mt-5 text-center">
            @yield('report_footer', __('Report Prepared at: :date', ['date' => translateString(date('d F Y | h:i:s a'))]))
        </div>

    </div>
</div>
