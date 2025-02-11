@include('errors.validation')

<div class="card mb-3">
    <div class="card-body">

        <div class="row">
            <?php $column_class = isset($userRolesData) ? 'col-sm-6' : 'col-sm-4'; ?>

            <div class="{{$column_class}}">
                <div class="form-group">
                    <label for="name" class="d-block">
                        <span class="font-weight-bold">{{ __('Name (in English)') }}</span>
                        <span class="float-right small text-danger">({{ __('Required') }})</span>
                    </label>

                    <?php $_name = isset($userRolesData) ? $userRolesData->name : old('name'); ?>
                    <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{$_name}}" required autocomplete="off" autofocus>

                    @if ($errors->has('name'))
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    @endif
                </div>
            </div>

            <div class="{{$column_class}}">
                <div class="form-group">
                    <label for="name-bn" class="d-block">
                        <span class="font-weight-bold">{{ __('Name (in Bengali)') }}</span>
                    </label>

                    <?php $_name_bn = isset($userRolesData) ? $userRolesData->name_bn : old('name_bn'); ?>
                    <input id="name-bn" type="text" class="form-control" name="name_bn" value="{{$_name_bn}}" autocomplete="off">
                </div>
            </div>

            @if(! isset($userRolesData))
            <div class="{{$column_class}}">
                <div class="form-group">
                    <label for="slug" class="d-block">
                        <span class="font-weight-bold">{{ __('Slug') }}</span>
                        <span class="float-right small text-danger">({{ __('Required') }})</span>
                    </label>

                    <?php $_slug = isset($userRolesData) ? $userRolesData->slug : old('slug'); ?>
                    {{-- RegEx source: https://stackoverflow.com/a/19256344/1743124 --}}
                    <input id="slug" type="text" class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" name="slug" value="{{$_slug}}" required autocomplete="off" pattern="[a-z0-9]+(?:-[a-z0-9]+)*">

                    @if ($errors->has('slug'))
                    <div class="invalid-feedback">{{ $errors->first('slug') }}</div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-primary" style="margin-top:30px;">
                <i class="icon-floppy-disk mr-1" aria-hidden="true"></i>
                @yield('user_role_form_submit_btn')
            </button>
        </div>

    </div>
</div>

@csrf

<div class="card">
    <div class="card-header">
        <h6>
            {{ __('Capabilities') }}
        </h6>

        <div class="heading-elements btn-group">
            <button type="button" class="btn btn-outline-secondary btn-sm" id="check-all">
                <i class="icon-stack-check mr-1" aria-hidden="true"></i>
                {{ __('Check All') }}
            </button>

            <button type="button" class="btn btn-outline-secondary btn-sm" id="uncheck-all">
                <i class="icon-stack-empty mr-1" aria-hidden="true"></i>
                {{ __('Uncheck All') }}
            </button>
        </div>
    </div>

    <div>
        @php
        $registeredCapabilities = \App\Http\Controllers\Users\UserController::allCapabilities();
        $capabilities = isset($userRolesData) ? \App\Models\Settings\Option::maybeUnserialize($userRolesData->permissions) : [];
        @endphp

        <nav class="mt-1 p-1">
            <ul class="nav nav-tabs">
                <?php $_counter = 0; ?>

                @foreach( $registeredCapabilities as $module => $data )
                @if( hasUserCap(array_keys(call_user_func_array('array_merge', array_values($data) ) )) || $userLevel === 'super_admin')
                <li role="presentation" class="nav-item">
                    <a href="#{{ Str::slug($module) }}" aria-controls="{{ Str::slug($module) }}" role="tab" data-toggle="tab" class="nav-link {{ $_counter == 0 ? 'active' : ''}}">
                        {{ $module }}
                    </a>
                </li>

                <?php $_counter++; ?>
                @endif
                @endforeach
            </ul>
        </nav>

        <div class="tab-content">
            <?php $counter = 0; ?>

            @foreach( $registeredCapabilities as $module => $data )

            <div role="tabpanel" class="tab-pane {{ $counter == 0 ? 'active' : ''}}" id="{{ Str::slug($module) }}">

                <table class="table table-capabilities">

                    @foreach( $data as $block => $caps )
                    @if( hasUserCap(array_keys($caps)) || $userLevel === 'super_admin')

                    <thead>
                        <tr>
                            <th class="bg-secondary text-white" colspan="2">{{ $block }}</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach( $caps as $capabilitiesKey => $capabilitiesLabel )
                        @if( hasUserCap($capabilitiesKey) || $userLevel === 'super_admin')
                        <tr>
                            <td class="pl-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="{{ Str::slug($capabilitiesKey) }}" class="caps-checkboxes child-checkbox custom-control-input" name="capabilities[]" value="{{ $capabilitiesKey }}" {{ in_array($capabilitiesKey, $capabilities) ? 'checked="checked"' : '' }}>
                                    <label class="custom-control-label" for="{{ Str::slug($capabilitiesKey) }}">{{ $capabilitiesLabel }}</label>
                                </div>
                            </td>

                            <td>
                                <code>{{ $capabilitiesKey }}</code>
                            </td>
                        </tr>
                        @endif
                        @endforeach

                    </tbody>

                    @endif

                    @endforeach

                </table>

            </div>
            <!-- /.tab-pane -->

            <?php $counter++; ?>
            @endforeach
        </div> <!-- /.tab-content -->
    </div>
</div>
