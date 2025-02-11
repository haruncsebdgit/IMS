<style>
    /*
        For showing date picker in model properly
    */
    .datepicker-container {
        z-index: 1100 !important;
    }

    /*
        For placing button at the end of select2 dropdown box.
        Without these css code, button broken down and placed in down of select box
    */
    .input-group>.select2-container--default {
        width: auto !important;
        flex: 1 1 auto !important;
    }

</style>
<div class="col-sm-4">
    <div class="form-group">
        <label for="member_type" class="d-block">
            <span class="font-weight-bold">{{ __($titleMemberType) }}</span>
            <span class="text-danger {{ $isRequiredMemberType ? '':'d-none' }}">*</span>
        </label>
        {!! Form::select('member_type', dofTypes(), null, [$isRequiredMemberType, 'id'=>'cigType','placeholder'=>__('Select a type'),'class' => 'form-control enable-select2' . ($errors->has('member_type') ? 'is-invalid' : '')]) !!}
        @if ($errors->has('member_type'))
        <div class="invalid-feedback">{{ $errors->first('member_type') }}</div>
        @endif
    </div>
</div>
<div class="col-sm-4 cig-section">
    <div class="form-group">
        <label for="cig_id" class="d-block">
            <span class="font-weight-bold">{{ __('Name of CIG') }}</span>
            <span class="text-danger {{ $isRequiredCig ? '':'d-none' }}">*</span>
        </label>
        {!! Form::select('cig_id', $cigs, null, [$isRequiredCig, 'id'=>'cig-id', 'class' => 'form-control enable-select2 ' . ($errors->has('cig_id') ? 'is-invalid' : ''), 'placeholder' => __('Select')]) !!}
        @if ($errors->has('cig_id'))
        <div class="invalid-feedback">{{ $errors->first('cig_id') }}</div>
        @endif
    </div>
</div>
<div class="col-sm-4 cig-section">
    <div class="form-group">
        <label for="cig_member_id" class="d-block">
            <span class="font-weight-bold">{{ __($titleMemberName) }}</span>
            <span class="text-danger {{ $isRequiredCigMember ? '':'d-none' }}">*</span>
        </label>
        {!! Form::select('cig_member_id', $cigMembers, null, [$isRequiredCigMember, 'id'=>'cig-member-id', 'class' => 'form-control enable-select2 ' . ($errors->has('cig_member_id') ? 'is-invalid' : ''), 'placeholder' => __('Select')]) !!}
        @if ($errors->has('cig_member_id'))
        <div class="invalid-feedback">{{ $errors->first('cig_member_id') }}</div>
        @endif
    </div>
</div>
<div class='col-sm-4' id="farmer-section">
    <div class="form-group">
        <label for="farmer-name" class="d-block">
            <span class="font-weight-bold">{{ __('Name of Farmer') }}</span>
            <span class="text-danger {{ $isRequiredFarmer ? '':'d-none' }}">*</span>
        </label>
        <div class="input-group">
            {!! Form::select('farmer_id', $farmerList, null, [$isRequiredFarmer, 'id' => 'farmer-list' ,'placeholder'=>__('Select Farmer'), 'class' => 'form-control enable-select2' . ($errors->has('farmer_id') ? 'is-invalid' : '')]) !!}
            <div class="input-group-prepend ">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#farmer-modal">
                    <i class="icon-add mr-1" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        @if ($errors->has('farmer_id'))
        <div class="invalid-feedback">{{ $errors->first('farmer_id') }}</div>
        @endif
    </div>
</div>


@push('scripts')
{{-- <script src="{{ asset('js/libs/datepicker.min.js') }}"></script> --}}

<div class="modal fade" id="farmer-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-keyboard="false" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white" id="exampleModalLabel">{{ __('Add New Farmer Information') }}</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('farmer.add.ajax') }}" method="POST" id="add-farmer-form" class="needs-validation" novalidate>


                    @csrf
                    {{-- <form id="add-farmer-form" class="needs-validation" novalidate> --}}
                    {{-- {!! Form::model($farmers, ['route' => ['farmer.add.ajax', $farmers ? $farmers->id : 0], 'id'=>'add-farmer-form', 'class' => 'needs-validation', 'novalidate']) !!} --}}

                    @include('settings.farmer.form')
                </form>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">
    $(document).ready(function() {

        if (typeof app == 'undefined') {
            var app = jQuery.parseJSON(app_data);
        }
        memberType = $("#cigType").val();
        var isRequiredMemberType = '{{ $isRequiredMemberType }}';

        showHideCigNonCigSection(memberType)


        $("#cigType").change(function() {
            addRequiredByCigNonCigSectionWise($(this).val())
            showHideCigNonCigSection($(this).val())

        });

        // Show hide cig non cig fermer section by member type
        function showHideCigNonCigSection(memberType)
        {
            if (memberType === 'non-cig') {
                $("#farmer-section").removeClass('d-none');
                $(".cig-section").addClass('d-none');
                $('#cig-id').attr('required', false)
                $('#cig-member-id').attr('required', false)
                $('#farmer-list').attr('required', true)

            } else if(memberType === 'cig') {
                $("#farmer-section").addClass('d-none');
                $(".cig-section").removeClass('d-none');
                $('#cig-id').attr('required', true)
                $('#cig-member-id').attr('required', true)
                $('#farmer-list').attr('required', false)
            }else {
                $("#farmer-section").addClass('d-none');
                $(".cig-section").removeClass('d-none');
                $('#cig-id').attr('required', false)
                $('#cig-member-id').attr('required', false)
                $('#farmer-list').attr('required', false)
            }
        }

        function addRequiredByCigNonCigSectionWise(memberType)
        {
            if(!isRequiredMemberType) { // If user pass $isRequiredMemberType value as empty in this package, then no need to check required condition
                return true
            }
            if (memberType === 'non-cig') {

                $("#cig-id").prop('required', false);
                $("#cig-member-id").prop('required', false);
                $("#cig-id").val('').trigger('change');
                $("#cig-member-id").val('').trigger('change');

                $("#farmer-list").prop('required', true);

            } else {

                $("#cig-id").prop('required', true);
                $("#cig-member-id").prop('required', true);
                //$("#cig-id").val('').trigger('change');
                //$("#cig-member-id").val('').trigger('change');
                $("#farmer-list").prop('required', false);
                $("#farmer-list").val('');
            }
        }

        // Populate cig member dropdown by CIG  Id
        $('#cig-id').change(function (e, selectedId) {
         let app_locale = app.app_locale;

         var cig = $(this).val();
         if (cig) {
             $.get(app.app_url + 'admin/monitoring/cig-production/cig-member/' + cig, function (data) {
                 let cigMember = $('#cig-member-id');
                 data = JSON.parse(data);
                 if(cigMember.length > 0) {
                     //success data
                     cigMember.empty();
                     cigMember.append('<option value="">' + app.label_select + '</option>');

                     $.each(data, function (index, value) {
                         cigMember.append('<option value="' + index + '">' + value + '</option>');
                     });
                     if(selectedId) {
                         cigMember.val(selectedId.member_id);
                     }
                 }
             });
         }
     });



        $('#farmer-modal').on('show.bs.modal', function(event) {
            console.log("tt");
            //$("#add-farmer-form").trigger('reset');
            //$('#add-farmer-form')[0].reset();
            $(".needs-validation").trigger('reset');
            document.getElementById("add-farmer-form").reset();
            $('form').get(0).reset()
        })

        // let app = jQuery.parseJSON(app_data);

        /**
         * AJAX Submission
         *
         * Handle the form AJAX submission, and display the retrieved data.
         * ---------------------------------------------------------------------
         */
        var report_form = $('#add-farmer-form');

        report_form.on('submit', function(event) {
            event.preventDefault();

            if (false === report_form[0].checkValidity()) {

                report_form.addClass('was-validated');

            } else {

                var values = report_form.serialize();
                // Set mode value on-the-fly instead of a hidden field.
                values = values;

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    , type: 'POST'
                    , url: report_form.attr('action'), // grab URL from the form's action attribute
                    data: values
                    , beforeSend: function() {

                    }
                    , success: function(response) {
                        if (response.error == 0) {
                            // console.log(response.data);
                            //console.log(response.data.name_en);
                            // success message
                            $('#farmer-modal').modal('hide');
                            $('#farmer-list').append($('<option>', {
                                value: response.data.id
                                , text: response.data.name
                            }));
                            $('#farmer-list').val(response.data.id).trigger('change');
                            triggerToast('New farmer information save successfully.', 'success');
                            //getFarmerList();
                        } else if (response.error == 1) {
                            // error message
                            triggerToast(response.message, 'danger');
                        }
                    }
                    , error: function(jqXHR, textStatus, errorThrown) {
                        console.error(textStatus, errorThrown);
                    }
                });

            }
        });

    });

</script>

@endpush
