@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/libs/mdb.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/libs/jstree/style.min.css') }}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" /> --}}
@endpush
<?php 
    $showCheckbox = $showCheckbox ?? false;
    $showActionButton = $showActionButton ?? false;
    $selectedId = $selectedId ?? [];
    if(empty($selectedId))  $selectedId = [];
    $organogramTreeList = getOrganogramTreeViewList($showActionButton, $selectedId);

    //dd($_javascript_data);

?>
@if( $organogramTreeList )
<div class="card">
    <div class="card-header">
        {{ __('Organogram') }}
    </div>
    
    <div class="card-body pl-0">
        <div style="overflow-y:scroll; height:500px">
        {!! $organogramTreeList !!}
        </div>
    </div>
    <!-- .card-body -->
</div>
<div id="organogram-ids"></div>
@else

<div class="alert alert-info alert-styled-left" role="alert">
    {{ __('Sorry! No data found to display') }}
</div>

@endif
<!-- .card -->
@push('scripts')
<script>
    var isShowCheckbox = '{{ $showCheckbox }}';
    // Passing selected organogram to js file
    var selectedId = <?php echo json_encode($selectedId); ?>;
</script>
<script src="{{ asset('js/libs/treeview.min.js') }}"></script>
<script src="{{ asset('js/libs/jstree.min.js') }}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script> --}}
<script src="{{ asset('js/pages/organogram.js') }}"></script>
@endpush