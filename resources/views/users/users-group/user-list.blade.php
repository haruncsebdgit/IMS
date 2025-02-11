@php
    if( $usersGroupId ) {
        $usersData = $usersGroupModel->getUserInfo($usersGroupId);
    } else {
        $usersData = [];
    }
@endphp

@if( isset($usersGroupId) )
    <div class="card">
        <div class="card-header">
            <h6>
                {{ __('Users') }}
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
        <!-- /.card-header -->

        <div id="user-group-list">
            <div class="hide-if-no-js pt-2 pb-2 pl-4 pr-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="icon-filter3" aria-hidden="true"></i>
                        </div>
                    </div>

                    <input type="search" id="filter-users" class="form-control" placeholder="{{ __('Type the name of the user to filter') }}" autocomplete="off">

                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary" id="reset-filter">
                            <i class="icon-reset mr-1" aria-hidden="true"></i>
                            {{ __('Reset') }}
                        </button>
                    </div>
                </div>
            </div>

            @if( ! $userList->isEmpty() )
                <table class="table table-capabilities">
                    <thead>
                    <tr>
                        <th>{{ __('Users') }}</th>

                        <th>{{ __('Roles') }}</th>
                    </tr>
                    </thead>

                    <tbody class="list">
                    @foreach( $userList as $value )
                        <tr>
                            <td class="font-weight-bold">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="user_id[]" value="{{ $value->id }}" class="custom-control-input caps-checkboxes" id="user-{{ $value->id }}" {{ array_key_exists( $value->id, $usersData ) ? 'checked="checked"':''}}>

                                    <label class="custom-control-label" for="user-{{ $value->id }}">
                                        <span class="username">{{ resolveFieldName($value) }}</span>
                                    </label>
                                </div>
                            </td>

                            <td class="text-muted">
                                <?php
                                $userRole = getUserRole($value->id);

                                if (false == $userRole) {
                                    echo '&mdash';
                                } else {
                                    $_counter    = 1;
                                    $_data_count = count($userRole);

                                    foreach ($userRole as $item) {
                                        echo strip_tags($item['label']);
                                        if ($_counter !== $_data_count) echo ', ';

                                        $_counter++;
                                    } //endforeach
                                } //endif
                                ?>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            @else
                <div class="alert alert-info" role="alert">
                    {{ __('Sorry! No data found to display') }}
                </div>
            @endif
        </div>
    </div>
    <!-- /.card -->
@else
    <div class="card">
        <div class="card-header">
            <h6>
                {{ __('Users') }}
            </h6>
        </div>

        <div class="card-body">
            <div class="alert alert-info" role="alert">
                {{ __('Please save a group first to add users to the group') }}
            </div>
        </div>
    </div>
@endif


