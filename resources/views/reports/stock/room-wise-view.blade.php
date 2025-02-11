@extends($layout)

@section('page_title', __('Stock'))

@section('report_heading', '')

@section('report_content')
{{-- <div class="text-center">
    <p><strong> Statement of Pay and Allowances of Assistant Office Manager</strong></p>
    <p><strong> For the month of {{ $monthYear }}</strong></p>
</div> --}}

<table class="table table-bordered" width="100%" border="1" cellpadding="3" cellspacing="0">

    <tbody>

        <tr class="bg-dark text-white" align="center">
            <th class="text-center">{{ __('Custodian') }}</th>
            <th class="text-center">{{ __('Item') }}</th>
            <th class="text-center">{{ __('Room') }}</th>
            <th class="text-center">{{ __('Stock Quantity') }}</th>
        </tr>

        @foreach($stocks as $key => $value)

            <tr>
                <td>
                    {{ !empty($value->user) ?  $value->user : $value->dept}}

                </td>

                <td>
                    {{ $value->item  }}
                </td>

                <td>
                    {{ $value->room }}
                </td>

                <td class="text-right">{{ $value->stock_quantity }}</td>
            </tr>
        @endforeach

    </tbody>

</table>
@endsection
