@if( hasUserCap(['view_exclusive_permissions', 'add_exclusive_permissions', 'edit_exclusive_permissions', 'delete_exclusive_permissions']) )

    <section class="card mb-3 mt-3">
        <div class="card-header bg-secondary text-white">
            <div class="row">
                <div class="col-sm-12">
                    <button data-toggle="collapse" class="collapsed btn btn-link btn-sm btn-block p-0 text-white text-left" aria-expanded="false" data-target="#exclusive-permission-form">
                        <i class="icon-user-check  mr-1" aria-hidden="true"></i>
                        {{ __('Exclusive Permissions') }}
                    </button>
                </div>

            </div>
        </div>
        <!-- /.card-header -->

        <div class="collapse {{ ($errors->any()) ? 'show' : '' }}" id="exclusive-permission-form">
            <div class="card-body">

                @include('errors.validation')

                {{-- ADD FORM: Exclusive Permissions --}}
                @if( hasUserCap('add_exclusive_permissions') )
                    <form action="{{ route('exclusivepermission.save') }}" method="POST" class="needs-validation" novalidate>
                        @includeWhen( $showExclusivePermissionForm, 'users/exclusive-permissions/form')
                    </form>
                @endif

                {{-- View: Exclusive Permissions --}}
                @if( hasUserCap('view_exclusive_permissions') )

                    @if( ! $exclusivePermissions['data']->isEmpty() )

                        @if(hasUserCap('add_exclusive_permissions') && $showExclusivePermissionForm)
                            <h6 class="inline-header inline-header-center text-muted font-weight-bold small text-uppercase">{{ __('Exclusive Permissions') }}</h6>
                        @endif

                        <div class="accordion" id="exclusive-permission-accordion">
                            @foreach($exclusivePermissions['data'] as $exclusivePermission)

                                <div class="exclusive-permission-list-group border-bottom-not-last pt-1 pb-1">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            @if (isset($exclusivePermission->user_id) && !empty($exclusivePermission->user_id))
                                                <span class="badge badge-info badge-pill text-white"><i class="icon-user" title="{{ __('User') }}" data-toggle="tooltip"></i></span> {{ $exclusivePermission->user_name }}
                                            @elseif (isset($exclusivePermission->user_group_id) && !empty($exclusivePermission->user_group_id))
                                                @php $group_name =  isset($exclusivePermission->users_group_title) ? $exclusivePermission->users_group_title :  $exclusivePermission->group_title @endphp
                                                <span class="badge badge-primary badge-pill"><i class="icon-collaboration" title="{{ __('Group') }}" data-toggle="tooltip"></i></span> {{ $group_name }}
                                            @endif
                                        </div>

                                        <div class="col-sm-4">
                                            <span class="badge badge-pill {{ $exclusivePermission->edit == 1 ? 'badge-success' : 'badge-light text-muted border border-secondary' }}">
                                                @if($exclusivePermission->edit == 1)
                                                    <i class="icon-checkmark2" aria-hidden="true"></i>
                                                @endif
                                                {{ __('master.edit') }}
                                            </span>

                                            <span class="badge badge-pill {{ $exclusivePermission->view == 1 ? 'badge-success' : 'badge-light text-muted border border-secondary' }}">
                                                @if($exclusivePermission->view == 1)
                                                    <i class="icon-checkmark2" aria-hidden="true"></i>
                                                @endif
                                                {{ __('master.view') }}
                                            </span>

                                            <span class="badge badge-pill {{ $exclusivePermission->delete == 1 ? 'badge-success' : 'badge-light text-muted border border-secondary' }}">
                                                @if($exclusivePermission->delete == 1)
                                                    <i class="icon-checkmark2" aria-hidden="true"></i>
                                                @endif
                                                {{ __('master.delete') }}
                                            </span>
                                        </div>

                                        @if( hasUserCap(['edit_exclusive_permissions','delete_exclusive_permissions']) )
                                            <div class="col-sm-4 text-sm-right">
                                                @if( hasUserCap('edit_exclusive_permissions') )
                                                    <button type="button" class="btn btn-link btn-sm pl-0 border-right collapsed btn-permission-edit" data-toggle="collapse" data-target="#permission-edit-block-{{ $exclusivePermission->id }}" aria-expanded="false" aria-controls="permission-edit-block-{{ $exclusivePermission->id }}">
                                                        <i class="icon-pencil7" aria-hidden="true"></i>
                                                        {{ __('Edit') }}
                                                    </button>
                                                @endif

                                                @if( hasUserCap('delete_exclusive_permissions') )
                                                    <form action="{{ route('exclusivepermission.delete', $exclusivePermission->id) }}" method="POST" class="btn-group">
                                                        <button type="submit" onclick="return confirm('Are you sure to delete this Permission?')" class="delete-permission btn btn-sm btn-link text-danger pr-0" aria-label="{{ __('Delete Permission') }}">
                                                            <i class="icon-trash" aria-hidden="true"></i>
                                                            {{ __('Delete') }}
                                                        </button>

                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    @if( hasUserCap('edit_exclusive_permissions') )
                                        {{-- EDIT FORM: Exclusive Permissions --}}
                                        <div class="collapse" id="permission-edit-block-{{ $exclusivePermission->id }}" data-parent="#exclusive-permission-accordion">
                                            <form action="{{ route('exclusivepermission.update') }}" method="POST" class="needs-validation" novalidate>

                                                @include('users/exclusive-permissions/form')

                                                <input type="hidden" name="id" value="{{ $exclusivePermission->id }}">
                                                <input type="hidden" name="user_id" value="{{ isset($exclusivePermission->user_id) && !empty($exclusivePermission->user_id) ? $exclusivePermission->user_id : '' }}">
                                                <input type="hidden" name="user_group_id" value="{{ isset($exclusivePermission->user_group_id) && !empty($exclusivePermission->user_group_id) ? $exclusivePermission->user_group_id : '' }}">
                                                @method('PUT')

                                            </form>
                                        </div>
                                    @endif
                                </div>

                            @endforeach
                        </div>
                        <!-- /.accordion -->
                    @else
                        <div class="alert alert-info mb-0" role="alert">
                            {{ __('No permission added yet') }}
                        </div>
                    @endif

                @endif

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.collapse -->
    </section>
    <!-- /.card -->

@endif

@push('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            function load_exclusive_permission_per_choice(this_item) {
                if ('user' === this_item.val()) {
                    this_item.siblings('.exclusive-permission-choice-group').hide().removeAttr('required').change();
                    this_item.siblings('.exclusive-permission-choice-user').show().prop('required', true).change();
                } else if ('group' === this_item.val()) {
                    this_item.siblings('.exclusive-permission-choice-user').hide().removeAttr('required').change();
                    this_item.siblings('.exclusive-permission-choice-group').show().prop('required', true).change();
                }
            }

            load_exclusive_permission_per_choice($('.exclusive-permission-choice'));

            // Triggers only on add mode.
            $('body').on('change', '.exclusive-permission-choice', function (event) {
                var this_item = $(this);
                load_exclusive_permission_per_choice(this_item);

                // Popping out this coditions out of the function to solve a bug
                // Becasue the code was triggering on edit mode also, and making
                // the invisible field empty, on change.
                if ('user' === this_item.val()) {
                    this_item.siblings('.exclusive-permission-choice-group').val('').change();
                } else if ('group' === this_item.val()) {
                    this_item.siblings('.exclusive-permission-choice-user').val('').change();
                }
            });

            // Triggers only on edit mode, when the edit button is clicked to toggle the collapsible panel.
            $('body').on('click', '.btn-permission-edit', function (event) {
                var this_item = $(this);
                load_exclusive_permission_per_choice(this_item.parents('.exclusive-permission-list-group').find('.exclusive-permission-choice'));
            });
        });
    </script>
@endpush
