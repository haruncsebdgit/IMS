<div class="row">


    <div class="col-sm-4">
        <div class="form-group">
            <label for="user-role" class="d-block">
                <span class="font-weight-bold">{{ __('User') }}</span>
            </label>
            {!! Form::select('user_id', $userLists, null, ['class'=>'form-control enable-select2 user' ,'placeholder' =>  __('Select') ]) !!}
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label for="date_from" class="font-weight-bold">{{ __('Date (From)') }}
            </label>

            <div class="input-group">
                {!! Form::text('date_from', date('d-m-Y'), [ 'class'=>'form-control datepicker', 'placeholder' =>  __('Pick a date'), 'autocomplete'=>'off']) !!}
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="icon-calendar" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="date_to" class="font-weight-bold">{{ __('Date (To)') }}
            </label>

            <div class="input-group">
                {!! Form::text('date_to', date('d-m-Y'), [ 'class'=>'form-control datepicker', 'placeholder' =>  __('Pick a date'), 'autocomplete'=>'off']) !!}
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="icon-calendar" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

