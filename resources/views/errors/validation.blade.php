@if( Session::has('success') )
    <div class="alert alert-success alert-styled-left mb-3" role="alert" id="successMessage">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

        @php $success = Session::get('success'); @endphp
        @if( is_array($success) )
            <ul class="{{ View::hasSection('validation_success_below') ? '' : 'mb-0' }}" >
                @foreach ($success as $success_msg)
                    <li>{!! __($success_msg) !!}</li>
                @endforeach
            </ul>
        @else
            {!! __($success) !!}
        @endif

        <?php
        /**
         * ------------------------------------------------------
         * PLACEHOLDER HOOK: validation_success_below
         * ------------------------------------------------------
         *
         * Pass any custom success message from the blade
         * using @section('validation_success_below')
         * ------------------------------------------------------
         */
        ?>
        @yield('validation_success_below')
    </div>
    @php Session::forget('success'); @endphp
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-styled-left mb-3" id="failMessage" role="alert">
        <ul class="{{ View::hasSection('validation_errors_below') ? '' : 'mb-0' }}">
            @foreach ($errors->all() as $error)
                <li>{!! __($error) !!}</li>
            @endforeach
        </ul>

        <?php
        /**
         * ------------------------------------------------------
         * PLACEHOLDER HOOK: validation_errors_below
         * ------------------------------------------------------
         *
         * Pass any custom success message from the blade
         * using @section('validation_errors_below')
         * ------------------------------------------------------
         */
        ?>
        @yield('validation_errors_below')
    </div>
@endif

@if (Session::has('danger'))
    <div class="alert alert-danger alert-styled-left mb-3" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <ul class="{{ View::hasSection('validation_errors_below') ? '' : 'mb-0' }}">
            {{ session('danger') }}
        </ul>

        <?php
        /**
         * ------------------------------------------------------
         * PLACEHOLDER HOOK: validation_errors_below
         * ------------------------------------------------------
         *
         * Pass any custom danger message from the blade
         * using @section('validation_errors_below')
         * ------------------------------------------------------
         */
        ?>
        @yield('validation_errors_below')
    </div>
@endif

@push('scripts')
<script>
$(document).ready(function(){
    setTimeout(function() {
    $('#successMessage').fadeOut('fast');
}, 5000);
});
</script>

@endpush
