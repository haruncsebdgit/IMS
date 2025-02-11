<div class="modal-body">
    {!! Form::open(['action' => ['Settings\OrganogramController@store'], 'class' => 'needs-validation', 'novalidate']) !!}
        @include('settings.organogram.form')
   {!! Form::close() !!}
</div>