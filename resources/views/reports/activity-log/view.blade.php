@extends($layout)

@section('page_title', __('User Activity Log'))

@section('report_heading', '')

@section('report_content')
{{-- <div class="text-center">
    <p><strong> Statement of Pay and Allowances of Assistant Office Manager</strong></p>
    <p><strong> For the month of {{ $monthYear }}</strong></p>
</div> --}}

<table class="table table-bordered" width="100%" border="1" cellpadding="3" cellspacing="0">

    <tbody>

        <tr class="bg-dark text-white" align="center">
            <th class="text-center">{{ __('User Name') }}</th>
            <th class="text-center">{{ __('Type of User') }}</th>
            <th class="text-center">{{ __('Address') }}</th>
            <th class="text-center">{{ __('Login IP') }}</th>
            <th class="text-center">{{ __('Login Time') }}</th>
            <th class="text-center">{{ __('Logout Time') }}</th>
            <th class="text-center">{{ __('Browser Info') }}</th>
        </tr>

        @foreach($logs as $key => $value)

            <tr>
                <td>{{ $value->user_name }}</td>

                <td>
                    {{ $value->user_level ? userLevelLabel($value->user_level) : '' }}
                </td>

                <td>
                    {{ $value->address }}
                </td>

                <td>{{ $value->login_ip }}</td>

                <td>{{ displayDateTime($value->login_datetime, 'd-m-Y h:i:s a') }}</td>

                <td>
                    @if($value->logout_datetime != '0000-00-00 00:00:00')
                        {{ displayDateTime($value->logout_datetime, 'd-m-Y h:i:s a') }}
                    @endif
                </td>

                <td>{{ $value->user_agent }}</td>
            </tr>
        @endforeach

    </tbody>

</table>
@endsection
