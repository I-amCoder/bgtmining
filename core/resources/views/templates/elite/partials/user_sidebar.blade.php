<div class="sidebar-menu">
    <span class="sidebar-menu__close d-lg-none d-block"><i class="las la-times"></i></span>
    <ul class="sidebar-menu-list">
        <li class="sidebar-menu-list__item {{ menuActive('user.home') }}">
            <a class="sidebar-menu-list__link" href="{{ route('user.home') }}">
                <span class="icon"><i class="las la-home"></i></span>
                <span class="text">@lang('Dashboard')</span>
            </a>
        </li>
        <li class="sidebar-menu-list__item {{ menuActive('user.mining.show') }}">
            <a class="sidebar-menu-list__link" href="{{ route('user.mining.show') }}">
                <span class="icon"><i class="lab la-bitcoin"></i></span>
                <span class="text">@lang('Mining')</span>
            </a>
        </li>
        <li class="sidebar-menu-list__item {{ menuActive('user.mining.history') }}">
            <a class="sidebar-menu-list__link" href="{{ route('user.mining.history') }}">
                <span class="icon"><i class="lab la-bitcoin"></i></span>
                <span class="text">@lang('Mining History')</span>
            </a>
        </li>
         <li class="sidebar-menu-list__item {{ menuActive('user.mining.history') }}">
            <a class="sidebar-menu-list__link" href="https://bgtmining.bitcoingoldtrading.com/faq">
                <span class="icon"><i class="far fa-question-circle"></i></span>
                <span class="text">FAQ's</span>
            </a>
        </li>
         <li class="sidebar-menu-list__item {{ menuActive('user.profile.setting') }}">
            <a class="sidebar-menu-list__link" href="https://bgtmining.bitcoingoldtrading.com/contact">
                <span class="icon"><i class="far fa-comments"></i></span>
                <span class="text">Chat</span>
            </a>
        </li>
        <li class="sidebar-menu-list__item {{ menuActive('user.profile.setting') }}">
            <a class="sidebar-menu-list__link" href="{{ route('user.profile.setting') }}">
                <span class="icon"><i class="las la-user-cog"></i></span>
                <span class="text">Account Setting</span>
            </a>
        </li>
        <li class="sidebar-menu-list__item {{ menuActive('user.referral.users') }}">
            <a class="sidebar-menu-list__link" href="{{ route('user.referral.users') }}">
                <span class="icon"><i class="las la-tree"></i></span>
                <span class="text">Referral</span>
            </a>
        </li>
        <li class="sidebar-menu-list__item {{ menuActive('user.advertisement.index') }}">
            <a class="sidebar-menu-list__link" href="{{ route('user.advertisement.index') }}">
                <span class="icon"><i class="lab la-adversal"></i></span>
                <span class="text">P2P Exchange Ads</span>
            </a>
        </li>
      <!--  <li class="sidebar-menu-list__item {{ menuActive('user.withdraw.history') }}">
            <a class="sidebar-menu-list__link" href="{{ route('user.withdraw.history') }}">

                <span class="text"><i class="las la-hand-holding-usd"></i> Withdraw History</span>
            </a>
        </li> -->
        <li class="sidebar-menu-list__item {{ menuActive('user.deposit.history') }}">
            <a class="sidebar-menu-list__link" href="{{ route('user.deposit.history') }}">

                <span class="text"><i class="las la-wallet"></i> Deposits History</span>
            </a>
        </li>
        <li class="sidebar-menu-list__item {{ menuActive('user.transaction.index') }}">
            <a class="sidebar-menu-list__link" href="{{ route('user.transaction.index') }}">
                <span class="icon"><i class="las la-money-bill"></i></span>
                <span class="text">Transactions</span>
            </a>
        </li>
        <li class="sidebar-menu-list__item {{ menuActive('ticket.index') }}">
            <a class="sidebar-menu-list__link" href="{{ route('ticket.index') }}">
                <span class="icon"><i class="la la-ticket-alt"></i></span>
                <span class="text">Support Portal</span>
            </a>
        </li>
         <li class="sidebar-menu-list__item {{ menuActive('ticket.index') }}">
            <a class="sidebar-menu-list__link" href="https://bitcoingoldtrading.com/BGT%20Mining.pdf">
                <span class="icon"><i class="far fa-file-pdf"></i></span>
                <span class="text">Download PDF</span>
            </a>
        </li>
        <li class="sidebar-menu-list__item {{ menuActive('user.twofactor') }}">
            <a class="sidebar-menu-list__link" href="{{ route('user.twofactor') }}">
                <span class="icon"><i class="las la-lock"></i></span>
                <span class="text">2FA Security</span>
            </a>
        </li>
        <li class="sidebar-menu-list__item {{ menuActive('user.change.password') }}">
            <a class="sidebar-menu-list__link" href="{{ route('user.change.password') }}">

                <span class="text"><i class="la la-key"></i> Change Password</span>
            </a>
        </li>
        <li class="sidebar-menu-list__item">
            <a class="sidebar-menu-list__link" href="{{ route('user.logout') }}">
                <span class="icon"><i class="la la-sign-out-alt"></i></span>
                <span class="text">Logout </span>
            </a>
        </li>
    </ul>
</div>
@php
 $content = getContent('banner.content', true);
@endphp
@push('style')
    <style>
    
body {
    margin: 0; /* Remove default margin */
    padding: 0; /* Optionally, remove default padding */
    background-image: url('{{ getImage('assets/images/frontend/banner/' . @$content->data_values->image, '515x295') }}');
    background-size: cover; /* Adjust as needed */
    background-position: center; /* Adjust as needed */
    /* Other styles for the body */
}



     
    </style>
@endpush
