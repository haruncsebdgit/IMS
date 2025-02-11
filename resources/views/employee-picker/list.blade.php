<script src="{{ asset('js/libs/datatables.min.js') }}"></script>
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('cs/libs/dataTables.bootstrap4.css') }}"> --}}
<div class="modal-body">
   <div class="table-responsive">
   {!! $html->table(['class'=>'table table-hover table-bordered table-striped ']) !!}
        {{-- <table class="table table-hover table-striped mb-0">
            <thead>
                <tr class="bg-secondary text-white">
                    <th class="py-1">{{ __('Employee Name (English)') }}</th>
                    <th class="py-1">{{ __('Employee Name (Bengali)') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employeeLists as $key => $value)
                    <tr>
                        <td>{{ $value->name_en }}</td>
                        <td>{{ $value->name_bn }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table> --}}
    </div>
</div>


{!! $html->scripts() !!}
<script>
    $(document).ready(function(){
        var $table = window.LaravelDataTables["dataTableBuilder"];
        $table . on('click', '.employee-list', function(){
            var employeeId = $(this).data('id');
            var employeeName = $(this).data('name');
            $('#employee-id').val(employeeId);
            $('#employee-name').val(employeeName);
            $('#myModal').modal('hide');
            //alert(employeeId);
        });
        console.log($table.search());
    });
</script>