@extends($activeTemplate . 'layouts.master_with_menu')
@section('content')
    @php
        $kycContent = getContent('kyc.content', true);
        $walletImage = fileManager()->crypto();
        $profileImage = fileManager()->userProfile();
    @endphp
    <div class="row gy-4">
        @if ($user->kv == 0)
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    <h4 class="alert-heading">@lang('KYC Verification Required')</h4>
                    <hr>
                    <p class="mb-0">
                        {{ __(@$kycContent->data_values->kyc_required) }}
                        <a class="text--base" href="{{ route('user.kyc.form') }}">@lang('Click Here to Verify')</a>
                    </p>
                </div>
            </div>
        @elseif($user->kv == 2)
            <div class="col-12">
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">@lang('KYC Verification Pending')</h4>
                    <hr>
                    <p class="mb-0">
                        {{ __(@$kycContent->data_values->kyc_pending) }}
                        <a class="text--base" href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a>
                    </p>
                </div>
            </div>
        @endif
        <!--     <div class="col-xl-12 col-lg-12 col-md-12">
                            <h5 class="title">@lang('Referral Link')</h5>
                            <div class="input-group">
                                <input class="form-control form--control bg-white" id="key" name="key" readonly=""
                                    type="text" value="{{ route('user.register', [auth()->user()->username]) }}">
                                <button class="input-group-text bg--base-two text-white border-0 copyBtn" id="copyBoard">
                                    <i class="lar la-copy"></i>
                                </button>
                            </div>
                        </div>  -->

        @foreach ($wallets as $wallet)
            <div class="col-xl-4 col-md-6 col-sm-12 d-widget-item">
                <a class="d-block" href="{{ route('user.transaction.index') }}?crypto={{ $wallet->cryptoId }}">
                    <div class="d-widget">
                        <div class="d-widget__icon">
                            <img src="{{ getImage($walletImage->path . '/' . $wallet->cryptoImage, $walletImage->size) }}">
                        </div>
                        <div class="d-widget__content">
                          
                            <h2 class="d-widget__amount">{{ showAmount($wallet->balance, 2) }}  <small class="d-widget__caption">{{ __($wallet->cryptoCode) }} </small></h2>
                            <h6 class="d-widget__usd text--base">
                                @lang('In USD') <i class="las la-arrow-right"></i>
                                {{ showAmount($wallet->balanceInUsd) }}
                            </h6>
                         <!--    <a class="d-block" href="{{ route('user.mining.history') }}">   <h6>Mining Balance</h6>  </a>
                         
                            <h5 class="d-widget__amount">{{ showAmount(auth()->user()->mining_balance, 2) }}  <small class="d-widget__caption">{{ __($wallet->cryptoCode) }} </small></h5> -->
                        </div>
                    </div>
                </a>
            </div>
           
        @endforeach
    </div>
    <div class="container1">
       <div class="row">
    <div class="col-3">
        <a class="" href="https://bgtmining.bitcoingoldtrading.com/ads/buy/BGT/all">
            <i class="fas fa-money-bill pay1"></i>
            <p>Buy</p>
        </a>
    </div>
    <div class="col-3">
        <a class="" href="https://bgtmining.bitcoingoldtrading.com/ads/buy/BGT/all">
            <i class="fas fa-exchange-alt pay1"></i>
            <p>P2P</p>
        </a>
    </div>
    <div class="col-3">
        <a class="" href="https://bgtmining.bitcoingoldtrading.com/user/transactions">
            <i class="fas fa-credit-card pay1"></i>
            <p>History</p>
        </a>
    </div>
    <div class="col-3">
        <a class="" href="https://bgtmining.bitcoingoldtrading.com/ads/sell/BGT/all/all/all/">
            <i class="fas fa-hand-holding-usd pay1"></i>
            <p>Sell</p>
        </a>
    </div>
</div>

    </div>


    <h4 class="mt-4">@lang('Latest P2P Ads')</h4>
    @include($activeTemplate . 'partials.user_ads_table')
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.copyBtn').on('click', function() {
                var copyText = document.getElementById("key");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");

                iziToast.success({
                    message: "Copied: " + copyText.value,
                    position: "topRight"
                });
            });
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .d-widget__usd {
            font-size: 15px;
            margin-top: 5px;
        }
/* Targeting the <a> tags specifically */
.row a {
    color: black; /* Set link color to black */
    text-decoration: none; /* Remove underline from links */
}



        .pay1 {
            margin-top: 15px;
            padding-top: 10px;
            background-color: orange;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            text-align: center;
            color: white;
        }

        .container1 {
            text-align: center;
            padding: 5px;
        }

        .container {
            text-align: right;
        }
    </style>
@endpush
