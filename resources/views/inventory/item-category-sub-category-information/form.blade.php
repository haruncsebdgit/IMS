@include('errors.validation')
{!! Form::hidden('organization_id', auth()->user()->organization_id) !!}
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="name_en" class="d-block">
                <span class="font-weight-bold">{{ __('Name (English)') }}</span>
                <span class="text-danger">*</span>
            </label>
            {!! Form::text('name_en', null, ['required', 'class' => 'form-control ' . ($errors->has('name_en') ? 'is-invalid' : ''), '']) !!}
            @if ($errors->has('name_en'))
            <div class="invalid-feedback">{{ $errors->first('name_en') }}</div>
            @endif
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="name_bn" class="d-block">
                <span class="font-weight-bold">{{ __('Name (Bengali)') }}</span>
            </label>
            {!! Form::text('name_bn', null, [ 'class' => 'form-control ' . ($errors->has('name_bn') ? 'is-invalid' : ''), '']) !!}
            @if ($errors->has('name_bn'))
            <div class="invalid-feedback">{{ $errors->first('name_bn') }}</div>
            @endif
        </div>
    </div>

<div class="col-sm-4">
    <div class="form-group">
        <label for="remarks" class="d-block">
            <span class="font-weight-bold">{{ __('Remarks') }}</span>
            {{-- <span class="text-danger">*</span> --}}
        </label>
        {!! Form::text('remarks', null, ['class' => 'form-control ' . ($errors->has('remarks') ? 'is-invalid' : ''), '']) !!}
        @if ($errors->has('remarks'))
        <div class="invalid-feedback">{{ $errors->first('remarks') }}</div>
        @endif
    </div>
</div>

</div>







<div class="text-right">
    <button type="submit" class="btn btn-primary">
        <i class="icon-floppy-disk mr-1" aria-hidden="true"></i>
        @yield('form_submit_btn')
    </button>
</div>

@push('scripts')
{{-- <script src="{{ asset('js/libs/datatables.min.js') }}"></script> --}}


<script src="{{ asset('js/libs/bootstrap-notify.min.js') }}"></script>
@endpush
