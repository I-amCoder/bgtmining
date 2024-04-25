@extends($activeTemplate . 'layouts.master_without_menu')
@section('content')

    @if (blank($advertisements))
        <x-no-data message="No advertisement added yet" />
        <div class="text-center">
            <a href="{{ route('user.advertisement.new') }}" class="btn btn--success"><i class="las la-plus"></i> @lang('Create Ad')</a>
        </div>
    @else
        @include($activeTemplate . 'partials.user_ads_table')

        @if ($advertisements->hasPages())
            {{ $advertisements->links() }}
        @endif

    @endif
    <x-user-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <a class="ptable-header-right__link" href="{{ route('user.advertisement.new') }}">
       
        <span class="btn btn--success"><i class="las la-plus"></i> @lang('New Ad')</span>
    </a>
@endpush
