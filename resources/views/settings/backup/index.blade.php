@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_tools', 'active')
@section('admin_menu_tools_backup', 'active')

{{-- display page title --}}
@section('page_title', __('Backup'))
@section('body_class', 'backup')

{{-- display page header --}}
@section('page_header_icon', 'icon-safe')
@section('page_header', __('Backup'))

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
	'#'  => __('Tools'),
	action('Settings\OptionsController@backup') => __('Backup')
];
@endphp

{{-- page content --}}
@section('content')

<div id="backup-page">

        @include('errors.validation')

        @if( false === hasMySQLDump() )

        	@php
				$path_to_mysqld    = getOption('_path_to_mysqld');
                $is_valid_path     = ! empty($path_to_mysqld) && is_dir($path_to_mysqld) ? true : false;
				$collapse_class    = $is_valid_path ? 'collapsed' : '';
				$collapsible_class = $is_valid_path ? '' : 'in';
				$aria_class        = $is_valid_path ? 'false' : 'true';
				$invalid           = ! empty($path_to_mysqld) && ! $is_valid_path ? true : false;
				$invalid_class     = $invalid ? 'bg-warning' : '';
        	@endphp

        	<div class="alert alert-warning alert-styled-left" role="alert">
        		<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{!! __('Understood. I don&rsquo;t need database backup') !!}" data-popup="tooltip" data-placement="left">
                    <span aria-hidden="true">&times;</span>
                </button>

				<p>{!! __('<strong>Warning: The database backup might not work.</strong> It seems the command <code>:command</code> is not accessible in your system. Try putting the path to your <code>:exe</code> file here below', ['command' => 'mysqldump', 'exe' => 'mysqldump.exe']) !!}</p>

                <div class="card mt-1">
                    <div class="card-header {{ $invalid_class }}">
                        <a data-toggle="collapse" href="#collapsible-path-to-mysqldump" aria-expanded="{{ $aria_class }}" class="{{ $collapse_class }}" style="display: block">
                            {!! __('Path to :exe', ['exe' => 'mysqldump.exe']) !!}
                        </a>
                    </div>
                    <div id="collapsible-path-to-mysqldump" class="collapse {{$collapsible_class}}" aria-expanded="false">
                        <div class="card-body">

                            <form action="{{ route('backup.mysql.save') }}" method="POST">

                                @csrf

                                <div class="row">
                                    <label for="path-to-mysqldump" class="col-sm-3 col-form-label">
                                        {!! __('Path to :exe', ['exe' => 'mysqldump.exe']) !!}
                                    </label>
                                    <div class="col-sm-7">
                                        <input type="text" name="_path_to_mysqld" class="form-control" id="path-to-mysqldump" placeholder="eg. C:\laragon\bin\mysql\mysql-5.7.19-winx64\bin" value="{{ $path_to_mysqld }}" autocomplete="off" autofocus>
                                        @if( $invalid )
                                            <div class="text-warning small">
                                                {!! __('<code>:path</code> is not a valid directory path', ['path' => $path_to_mysqld]) !!}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="submit" class="btn btn-danger">
                                            <i class="icon-floppy-disk mr-1" aria-hidden="true"></i>
                                            {{ __('Save') }}
                                        </button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

            </div>

        @endif

        <div class="alert alert-info" role="alert">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    {!! __('Take a backup of files and database easily. Taking backup is just the first step of gathering things. <strong>Always download the files and store safe in somewhere else</strong>.') !!}
                </div>
                <div class="col-md-4 col-sm-6 text-right">
                	@if( ! empty($files) )
	                	<form action="{{ route('backup.clear') }}" method="POST" style="display: inline-block;">
	                        @csrf

	                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete all the backups?')">
	                            {{ __('Delete All') }}
	                        </button>
	                    </form>
	                @endif
                    <form action="{{ route('backup.save') }}" method="POST" style="display: inline-block;">
                        @csrf

                        <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to take backup?')">
                            <i class="icon-safe mr-1" aria-hidden="true"></i> {{ __('Take Backup') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if( ! empty($files) )

            <div class="card">
                <table class="table table-sm mb-0">

                    <tbody>
                        @php
                            $date_head       = '';
                            $date_head_count = 0;
                        @endphp
                        @foreach( $files as $file )
                            @if( ! is_dir($file) )
                                @php
									$year           = substr( $file, 0, 4 );
									$month          = substr( $file, 4, 2 );
									$day            = substr( $file, 6, 2 );
									$hour           = substr( $file, 9, 2 );
									$minute         = substr( $file, 11, 2 );
									$second         = substr( $file, 13, 2 );
									$datetime       = "{$year}-{$month}-{$day} {$hour}:{$minute}:{$second}";
									$datetime_short = "{$year}-{$month}-{$day} {$hour}:{$minute}";
									$filename       = substr( $file, 16 );
                                @endphp
                                @if ($datetime_short !== $date_head)
                                    <tr>
                                        @php $date_head = $datetime_short; @endphp
                                        <th class="font-weight-bold text-uppercase bg-secondary text-white" colspan="3">
                                            {{ displayDateTime($date_head, 'd F Y h:i A') }}
                                        </th>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="pl-40">
                                        <i class="icon-arrow-down-right3 text-muted mr-1" aria-hidden="true"></i>
                                        <a href="{{ url('/'. Config::get('app.locale')) .'/admin/settings/backup/download/'. $file }}" download title="{{ __('Download Backup') }}">
                                        {{ $filename }} <i class="icon-download7" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                    <td>
                                        @php $filesize = Storage::size( "public/backups/{$file}" ); @endphp
                                        {{ formatBytes( $filesize ) }}
                                    </td>
                                    <td>
                                        <form action="{{ route('backup.delete', $file) }}" method="POST">

                                            @csrf
                                            <input type="hidden">
                                            <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">
                                                {{ __('Delete :file', ['file' => $filename]) }}
                                            </button>

                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

        @else
            <div class="alert alert-info alert-styled-left" role="alert">
                {!! __('No Backup is created yet. Please hit the &lsquo;<strong>Take Backup</strong>&rsquo; button to take a backup') !!}
            </div>
        @endif

    </div> <!-- /#settings-page -->

@endsection
