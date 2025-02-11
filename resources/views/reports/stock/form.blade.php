<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="user-role" class="d-block">
                <span class="font-weight-bold">{{ __('User') }}</span>
            </label>
            {!! Form::select('user_id', $userLists, null, ['class'=>'form-control enable-select2 user' ,'placeholder' =>  __('Select') ]) !!}
            {!! Form::hidden('type', $type) !!}
        </div>
    </div>
    @if (!empty($type))
        <div class="col-sm-4">
            <div class="form-group">
                <label for="location" class="d-block">
                    <span class="font-weight-bold">{{ __('Room No.') }}</span>
                </label>
                {!! Form::select('location_id', $assetLocation, $locationId ?? null, ['class' => 'form-control enable-select2 ', 'placeholder' => __('Select')]) !!}

            </div>
        </div>
    @endif
</div>

