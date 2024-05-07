@php
    $cryptos = App\Models\CryptoCurrency::active()
        ->orderBy('name')
        ->get();
    $pages = App\Models\Page::where('tempname', $activeTemplate)
        ->where('is_default', Status::NO)
        ->get();

    $user = auth()->user();

    if ($general->multi_language) {
        $language  = App\Models\Language::all();
        $localLang = $language->where('code', config('app.locale'))->first();
    }
@endphp


<header class="header" id="header">
    <div class="container">
        <nav class="navbar navbar-expand-xl navbar-light">
            <a class="navbar-brand logo" href="https://bgtmining.bitcoingoldtrading.com/user/dashboard"><img alt=""
                    src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}"></a>
           

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav nav-menu  align-items-xl-center">
                    <li class="nav-item dropdown d-block d-xl-none">
                        <div class="header-right d-flex justify-content-end">

                            <!-- Account -->
                            <a class="header-right__button account" href="javascript:void(0)">
                                <i class="las la-user"></i>
                            </a>
                            @if ($general->multi_language)
                                <div class="language-wrapper">
                                    <div class="header-right__button language">
                                        <img src="{{ getImage(getFilePath('language') . '/' . @$localLang->flag, getFileSize('language')) }}">
                                    </div>
                                    <ul class="language-list">
                                        @foreach ($language as $lang)
                                            <li class="language-list__item">
                                                <a class="language-list__link" href="{{ route('lang', $lang->code) }}">
                                                    <span class="thumb">
                                                        <img src="{{ getImage(getFilePath('language') . '/' . @$lang->flag, getFileSize('language')) }}">
                                                    </span>
                                                    <span class="text">{{ __($lang->name) }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </li>

                    <li class="nav-item">
                        <a aria-current="page" class="nav-link" href="{{ route('home') }}">@lang('Home')</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a aria-expanded="false" class="nav-link" data-bs-toggle="dropdown" href="#" role="button">
                            @lang('Buy') <span class="nav-item__icon"><i class="fas fa-caret-down"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            @foreach ($cryptos as $crypto)
                                <li class="dropdown-menu__list">
                                    <a class="dropdown-item dropdown-menu__link" href="{{ route('advertisement.all', ['buy', $crypto->code, 'all']) }}">{{ $crypto->code }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a aria-expanded="false" class="nav-link" data-bs-toggle="dropdown" href="#"
                            role="button">@lang('Sell')<span class="nav-item__icon"><i
                                    class="fas fa-caret-down"></i></span></a>
                        <ul class="dropdown-menu">
                            @foreach ($cryptos as $crypto)
                                <li class="dropdown-menu__list">
                                    <a class="dropdown-item dropdown-menu__link" href="{{ route('advertisement.all', ['sell', $crypto->code, 'all']) }}">{{ $crypto->code }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    @if ($user)
                        <li class="nav-item dropdown">
                            <a aria-expanded="false" class="nav-link" data-bs-toggle="dropdown" href="#"
                                role="button">@lang('Trades')<span class="nav-item__icon"><i
                                        class="fas fa-caret-down"></i></span></a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-menu__list">
                                    <a class="dropdown-item dropdown-menu__link" href="{{ route('user.trade.request.running') }}">@lang('Running')</a>
                                </li>
                                <li class="dropdown-menu__list">
                                    <a class="dropdown-item dropdown-menu__link" href="{{ route('user.trade.request.completed') }}">@lang('Completed')</a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @foreach ($pages as $k => $data)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pages', [$data->slug]) }}">{{ __($data->name) }}</a>
                        </li>
                    @endforeach

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">@lang('Contact')</a>
                    </li>
                </ul>
            </div>
            <div class="header-right ms-auto flex-between d-none d-xl-flex">
                @if ($user)
                    @php
                        $wallets = \App\Models\Wallet::where('user_id', auth()->id())
                            ->with('crypto:id,name,code')
                            ->get();
                    @endphp
                    <div class="wallet-wrapper">
                        <div class="wallet">
                            <span class="thumb">
                                <img src="{{ getImage($activeTemplateTrue . 'images/wallet.png') }}"></span>
                            <span class="text">@lang('Wallets')</span>
                        </div>
                        <ul class="wallet-list">
                            <li class="wallet-list__item"><a class="wallet-list__link"
                                    href="{{ route('user.wallets') }}">@lang('All')</a></li>
                            @foreach ($wallets as $wallet)
                                <li class="wallet-list__item">
                                    <a class="wallet-list__link" href="{{ route('user.wallets.single', [$wallet->crypto->id, $wallet->crypto->code]) }}">{{ __($wallet->crypto->name) }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- Account -->
                <div class="account-wrapper">
                    <button class="header-right__button account">
                        <i class="las la-user"></i>
                    </button>
                    <div class="account-popup @if ($user) authenticated @endif">
                        @if ($user)
                            <div class="account-header">
                                <h5 class="text-white">{{ __($user->fullname) }}</h5>
                                <span class="badge badge--warning"><i class="fas fa-check-circle"></i>
                                    {{ $user->status == Status::ENABLE ? __('Verified') : __('Unverified') }}
                                </span>
                                <span class="badge badge--secondary">
                                    <i class="fas fa-globe"></i> {{ @$user->address->country }}
                                </span>
                            </div>
                        @endif
                        <ul class="account-list">
                            @if ($user)
                                <li class="account-list__item">
                                    <a class="account-list__link" href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                </li>
                                <li class="account-list__item">
                                    <a class="account-list__link"  href="{{ route('user.profile.setting') }}">@lang('Account Setting')</a>
                                </li>
                                <li class="account-list__item">
                                    <a class="account-list__link" href="{{ route('user.twofactor') }}">@lang('2FA Security')</a>
                                </li>
                                <li class="account-list__item">
                                    <a class="account-list__link"  href="{{ route('user.change.password') }}">@lang('Change Password')</a>
                                </li>
                                <li class="account-list__item">
                                    <a class="account-list__link" href="{{ route('user.advertisement.index') }}">@lang('Advertisements')</a>
                                </li>
                                <li class="account-list__item">
                                    <a class="account-list__link" href="{{ route('user.transaction.index') }}">@lang('Transactions')</a>
                                </li>
                                <li class="account-list__item">
                                    <a class="account-list__link" href="{{ route('user.withdraw.history') }}">@lang('Withdrawals')</a>
                                </li>
                                <li class="account-list__item">
                                    <a class="account-list__link" href="{{ route('user.deposit.history') }}">@lang('Deposits')</a>
                                </li>
                                <li class="account-list__item">
                                    <a class="account-list__link" href="{{ route('ticket.index') }}">@lang('Support Tickets')</a>
                                </li>
                            @else
                                <li class="account-list__item">
                                    <a class="account-list__link" href="{{ route('user.login') }}">@lang('Login')</a>
                                </li>
                                <li class="account-list__item">
                                    <a class="account-list__link" href="{{ route('user.register') }}">@lang('Register')</a>
                                </li>
                            @endif
                        </ul>

                        @if ($user)
                            <a class="logout-btn" href="{{ route('user.logout') }}">@lang('Logout')</a>
                        @endif
                    </div>
                </div>

                @if ($general->multi_language)
                    <div class="language-wrapper">
                        <div class="header-right__button language">
                            <img src="{{ getImage(getFilePath('language') . '/' . @$localLang->flag, getFileSize('language')) }}">
                        </div>
                        <ul class="language-list">
                            @foreach ($language as $lang)
                                <li class="language-list__item">
                                    <a class="language-list__link" href="{{ route('lang', $lang->code) }}">
                                        <span class="thumb">
                                            <img src="{{ getImage(getFilePath('language') . '/' . @$lang->flag, getFileSize('language')) }}">
                                        </span>
                                        <span class="text">{{ __($lang->name) }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </nav>
    </div>
</header>
 <nav class="nav1">
<a href="{{ route('user.home') }}" class="nav-link1">
<i class="las la-wallet fa-2x"></i> 
<span class="nav-text">Wallet</span>
</a>

<a href="https://bgtmining.bitcoingoldtrading.com/user/coin-mining" class="nav-link1">
<i class="las la-bolt fa-2x"></i> 
<span class="nav-text">Mining</span>
</a>
<a href="https://bgtmining.bitcoingoldtrading.com/ads/buy/BGT/all" class="nav-link1">
<i class="fas fa-exchange-alt fa-3x"></i>

<span class="nav-text">P2P</span>
</a>
<a href="https://bgtmining.bitcoingoldtrading.com/user/referred/users" class="nav-link1">
<i class="las la-users fa-2x"></i>

<span class="nav-text" >Team</span>
</a>
<a href="https://bgtmining.bitcoingoldtrading.com/user/coin-mining/history" class="nav-link1">
<i class="las la-chart-bar fa-2x"></i>

<span class="nav-text" >Insights</span>
</a>

</nav>

  <style>



.nav1 {
    color:black;
position: fixed;
bottom: 0;
width: 100%;
height: 55px;
box-shadow: @ @ 3px rgbo(0, 0, 0, 0.2) ;
background-color: #FCA122;
overflow-x: auto;
display: flex;
  z-index: 99;
  display:flex;
  justify-content: center;
  align-items: center;
  flex-direction: row;
}

.nav-link1 {
display: flex;
flex-direction: column;
align-items: center;
justify-content: center;
flex-grow: 1;
min-width: 40px;
overflow: hidden;
white-space: nowrap;
font-family: sans-serif;

font-size: 14px;
color: #ffffff;


}
.nav-link1:hover {
color: #000000;
}
.nav-link1:active{
color: #000000;
}
.nav-icont{
font-size: 18px;
}
 @media  screen and (min-width: 600px) {
  .nav1 {
  display: none ;
}
section.banner-section.bg_img.overflow-hidden.mb-0 {
  padding-top: 150px;

}
div.banner-thumb.ps-xl-5.ps-lg-4.d-lg-block.d-none {
  margin-top: -140px;
}
}
 @media  screen and (min-width: 350px) {
  .nav-link1 {
  font-size: 12px;
  padding: 0px;
  

}
}
    .menu1 {
  list-style-type: none;
  margin: 5px;
  padding: 1px;
}

.menu1 li {
  display: inline-block;
  margin-right: 8px;
}

.menu1 li a {
  display: block;
  padding: 1px;
  text-decoration: none;
  color: #002a47;
 
}

.menu1 li a:hover {
    color: #1dbf73;
}


}


   </style>