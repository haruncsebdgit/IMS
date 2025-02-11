@php $theOrganizationInfo = $theOrganizationInfo ?? ''; @endphp

@include('errors.validation') {{-- this placement _below_ the hook is necessary --}}

<section class="card mb-3">
    <div class="card-body">
        <p class="mb-20 text-info">
            <i class="icon-exclamation" aria-hidden="true"></i>
            {!! __('All fields marked with an asterisk (*) are required.') !!}
        </p>



        <div class="row">
            <div class="col-sm-8">

                <div class="row">
                    <div class="col-sm-12">
                        <!-- FIELD: YEAR NAME -->
                        <div class="form-group">
                            <label for="name-en" class="font-weight-bold">
                                {{ __('Name (in English)') }}
                                <sup class="text-danger">*</sup>
                            </label>

                            @php $name_en = setDefaultValue('name_en', $theOrganizationInfo); @endphp

                            <input type="text" name="name_en" class="form-control {{ $errors->has('name_en') ? 'is-invalid' : '' }}" id="name-en" placeholder="{{ __('Organization Name (in English)') }}" autocomplete="off" value="{{ $name_en }}" required>

                            @if ($errors->has('name_en'))
                            <div class="invalid-feedback">{{ $errors->first('name_en') }}</div>
                            @else
                            <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                            @endif
                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-sm-12">
                        <!-- FIELD: YEAR NAME -->
                        <div class="form-group">
                            <label for="name-bn" class="font-weight-bold">
                                {{ __('Name (in Bengali)') }}
                                <sup class="text-danger">*</sup>
                            </label>

                            @php $name_bn = setDefaultValue('name_bn', $theOrganizationInfo); @endphp

                            <input type="text" name="name_bn" class="form-control {{ $errors->has('name_bn') ? 'is-invalid' : '' }}" id="name-bn" placeholder="{{ __('Organization Name (in Bengali)') }}" autocomplete="off" value="{{ $name_bn }}" required>

                            @if ($errors->has('name_bn'))
                            <div class="invalid-feedback">{{ $errors->first('name_bn') }}</div>
                            @else
                            <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                            @endif
                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-sm-6">
                        <!-- FIELD: YEAR NAME -->
                        <div class="form-group">
                            <label for="short-name" class="font-weight-bold">
                                {{ __('Short Name') }}
                                <sup class="text-danger">*</sup>
                            </label>

                            @php $short_name = setDefaultValue('short_name', $theOrganizationInfo); @endphp

                            <input type="text" name="short_name" class="form-control {{ $errors->has('short_name') ? 'is-invalid' : '' }}" id="short-name" placeholder="{{ __('Organization Short Name') }}" autocomplete="off" value="{{ $short_name }}" required>

                            @if ($errors->has('short_name'))
                            <div class="invalid-feedback">{{ $errors->first('short_name') }}</div>
                            @else
                            <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <!-- FIELD: YEAR NAME -->
                        <div class="form-group">
                            <label for="organization-code" class="font-weight-bold">
                                {{ __('Code') }}
                                <sup class="text-danger">*</sup>
                            </label>

                            @php $_code = setDefaultValue('code', $theOrganizationInfo); @endphp

                            <select name="code" class="form-control enable-select2 {{ $errors->has('code') ? 'is-invalid' : '' }}" required>
                                <option value="">{{ __('Select a Organization Code') }}</option>
                                @foreach($organizationCode as $key => $value)
                                <option value="{{$key }}" {{ $key == $_code ? 'selected="selected"' : '' }}>
                                    {{ $value }}
                                </option>
                                @endforeach
                            </select>

                            @if ($errors->has('code'))
                            <div class="invalid-feedback">{{ $errors->first('code') }}</div>
                            @else
                            <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-6">
                        <!-- FIELD: YEAR NAME -->
                        <div class="form-group">
                            <label for="name-bn" class="font-weight-bold">
                                {{ __('Phone') }}
                            </label>

                            @php $phone = setDefaultValue('phone', $theOrganizationInfo); @endphp

                            <input type="text" name="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" id="phone" placeholder="{{ __('Organizations Mobile Number') }}" autocomplete="off" value="{{ $phone }}">

                            @if ($errors->has('phone'))
                            <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                            @else
                            <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <!-- FIELD: YEAR NAME -->
                        <div class="form-group">
                            <label for="name-bn" class="font-weight-bold">
                                {{ __('Email') }}
                            </label>

                            @php $email = setDefaultValue('email', $theOrganizationInfo); @endphp

                            <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" placeholder="{{ __('someone@gmail.com') }}" autocomplete="off" value="{{ $email }}">

                            @if ($errors->has('email'))
                            <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                            @else
                            <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-sm-6">
                        <!-- FIELD: YEAR NAME -->
                        <div class="form-group">
                            <label for="fax" class="font-weight-bold">
                                {{ __('Fax') }}
                            </label>

                            @php $fax = setDefaultValue('fax', $theOrganizationInfo); @endphp

                            <input type="text" name="fax" class="form-control {{ $errors->has('fax') ? 'is-invalid' : '' }}" id="fax" placeholder="{{ __('Fax') }}" autocomplete="off" value="{{ $fax }}">

                            @if ($errors->has('fax'))
                            <div class="invalid-feedback">{{ $errors->first('fax') }}</div>
                            @else
                            <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <!-- FIELD: YEAR NAME -->
                        <div class="form-group">
                            <label for="web-address" class="font-weight-bold">
                                {{ __('Web Address') }}
                            </label>

                            @php $web_address = setDefaultValue('web_address', $theOrganizationInfo); @endphp

                            <input type="text" name="web_address" class="form-control {{ $errors->has('web_address') ? 'is-invalid' : '' }}" id="web-address" placeholder="{{ __('Web Address') }}" autocomplete="off" value="{{ $web_address }}">

                            @if ($errors->has('web_address'))
                            <div class="invalid-feedback">{{ $errors->first('web_address') }}</div>
                            @else
                            <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                            @endif
                        </div>
                    </div>


                    <div class="col-sm-12">
                        <!-- FIELD: YEAR NAME -->
                        <div class="form-group">
                            <label for="address" class="font-weight-bold">
                                {{ __('Address') }}
                                <sup class="text-danger">*</sup>
                            </label>

                            @php $address = setDefaultValue('address', $theOrganizationInfo); @endphp

                            <input type="text" name="address" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" id="web-address" placeholder="{{ __('Address') }}" autocomplete="off" value="{{ $address }}" required>

                            @if ($errors->has('address'))
                            <div class="invalid-feedback">{{ $errors->first('address') }}</div>
                            @else
                            <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <!-- FIELD: YEAR NAME -->
                        <div class="form-group">
                            <label for="comment" class="font-weight-bold">
                                {{ __('Comment') }}
                            </label>

                            @php $_comment = setDefaultValue('comment', $theOrganizationInfo); @endphp

                            <textarea class="form-control" rows="4" cols="50" name="comment"> {{ $_comment }} </textarea>
                            @if ($errors->has('comment'))
                            <div class="invalid-feedback">{{ $errors->first('comment') }}</div>
                            @else
                            <div class="invalid-feedback">{{ __('Field is mandatory.') }}</div>
                            @endif
                        </div>
                    </div>

                </div>

            </div>

            <div class="col-sm-4">

                <div class="row">

                    <div class="col-sm-12">
                        <!-- FIELD: IS ACTIVE -->
                        <div class="form-group">
                            @php $is_active = setDefaultValue('is_active', $theOrganizationInfo, 1); @endphp

                            <label for="fy-is-active" class="font-weight-bold">{{ __('Status') }}</label>

                            <select name="is_active" id="fy-is-active" class="custom-select">
                                <option value="1" {{ 1 == $is_active ? 'selected="selected"' : '' }}>
                                    {{ __('Active') }}
                                </option>

                                <option value="0" {{ 0 == $is_active ? 'selected="selected"' : '' }}>
                                    {{ __('Inactive') }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <!-- FIELD: SORT ORDER -->
                        <div class="form-group">
                            @php $sort_order = setDefaultValue('sort_order', $theOrganizationInfo); @endphp

                            <label for="fy-sort-order" class="font-weight-bold">{{ __('Order') }}</label>

                            <input type="number" name="sort_order" id="fy-sort-order" class="form-control {{ $errors->has('sort_order') ? 'is-invalid' : '' }}" placeholder="0" min="0" autocomplete="off" value="{{ $sort_order }}" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-sm-12">
                        <div class="organization-logo-upload-holder">
                            <div class="row">
                                <div class="col-sm-12 file-upload-logo">
                                    <div class="form-group">
                                        <label for="fy-is-active" class="font-weight-bold">{{ __('Organizaion Logo') }}</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="logo" class="custom-file-input" id="logo">
                                                <label class="custom-file-label" for="organization-logo">{{ __('Choose Logo') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="help-block">
                                        Allow File: jpg, jpeg, png. Max Size: 200KB.
                                    </span>
                                </div>

                                <div class="col-sm-12 file-preview-logo">
                                    <div class="form-group">
                                        <label for="fy-is-active" class="font-weight-bold">{{ __('Preview of Organizaion Logo') }}</label></br>
                                        <?php $_logo_url = isset($theOrganizationInfo) && !empty($theOrganizationInfo->logo) ? "/storage/uploads/images/" . $theOrganizationInfo->logo : ''; ?>
                                        <a href="{{ url($_logo_url)}}" target="_blank" rel="noopener noreferrer">
                                            <img src="{{ url($_logo_url) }}" class="organization-logo-preview-holder" width="150px" height="150px" style="border:0.007px solid green;">
                                            
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm float-right delete-upload button-delete-logo" data-id="logo">
                                                <i class="icon-trash" aria-hidden="true"></i>
                                                <span class="sr-only">{{ __('Delete Attachment') }}</span>
                                            </button>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="organization-banner-upload-holder">
                            <div class="row">
                                <div class="col-sm-12 file-upload-banner">
                                    <div class="form-group">
                                        <label for="fy-is-active" class="font-weight-bold">{{ __('Organizaion Banner') }}</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="banner" class="custom-file-input" id="banner">
                                                <label class="custom-file-label" for="organization-logo">{{ __('Choose Banner') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="help-block">
                                        Allow File: jpg, jpeg, png. Max Size: 200KB.
                                    </span>
                                </div>

                                <div class="col-sm-12 file-preview-banner">
                                    <div class="form-group">
                                        <label for="fy-is-active" class="font-weight-bold">{{ __('Preview of Organizaion Banner') }}</label></br>
                                        <?php $_banner_url = isset($theOrganizationInfo) && !empty($theOrganizationInfo->banner) ? "/storage/uploads/images/" . $theOrganizationInfo->banner : ''; ?>
                                        <a href="{{ url($_banner_url)}}" target="_blank" rel="noopener noreferrer">
                                            <img src="{{ url($_banner_url) }}" class="organization-banner-preview-holder" width="150px" height="150px" style="border:0.007px solid green;">

                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm float-right delete-upload button-delete-banner" data-id="banner">
                                            <i class="icon-trash" aria-hidden="true"></i>
                                            <span class="sr-only">{{ __('Delete Attachment') }}</span>
                                        </button>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>


        @csrf
    </div>
    <!-- /.card-body -->
</section>
<!-- /.card -->

<div class="text-right">
    <button type="submit" class="btn btn-primary text-right">
        <i class="icon-floppy-disk mr-1" aria-hidden="true"></i>
        @yield('organization_form_submit_btn')
    </button>
</div>



@push('scripts')
<script>
    var app = jQuery.parseJSON(app_data);
</script>

<script src="{{ asset('js/libs/bootstrap-notify.min.js') }}"></script>

<script type="application/javascript">
    var file_upload_logo = $(".file-upload-logo");
    var file_preview_logo = $(".file-preview-logo");

    var file_upload_banner = $(".file-upload-banner");
    var file_preview_banner = $(".file-preview-banner");

    var button_delete_logo = $(".button-delete-logo");
    var button_delete_banner = $(".button-delete-banner");

    file_preview_logo.hide();
    file_preview_banner.hide();


    $(document).on('change', '.organization-logo-upload-holder [type="file"]', function() {
        var image = $(this).parents('.organization-logo-upload-holder').find('.organization-logo-preview-holder');
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                image.attr('src', e.target.result);
                image.parent('.image-preview-holder').addClass('has-image');
                file_preview_logo.show();
                button_delete_logo.hide();
            }
            reader.readAsDataURL(this.files[0]);
        } else {
            image.attr('src', '');
        }
    });



    $(document).on('change', '.organization-banner-upload-holder [type="file"]', function() {
        var image = $(this).parents('.organization-banner-upload-holder').find('.organization-banner-preview-holder');
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                image.attr('src', e.target.result);
                image.parent('.image-preview-holder').addClass('has-image');
                file_preview_banner.show();
                button_delete_banner.hide();
            }
            reader.readAsDataURL(this.files[0]);
        } else {
            image.attr('src', '');
        }
    });


    var is_logo_exits = "<?php echo $_logo_url; ?>";
    var is_banner_exits = "<?php echo $_banner_url; ?>";

    if (is_logo_exits) {
        file_preview_logo.show();
        file_upload_logo.hide();
    }
    if (is_banner_exits) {
        file_preview_banner.show();
        file_upload_banner.hide();
    }



    $('body').on('click', '.delete-upload', function(e) {
        if (confirm('Are you sure you want to delete this file permanently?')) {
            var this_btn = $(this);
            var organizationAttachmentType = this_btn.data('id');
            var organizationId = $('input:hidden[name=id]').val();

            $.ajax({
                type: 'DELETE',
                url: app.app_url + 'admin/organization/delete-upload/' + organizationId + '/' + organizationAttachmentType,
                dataType: 'json',
                success: function(data) {
                    if (data.error == 0) {

                        if (organizationAttachmentType == 'banner') {
                            file_preview_banner.hide();
                            file_upload_banner.show();
                        } else if (organizationAttachmentType == 'logo') {
                            file_preview_logo.hide();
                            file_upload_logo.show();
                        }

                        $.notify('<strong>' + data.message, {
                            type: 'success'
                        });

                    } else {
                        $.notify('<strong>' + data.message, {
                            type: 'danger'
                        });
                    }

                    console.log($(this).parent().attr('class'));
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        }
    });
</script>
@endpush