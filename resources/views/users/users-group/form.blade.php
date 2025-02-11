@include('errors.validation')

@php
    $usersGroupId = isset($usersGroupData) ? $usersGroupData->id : null;
@endphp

<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <!-- FIELD: TITLE (ENGLISH) -->
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="gr-title" class="d-block">
                        <span class="font-weight-bold">{{ __('Title (in English)') }}</span>
                        <span class="float-right small text-danger">({{ __('Required') }})</span>
                    </label>

                    @php
                        $title_field_val = isset($usersGroupData) ? $usersGroupData->title : old('title');
                    @endphp

                    <input id="gr-title" type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" value="{{ $title_field_val }}" required autocomplete="off">

                    @if ($errors->has('title'))
                        <div class="invalid-feedback">{{ $errors->first('title') }}</div>
                    @endif
                </div>
            </div>

            <!-- FIELD: TITLE (BENGALI)-->
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="gr-title-bn" class="d-block">
                        <span class="font-weight-bold">{{ __('Title (in Bengali)') }}</span>
                    </label>

                    @php
                        $title_bn_field_val = isset($usersGroupData) ? $usersGroupData->title_bn : old('title_bn');
                    @endphp

                    <input id="gr-title-bn" type="text" class="form-control" name="title_bn" value="{{ $title_bn_field_val }}" autocomplete="off">
                </div>
            </div>
        </div>

        {{--<div class="clearfix">--}}
            {{--<div class="form-group">--}}
                {{--<label for="gr-remarks" class="font-weight-bold">--}}
                    {{--{{ __('Remarks') }}--}}
                {{--</label>--}}

                {{--@php--}}
                    {{--$remarks_field_val = isset($usersGroupData) ? $usersGroupData->remarks : old('remarks');--}}
                {{--@endphp--}}

                {{--<textarea name="remarks" id="gr-remarks" class="form-control {{ $errors->has("remarks") ? 'is-invalid' : '' }}" cols="30" rows="2">{{ $remarks_field_val }}</textarea>--}}
            {{--</div>--}}
        {{--</div>--}}

        <div class="text-sm-right">
            <button type="submit" class="btn btn-primary" id="btn-submit">
                <i class="icon-floppy-disk mr-1" aria-hidden="true"></i>
                @yield('user_group_form_submit_btn')
            </button>
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

@csrf

@include('users/users-group/user-list')
