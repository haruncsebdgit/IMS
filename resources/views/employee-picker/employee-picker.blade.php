<div class="form-group">
    <label for="lbf" class="d-block">
        <span class="font-weight-bold">{{ __('LBF (Local Business Facilitator)') }}</span>
        <span class="text-danger">*</span>
    </label>
    <div class="input-group">
        {!! Form::text('lbf', $employeeName ?? null, ['id'=>'employee-name', 'class' => 'form-control ' . ($errors->has('lbf') ? 'is-invalid' : ''), 'readonly']) !!}
        <span class="input-group-btn">
            <button type="button" onclick="openEmpList(event)" class="btn btn-secondary" id="btnPopUp">
                <i class="icon-search4 position-left"></i>
            </button>
        </span>
    </div>
</div>

@push('scripts')
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-keyboard="false" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Employee List') }}</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="content"></div>
        </div>
    </div>
</div>
<script>
    var app = jQuery.parseJSON(app_data);

    function openEmpList(event) {

        var url = app.app_url + 'admin/employee-picker';
        var myModal = $('#myModal');
        var modalBody = myModal.find('.content');
        modalBody.load(url);
        myModal.modal('show');
    }

</script>
@endpush
