<h4 class="inline-header inline-header-center h6 my-3 text-primary font-weight-bold">
    {{ __('Approval History') }}
</h4>
<div class="table-responsive">
    <table id="supplier-item-info" class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>{{ __('Approvar') }}</th>
                <th>{{ __('Type') }}</th>
                <th>{{ __('Remarks') }}</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($approvalHistory) && !$approvalHistory->isEmpty())
                @foreach($approvalHistory as $key => $value)
                    <tr class="rows">
                        <td>
                            <span id="item-status-view-{{ $value->id }}">{{ resolveFieldName($value->user()->first()) }}</span>
                        </td>
                        <td>
                            <span id="item-view-{{ $value->id }}">{{ $value->type }}</span>
                        </td>
                        <td>
                            <span id="quantity-view-{{ $value->id }}">{{ $value->comments }}</span>
                        </td>
                    </tr>
                @endforeach

            @else
                <tr>
                    <td colspan="3">
                        <div class="alert alert-info" role="alert">
                            {{ __('Sorry, There is no approval history right now.') }}
                        </div>
                    </td>
                </tr>

            @endif
        </tbody>
    </table>
</div>

