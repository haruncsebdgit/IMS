
<?php
/**
 * OPTIONS: SOCIAL
 * All the settings specific to the whole project.
 */
?>

<h3 class="font-weight-bold mb-4 border-bottom pb-1 h5 border-secondary text-secondary">{{ __('Social Settings') }}</h3>

@foreach( $options as $option )

    @if( 'facebook' === $option->option_name )
        <div class="form-group">
            <label for="facebook" class="font-weight-bold">{{ __('Facebook Page URL') }}</label>
            <i class="icon-info22 float-right" data-toggle="tooltip" data-placement="left" title="{{__('Facebook Page URL')}}"></i>
            <input type="url" name="{{ $option->option_name }}" value="{{ $option->option_value }}" class="form-control" id="facebook" placeholder="https://www.facebook.com/page-name" autocomplete="off">
        </div>
    @endif

    @if( 'twitter' === $option->option_name )
        <div class="form-group">
            <label for="twitter" class="font-weight-bold">{{ __('Twitter Profile URL') }}</label>
            <i class="icon-info22 float-right" data-toggle="tooltip" data-placement="left" title="{{__('Twitter Profile URL')}}"></i>
            <input type="url" name="{{ $option->option_name }}" value="{{ $option->option_value }}" class="form-control" id="twitter" placeholder="https://twitter.com/profile-name" autocomplete="off">
        </div>
    @endif

    @if( 'linkedin' === $option->option_name )
        <div class="form-group">
            <label for="linkedin" class="font-weight-bold">{{ __('LinkedIn Page URL') }}</label>
            <i class="icon-info22 float-right" data-toggle="tooltip" data-placement="left" title="{{__('LinkedIn Page URL')}}"></i>
            <input type="url" name="{{ $option->option_name }}" value="{{ $option->option_value }}" class="form-control" id="linkedin" placeholder="https://www.linkedin.com/page-name" autocomplete="off">
        </div>
    @endif
@endforeach
