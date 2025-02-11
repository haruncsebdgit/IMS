<table class="table table-sm table-report--head table-borderless">
    <thead>
        <tr>
           {{--  <th class="report-head-left text-left align-middle">
                <img src="{{ asset('images/bdgovtlogo.png') }}" alt="Logo of the Government of the People's Republic of Bangladesh" class="d-none d-sm-inline-block" width="75" height="75">
            </th> --}}
            <th class="report-head-center text-center">
                <div class="d-inline-block pt-2" style="width: 620px">
                    <img src="{{ asset('images/ju-logo-2.png') }}" alt="Logo of PRB" class="float-left site-logo mr-2" width="75" height="75">
                    <h3 class="app-name mt-2 mb-0 h4 text-left">{{__('master.app_name')}}</h3>
                    <h4 class="app-subtitle mt-0 mb-0 font-weight-normal h6 text-left">{!!__('master.app_dept')!!}</h4>
                    {{-- <div class="app-subtitle-2 small text-left">{{ __('Department of Computer Science & Engineering') }}</div> --}}
                </div>
            </th>
            {{-- <th class="report-head-right text-right align-middle">
                <img src="{{ asset('images/bdgovtlogo.png') }}" alt="Logo of PRB" class="d-none d-sm-inline-block" width="75" height="75">
            </th> --}}
        </tr>
    </thead>
</table>
<hr>
<table class="table table-sm table-report--head table-borderless">
    <thead class="text-center">
        <tr>
            <th>@yield('report_heading_left')</th>
            <th>@yield('report_heading')</th>
            <th>@yield('report_heading_right')</th>
        </tr>
        <tr>
            <td colspan="3">@yield('report_sub_heading')</td>
        </tr>
    </thead>
</table>
