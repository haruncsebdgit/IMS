<!-- HIDDEN SCOPE KEY -->
<input type="hidden" name="scope_key" value="{{ $exclusivePermissions['scope_key'] }}">

<!-- HIDDEN SCOPE ID -->
<input type="hidden" name="scope_id" value="{{ $exclusivePermissions['scope_id'] }}">

<div class="row">
    <div class="col-sm-4">

        @php
            if (isset($exclusivePermission->user_id) && !empty($exclusivePermission->user_id)) {
                $row_id = '-user-'. $exclusivePermission->user_id;
                $choice_val = 'user';
            } else if (isset($exclusivePermission->user_group_id) && !empty($exclusivePermission->user_group_id)) {
                $row_id = '-group-'. $exclusivePermission->user_group_id;
                $choice_val = 'group';
            } else {
                $row_id = '';
                $choice_val = old('ep_choice') ?? '';
            }
        @endphp

        <div class="form-group">
            <label for="ep-choice{{ $row_id }}" class="text-muted small">
                {{ __('Users').'/'.__('Group') }}
                <sup class="text-danger">*</sup>
            </label>

            <div class="input-group">
                <select id="ep-choice{{ $row_id }}" name="ep_choice" class="custom-select custom-select-sm exclusive-permission-choice" style="max-width: 115px;" {{ isset($exclusivePermission) ? 'disabled="disabled"' : '' }}>
                    <option value="user" {{ 'user' === $choice_val ? 'selected="selected"' : '' }}>{{ __('Users') }}</option>
                    <option value="group" {{ 'group' === $choice_val ? 'selected="selected"' : '' }}>{{ __('Group') }}</option>
                </select>

                @php
                    $user_id_field_val = isset($exclusivePermission->user_id) && !empty($exclusivePermission->user_id) ? $exclusivePermission->user_id : old('user_id');
                @endphp

                <!-- FIELD: USER NAME -->
                <select name="user_id" class="exclusive-permission-choice-user custom-select custom-select-sm {{ $errors->has('user_id') ? 'is-invalid' : '' }}" {{ !empty($exclusivePermission->id) && isset($user_id_field_val) ? 'disabled' : '' }}>
                    <option value="">{{ __('Select User') }}</option>
                    @foreach($exclusivePermissions['users'] as $value)
                        <option value="{{ $value->id }}" {{ $value->id == $user_id_field_val ? 'selected="selected"' : '' }}>
                            {{ $value->name}}
                        </option>
                    @endforeach
                </select>

                <!-- FIELD: USER GROUP TITLE -->
                @php
                    $user_group_id_field_val = isset($exclusivePermission->user_group_id) && !empty($exclusivePermission->user_group_id) ? $exclusivePermission->user_group_id : old('user_group_id');
                @endphp

                <select name="user_group_id" class="exclusive-permission-choice-group custom-select custom-select-sm {{ $errors->has('user_group_id') ? 'is-invalid' : '' }}" {{ !empty($exclusivePermission->id) && isset($user_group_id_field_val) ? 'disabled' : '' }}>
                    <option value="">{{ __('Select Group') }}</option>
                    @foreach($exclusivePermissions['userGroups'] as $value)
                        @php $value = \App\Models\UsersGroup::localizeUsersGroup($value); @endphp
                        <option value="{{ $value->id }}" {{ $value->id == $user_group_id_field_val ? 'selected="selected"' : '' }}>
                            {{ $value->title}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <!-- FIELD: PERMISSIONS -->
        <label class="text-muted small">
            {{ __('Permissions') }}
        </label>

        <div class="form-group">
            @php
                $view_field_val = isset($exclusivePermission->view) ? $exclusivePermission->view: old('view');
                $edit_field_val = isset($exclusivePermission->edit) ? $exclusivePermission->edit : old('edit');
                $delete_field_val = isset($exclusivePermission->delete) ? $exclusivePermission->delete : old('delete');
            @endphp

            <div class="custom-control custom-switch custom-control-inline mr-1">
                <input type="checkbox" name="edit" value="1" {{ $edit_field_val == 1 ? 'checked="checked"' : '' }}  class="custom-control-input" id="permission-edit{{ $row_id }}">
                <label class="custom-control-label small" for="permission-edit{{ $row_id }}">{{ __('master.edit') }}</label>
            </div>

            <div class="custom-control custom-switch custom-control-inline mr-1">
                <input type="checkbox" name="view" value="1" {{ $view_field_val == 1 ? 'checked="checked"' : '' }}  class="custom-control-input" id="permission-view{{ $row_id }}">
                <label class="custom-control-label small" for="permission-view{{ $row_id }}">{{ __('master.view') }}</label>
            </div>

            <div class="custom-control custom-switch custom-control-inline mr-0">
                <input type="checkbox" name="delete" value="1" {{ $delete_field_val == 1 ? 'checked="checked"' : '' }}  class="custom-control-input" id="permission-delete{{ $row_id }}">
                <label class="custom-control-label small" for="permission-delete{{ $row_id }}">{{ __('master.delete') }}</label>
            </div>
        </div>
    </div>

    <div class="col-sm-2 text-sm-right">
        <button type="submit" class="btn btn-primary btn-sm mt-sm-4">
            {{ __('Set')  }}
        </button>
    </div>
</div>

@csrf
