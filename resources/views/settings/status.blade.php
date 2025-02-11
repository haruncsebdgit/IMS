@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_tools', 'active')
@section('admin_menu_tools_status', 'active')

{{-- display page title --}}
@section('page_title', __('System Status'))
@section('body_class', 'system-status')

{{-- display page header --}}
@section('page_header_icon', 'icon-pie-chart6')
@section('page_header', __('System Status'))

{{-- display breadcrumbs --}}
@php
$breadcrumbs =
[
    '#' => __('Tools'),
    action('Settings\StatusController@index') => __('System Status')
];
@endphp

{{-- page content --}}
@section('content')

    <div class="row">
        <div class="col-sm-9">
            <div class="card mb-3">
                <div class="card-header"><h3 class="h6 mb-0">{{ __('System Status') }}</h3></div>
                <div class="card-body">
                    <table class="table table-sm small mb-0" style="table-layout: fixed">
                        <tbody>
                            <tr class="thead-light">
                                <th colspan="2">{{ __('Server & Disk Space') }}</th>
                            </tr>
                            <tr>
                                <th>{{ __('Server') }}</th>
                                <td>{{ $_SERVER['SERVER_SOFTWARE'] }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('SSL Status') }}</th>
                                <td>{{ (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'HTTPS' : 'HTTP' }}</td>
                            </tr>
                            @php
                                $total_disk_space = disk_total_space(base_path());
                                $free_disk_space  = disk_free_space(base_path());
                                $used_disk_space  = $total_disk_space - $free_disk_space;
                                $usage_percentage = ($used_disk_space / $total_disk_space) * 100;
                            @endphp
                            <tr>
                                <th>{{ __('Total Disk Space') }}</th>
                                <td>{{ formatBytes($total_disk_space) }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Free Disk Space') }}</th>
                                <td>
                                    {{ formatBytes($free_disk_space) }} ({{ __('Usage: :usage%', ['usage' => number_format($usage_percentage, 2)]) }})
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $usage_percentage }}%" aria-valuenow="{{ $usage_percentage }}" aria-valuemin="0" aria-valuemax="100">{{ number_format($usage_percentage, 2) }}%</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                            </tr>

                            <tr class="thead-light">
                                <th colspan="2">{{ __('Framework') }}</th>
                            </tr>
                            <tr>
                                <th>{{ __('Framework Version') }}</th>
                                <td>{{ App::VERSION() }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Debug') }}</th>
                                <td>{!! $debugStatus !!}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Active Locale') }}</th>
                                <td>{{ app()->getLocale() }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Timezone') }}</th>
                                <td>{{ config('app.timezone') }}</td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                            </tr>

                            <tr class="thead-light">
                                <th colspan="2">{{ __('PHP') }}</th>
                            </tr>
                            <tr>
                                <th>{{ __('PHP Version') }}</th>
                                <td>
                                    {{ phpversion() }}
                                    @if(version_compare(phpversion(), $minimumRequirements['php_version'], '<' ))
                                        <div class="alert alert-warning small mt-1" role="alert">
                                            {{ __('Minimum Recommended PHP Version: :version', ['version' => $minimumRequirements['php_version']]) }}
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('Memory Limit') }}</th>
                                <td>{{ @ini_get( 'memory_limit' ) }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Maximum Execution Time') }}</th>
                                <td>{{ @ini_get('max_execution_time') }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Maximum Input Time') }}</th>
                                <td>{{ @ini_get('max_input_time') }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Maximum Post Size') }}</th>
                                <td>{{ @ini_get('post_max_size') }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('PHP Extensions') }}</th>
                                <td>
                                    {{ implode(', ', get_loaded_extensions()) }}
                                    @if(!empty($missingPHPExtensions))
                                        <div class="alert alert-danger alert-styled-left small mt-1" role="alert">
                                            {{ __('Missing Required Extensions: :extensions', ['extensions' => implode(', ', $missingPHPExtensions)]) }}
                                        </div>
                                    @endif
                                    @if(!empty($negligiblePHPExtensions))
                                        <div class="alert alert-warning alert-styled-left small mt-1" role="alert">
                                            {{ __('Missing Recommended Extensions: :extensions', ['extensions' => implode(', ', $negligiblePHPExtensions)]) }}
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                            </tr>

                            <tr class="thead-light">
                                <th colspan="2">{{ __('MySQL') }}</th>
                            </tr>
                            <tr>
                                <th>{{ __('MySQL Version') }}</th>
                                <td>{{ $mysqlVersion }}</td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                            </tr>

                            <tr class="thead-light">
                                <th colspan="2">{{ __('Is Upload Directories Writable?') }}</th>
                            </tr>
                            @foreach($uploadDirectoryStatus as $directory => $status)
                                <tr>
                                    <th><code>/{{ $directory }}</code></th>
                                    <td>
                                        @if($status)
                                            <span class="text-success"><i class="icon-checkmark-circle mr-1" aria-hidden="true"></i> {{ __('Yes') }}</span>
                                        @else
                                            <span class="text-danger"><i class="icon-circles mr-1" aria-hidden="true"></i> {{ __('No') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card mb-3">
                <div class="card-header"><h3 class="h6 mb-0">{{ __('Get Support') }}</h3></div>
                <div class="card-body">
                    <p>
                        {!! __('Thank you for using our system. For getting support, you are requested to contact with <strong>TechnoVista Limited</strong> with any of the following methods') !!}
                    </p>
                    <div class="font-weight-bold small">{{ __('Website') }}</div>
                    <a href="https://technovista.com.bd" target="_blank" rel="noopener" class="small">technovista.com.bd</a>
                </div>
            </div>
        </div>
    </div>

@endsection
