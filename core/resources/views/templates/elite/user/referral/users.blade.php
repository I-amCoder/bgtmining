@extends($activeTemplate . 'layouts.master_with_menu')
@section('content')
<div class="col-xl-12 col-lg-12 col-md-12 container1">
            <h5 class="title">@lang('Referral Link')</h5>
            <div class="input-group">
                <input class="form-control form--control bg-white" id="key" name="key" readonly=""
                    type="text" value="{{ route('user.register', [auth()->user()->username]) }}">
                <button class="input-group-text bg--base-two text-white border-0 copyBtn" id="copyBoard">
                    <i class="lar la-copy"></i>
                </button>
            </div>
        </div>
    @if ($user->refBy)
        <div class="d-flex flex-wrap justify-content-center container1">
            <h5><span class="mb-2">@lang('You are referred by')</span> <span><a class="text--base" href="{{ route('public.profile', $user->refBy->username) }}">{{ $user->refBy->username }}</a></span></h5>
        </div>
    @endif

    @if ($user->allReferrals->count() > 0 && $maxLevel > 0)
        <div class="treeview-container">
            <ul class="treeview">
                <li class="items-expanded"> {{ $user->username }}
                    @include($activeTemplate . 'partials.under_tree', ['user' => $user, 'layer' => 0, 'isFirst' => true])
                </li>
            </ul>
        </div>
    @else
        <x-no-data message="No user found"></x-no-data>
    @endif
@endsection

@if (request()->routeIs('user.referral.users'))
    @push('breadcrumb-plugins')
        <a class="ptable-header-right__link" href="{{ route('user.referral.commissions.trade') }}">
            <span class="icon"><i class="las la-wallet"></i></span>
            <span class="text">@lang('Commissions')</span>
        </a>
    @endpush
@endif

@push('style-lib')
    <link href="{{ asset($activeTemplateTrue . 'css/treeView.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/treeView.js') }}"></script>
@endpush

@push('script')
    <script>
     $(document).ready(function() {
        // Function to copy text to clipboard
        function copyToClipboard(text) {
            var input = document.createElement("textarea");
            input.value = text;
            document.body.appendChild(input);
            input.select();
            document.execCommand("copy");
            document.body.removeChild(input);
        }

        // When the copy button is clicked
        $("#copyBoard").click(function() {
            var textToCopy = $("#key").val();
            copyToClipboard(textToCopy);
            alert("Copied to clipboard!");
        });
    });
        (function($) {
            "use strict"
            $('.treeview').treeView();
        })(jQuery);
    </script>
@endpush
