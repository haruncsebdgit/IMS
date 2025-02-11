<?php
/**
 * OPTIONS: GLOBAL
 * All the settings specific to the whole project.
 */
?>

<h3 class="font-weight-bold mb-4 border-bottom pb-1 h5 border-secondary text-secondary">{{ __('Global Settings') }}</h3>

@foreach( $options as $option )

	{{-- @if( 'is_register_open' === $option->option_name )
	    <div class="form-group">
	        <label for="{{ $option->option_name }}" class="font-weight-bold">{{ __('Is Register Open?') }}</label>
	        <i class="icon-info22 float-right" data-toggle="tooltip" data-placement="left" title="{{ __('Open New Account Registration to the site or not. Be aware that, without prior necessity, it would be risky') }}"></i>
	        <br>
	        @php
				$_value  = $option->option_value;
				$_value  = !empty($_value) ? (bool) $_value : 0;
				$checked = 1 == $_value ? 'checked="checked"' : '';
				$colored = 1 == $_value ? 'badge-success' : 'badge-secondary';
				$text_label = 1 == $_value ? __('Registration Open') : __('Registration Closed');
	        @endphp
	        <label>
				<input type="checkbox" name="{{ $option->option_name }}" value="1" class="mr-1" id="{{ $option->option_name }}" {{ $checked }}>
				{{ __('Yes, Make Registration Open') }}
            </label>
            <span class="ml-2 badge badge-pill {{ $colored }}">{{ $text_label }}</span>
	    </div>
	@endif --}}

	@if( 'contact_email' === $option->option_name )
	    <div class="form-group">
	        <label for="contact-email" class="font-weight-bold">{{ __('Contact Email Address') }}</label>
	        <i class="icon-info22 float-right" data-toggle="tooltip" data-placement="left" title="{{ __('If you want to send email to multiple recipients, separate them with commas (,)') }}"></i>
	        {{-- Input Type 'text' - As we're taking multiple email separated by commas --}}
	        <input type="text" name="{{ $option->option_name }}" value="{{ $option->option_value }}" class="form-control" id="contact-email" placeholder="someone@email.com, anotherone@email.com" autocomplete="off">
	    </div>
	@endif

    @if( 'attachments_max_file_size' === $option->option_name )
	    <div class="form-group">
	        <label for="{{ $option->option_name }}" class="font-weight-bold">{{ __('Attachments: Maximum File Upload Size') }}</label>
	        <i class="icon-info22 float-right" data-toggle="tooltip" data-placement="left" title="{{ __('Set the maximum file upload size in bytes (in fact binary bytes). You can use converter like: https://www.gbmb.org/mb-to-bytes') }}"></i>
            <div class="input-group">
                <input type="number" name="{{ $option->option_name }}" value="{{ $option->option_value }}" class="form-control" id="{{ $option->option_name }}" placeholder="{{ __('In Numbers') }}" autocomplete="off" min="0">
                <div class="input-group-append">
                    <div class="input-group-text">{{ __('Binary bytes') }}</div>
                </div>
            </div>
	    </div>
	@endif

    @if( 'attachments_file_types' === $option->option_name )
	    <div class="form-group">
	        <label for="{{ $option->option_name }}" class="font-weight-bold">{{ __('Attachments: Accepted File Types') }}</label>
	        <i class="icon-info22 float-right" data-toggle="tooltip" data-placement="left" title="{{ __('Set the accepted file extensions, separated with commas') }}"></i>
            <input type="text" name="{{ $option->option_name }}" value="{{ $option->option_value }}" class="form-control" id="{{ $option->option_name }}" placeholder="{{ __('eg. jpg, gif, docx, xlsx') }}" autocomplete="off" min="0">
	    </div>
    @endif

    @if( 'number_of_time_to_participate_in_quiz' === $option->option_name )
        <div class="form-group">
            <label for="{{ $option->option_name }}" class="font-weight-bold">{{ __('How many times a user can participate in the quiz') }}</label>
            <i class="icon-info22 float-right" data-toggle="tooltip" data-placement="left" title="{{ __('Set the accepted file extensions, separated with commas') }}"></i>
            <div class="input-group">
                <input type="number" name="{{ $option->option_name }}" value="{{ $option->option_value }}" class="form-control" id="{{ $option->option_name }}" placeholder="{{ __('eg. jpg, gif, docx, xlsx') }}" autocomplete="off" min="0">
                <div class="input-group-append">
                    <div class="input-group-text">{{ __('Times') }}</div>
                </div>
            </div>
        </div>
    @endif

    @if( 'gps_mandatory_scheme_ward_meeting_image' === $option->option_name )
	    <div class=" custom-control custom-switch">
            <input type="checkbox" <?php echo $option->option_value == 1 ? "checked" : ""?> name="{{ $option->option_name }}" value="1" class="custom-control-input" id="{{ $option->option_name }}">
	        <label for="{{ $option->option_name }}" class=" custom-control-label">{{ __('Is GPS location mandatory in scheme ward meeting image?') }}</label>
            <i class="icon-info22 float-right" data-toggle="tooltip" data-placement="left" title="{{ __('Enable this for adding GPS location mandatory validation in ward meeting image in scheme entry form') }}"></i>
	    </div>
    @endif
    @if( 'gps_mandatory_image_before_scheme_taken' === $option->option_name )
        <div class=" custom-control custom-switch">
            <input type="checkbox" <?php echo $option->option_value == 1 ? "checked" : ""?> name="{{ $option->option_name }}" value="1" class="custom-control-input" id="{{ $option->option_name }}">
            <label for="{{ $option->option_name }}" class=" custom-control-label">{{ __('Is GPS location mandatory in image before scheme taken?') }}</label>
            <i class="icon-info22 float-right" data-toggle="tooltip" data-placement="left" title="{{ __('Enable this for adding GPS location mandatory validation in image before scheme taken in scheme entry form') }}"></i>
        </div>
    @endif
    @if( 'gps_mandatory_image_during_scheme_running' === $option->option_name )
        <div class=" custom-control custom-switch">
            <input type="checkbox" <?php echo $option->option_value == 1 ? "checked" : ""?> name="{{ $option->option_name }}" value="1" class="custom-control-input" id="{{ $option->option_name }}">
            <label for="{{ $option->option_name }}" class=" custom-control-label">{{ __('Is GPS location mandatory in image during scheme running?') }}</label>
            <i class="icon-info22 float-right" data-toggle="tooltip" data-placement="left" title="{{ __('Enable this for adding GPS location mandatory validation in image during scheme running in scheme entry form') }}"></i>
        </div>
    @endif
    @if( 'gps_mandatory_image_final_scheme' === $option->option_name )
        <div class=" custom-control custom-switch">
            <input type="checkbox" <?php echo $option->option_value == 1 ? "checked" : ""?> name="{{ $option->option_name }}" value="1" class="custom-control-input" id="{{ $option->option_name }}">
            <label for="{{ $option->option_name }}" class=" custom-control-label">{{ __('Is GPS location mandatory in final scheme image?') }}</label>
            <i class="icon-info22 float-right" data-toggle="tooltip" data-placement="left" title="{{ __('Enable this for adding GPS location mandatory validation in final scheme image in scheme entry form') }}"></i>
        </div>
    @endif

    @if( 'gps_mandatory_up_inspection_image' === $option->option_name )
        <div class="custom-control custom-switch">
            <input type="checkbox" <?php echo $option->option_value == 1 ? "checked" : ""?> name="{{ $option->option_name }}" value="1" class="custom-control-input" id="{{ $option->option_name }}">
            <label for="{{ $option->option_name }}" class=" custom-control-label">{{ __('Is GPS location mandatory in UP inspection image?') }}</label>
            <i class="icon-info22 float-right" data-toggle="tooltip" data-placement="left" title="{{ __('Enable this for adding GPS location mandatory validation in UP inspection image in inspection entry form') }}"></i>
        </div>
    @endif

    @if( 'gps_mandatory_scheme_inspection_image' === $option->option_name )
        <div class="custom-control custom-switch">
            <input type="checkbox" <?php echo $option->option_value == 1 ? "checked" : ""?> name="{{ $option->option_name }}" value="1" class="custom-control-input" id="{{ $option->option_name }}">
            <label for="{{ $option->option_name }}" class=" custom-control-label">{{ __('Is GPS location mandatory in Scheme inspection image?') }}</label>
            <i class="icon-info22 float-right" data-toggle="tooltip" data-placement="left" title="{{ __('Enable this for adding GPS location mandatory validation in scheme inspection image in inspection entry form') }}"></i>
        </div>
    @endif

    @if( 'gps_mandatory_ward_meeting_image' === $option->option_name )
        <div class="custom-control custom-switch">
            <input type="checkbox" <?php echo $option->option_value == 1 ? "checked" : ""?> name="{{ $option->option_name }}" value="1" class="custom-control-input" id="{{ $option->option_name }}">
            <label for="{{ $option->option_name }}" class=" custom-control-label">{{ __('Is GPS location mandatory in Ward meeting image?') }}</label>
            <i class="icon-info22 float-right" data-toggle="tooltip" data-placement="left" title="{{ __('Enable this for adding GPS location mandatory validation in ward meeting image in meeting tracker entry form') }}"></i>
        </div>
    @endif

@endforeach
