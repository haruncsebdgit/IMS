<form action="{{ route('search') }}" method="GET" class="search-form d-print-none">

	<div class="search-form-group position-relative">

		<input type="search" name="q" class="search-field" placeholder="{!! __('Type and hit &lsquo;Enter&rsquo; to search') !!}" autocomplete="off" value="{{ Request::input('q') }}" required>

		<button type="submit" class="btn-search position-absolute">
			<i class="icon-search4" aria-hidden="true"></i> <span class="sr-only">{{ __('Search') }}</span>
		</button>
	</div>

</form>
