<div class="container">
    <div class="row">
        
        <div class="col-sm-4">
            <div class="form-group">
                <label for="cig_name" class="d-block">
                    <span class="font-weight-bold">{{ __('Name of Supplier') }}</span>
                </label>
                {{ $supplier_information->name_en }}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="cig_address" class="d-block">
                    <span class="font-weight-bold">{{ __('Supplier name in Bangla') }}</span>
                </label>
                {{ $supplier_information->name_bn }}
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label for="establish_date" class="d-block">
                    <span class="font-weight-bold">{{ __('Contact No.') }}</span>
                </label>
                {{ $supplier_information->contact_no }}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="registration_no" class="d-block">
                    <span class="font-weight-bold">{{ __('Email') }}</span>
                </label>
                {{ $supplier_information->email }}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="registration_date" class="d-block">
                    <span class="font-weight-bold">{{ __('Website') }}</span>
                </label>
                 {{ $supplier_information->website }}
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label for="cig_grade" class="d-block">
                    <span class="font-weight-bold">{{ __('Address') }}</span>
                    {{-- <span class="text-danger">*</span> --}}
                </label>
                {{ $supplier_information->address }}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="bank_name_id" class="d-block">
                    <span class="font-weight-bold">{{ __('Tenderer') }}</span>
                    {{-- <span class="text-danger">*</span> --}}
                </label>
                {{ $supplier_information->tender_name }}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="is_applied_registration" class="d-block">
                    <span class="font-weight-bold">{{ __('Is Active') }}</span>
                    {{-- <span class="text-danger">*</span> --}}
                </label>
                @if($supplier_information->is_active)
                    {{ __('Yes') }}
                @else 
                    {{ __('No') }}
                @endif
            </div>
        </div>
        
        
    </div>
</div>
