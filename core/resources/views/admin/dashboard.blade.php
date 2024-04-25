@extends('admin.layouts.app')

@php
    $walletImage = fileManager()->crypto();
@endphp

@section('panel')
    @if (@json_decode($general->system_info)->version > systemDetails()['version'])
        <div class="row">
            <div class="col-md-12">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">
                        <h3 class="card-title"> @lang('New Version Available') <button class="btn btn--dark float-end">@lang('Version') {{ json_decode($general->system_info)->version }}</button> </h3>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-dark">@lang('What is the Update?')</h5>
                        <p>
                            <pre class="f-size--24">{{ json_decode($general->system_info)->details }}</pre>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (@json_decode($general->system_info)->message)
        <div class="row">
            @foreach (json_decode($general->system_info)->message as $msg)
                <div class="col-md-12">
                    <div class="alert border border--primary" role="alert">
                        <div class="alert__icon bg--primary">
                            <i class="far fa-bell"></i>
                            <p class="alert__message">@php echo $msg; @endphp</p>
                            <button aria-label="Close" class="close" data-bs-dismiss="alert" type="button">
                                <span aria-hidden="true">×</span></button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @php
        $fiatCondition = Carbon\Carbon::parse($general->fiat_cron)->diffInSeconds() >= 900;
        $cryptoCondition = Carbon\Carbon::parse($general->crypto_cron)->diffInSeconds() >= 900;
    @endphp


    <div class="row gy-4">
        <div class="col-xxl-3 col-sm-6">
            <x-widget bg="primary" icon="las la-users f-size--56" link="{{ route('admin.users.all') }}" title="Total Users" value="{{ $widget['totalUsers'] }}" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget bg="success" icon="las la-user-check f-size--56" link="{{ route('admin.users.active') }}" title="Active Users" value="{{ $widget['activeUsers'] }}" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget bg="danger" icon="lar la-envelope f-size--56" link="{{ route('admin.users.email.unverified') }}" title="Email Unverified Users" value="{{ $widget['emailUnverifiedUsers'] }}" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget bg="red" icon="las la-comment-slash f-size--56" link="{{ route('admin.users.mobile.unverified') }}" title="Mobile Unverified Users" value="{{ $widget['mobileUnverifiedUsers'] }}" />
        </div>
    </div><!-- row end-->

    <div class="row gy-4 mt-2">
        <div class="col-xxl-3 col-sm-6">
            <x-widget bg="primary" icon="lar la-credit-card" link="{{ route('admin.withdraw.log') }}" style="3" title="Approved Withdrawal" value="{{ __($widget['totalWithdrawApproved']) }}" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget bg="warning" icon="las la-sync" link="{{ route('admin.withdraw.pending') }}" style="3" title="Pending Withdrawals" value="{{ __($widget['totalWithdrawPending']) }}" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget bg="red" icon="las la-times-circle" link="{{ route('admin.withdraw.rejected') }}" style="3" title="Rejected Withdrawals" value="{{ __($widget['totalWithdrawRejected']) }}" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget bg="19" icon="la la-bank" link="{{ route('admin.withdraw.log') }}" style="3" title="Total Withdrawals" value="{{ __($widget['totalWithdraw']) }}" />
        </div>
    </div><!-- row end-->

    <div class="row gy-4 mt-2">
        <div class="col-md-12">
            <h4>@lang('Deposit Summary')</h4>
        </div>
    </div>

    <div class="row gy-4 mt-2">
        @foreach ($deposits as $deposit)
            <div class="col-xxl-3 col-sm-6">
                <div class="widget-two box--shadow2 b-radius--5 bg--white">
                    <div class="widget-two__icon b-radius--5 text--success">
                        <img alt="image" src="{{ getImage($walletImage->path . '/' . $deposit->image, $walletImage->size) }}">
                    </div>
                    <div class="widget-two__content">
                        <h3>{{ showAmount($deposit->deposits_sum_amount, 8) }} {{ __($deposit->code) }}</h3>
                        <span>@lang('Charge')</span>
                        <i class="fas fa-arrow-right text--danger"></i>
                        <span class="text--danger">{{ showAmount($deposit->deposits_sum_charge, 8) }} {{ __($deposit->code) }}</span>
                    </div>
                    <a class="widget-two__btn border border--success btn-outline--success" href="{{ route('admin.deposit.list') }}">@lang('View All')</a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row gy-4 mt-2">
        <div class="col-xxl-3 col-sm-6">
            <x-widget bg="19" icon="lab la-adversal" link="{{ route('admin.ad.index') }}" style="3" title="Total Adveretisements" value="{{ __($widget['totalAd']) }}" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget bg="primary" icon="las la-exchange-alt" link="{{ route('admin.trade.index') }}" style="3" title="Total Trades" value="{{ __($widget['totalTrade']) }}" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget bg="1" icon="lab la-bitcoin" link="{{ route('admin.crypto.index') }}" style="3" title="Total Cryptocurrency" value="{{ __($widget['totalCrypto']) }}" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget bg="success" icon="las la-coins" link="{{ route('admin.fiat.currency.index') }}" style="3" title="Total Fiat Currency" value="{{ __($widget['totalFiat']) }}" />
        </div>
    </div><!-- row end-->

    <div class="row gy-4 mt-2">
        <div class="col-md-12">
            <h4>@lang('Withdrawal Summary')</h4>
        </div>
    </div>

    <div class="row gy-4 mt-2">
        @foreach ($withdrawals as $withdrawal)
            <div class="col-xxl-3 col-sm-6">
                <div class="widget-two box--shadow2 b-radius--5 bg--white">
                    <div class="widget-two__icon b-radius--5 text--success">
                        <img alt="image" src="{{ getImage($walletImage->path . '/' . $withdrawal->image, $walletImage->size) }}">
                    </div>
                    <div class="widget-two__content">
                        <h3>{{ showAmount($withdrawal->withdrawals_sum_amount, 8) }} {{ __($withdrawal->code) }}</h3>
                        <span>@lang('Charge')</span>
                        <i class="fas fa-arrow-right text--danger"></i>
                        <span class="text--danger">{{ showAmount($withdrawal->withdrawals_sum_charge, 8) }} {{ __($withdrawal->code) }}</span>
                    </div>
                    <a class="widget-two__btn border border--success btn-outline--success" href="{{ route('admin.withdraw.log') }}">@lang('View All')</a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row mb-none-30 mt-5">
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Browser') (@lang('Last 30 days'))</h5>
                    <canvas id="userBrowserChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By OS') (@lang('Last 30 days'))</h5>
                    <canvas id="userOsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Country') (@lang('Last 30 days'))</h5>
                    <canvas id="userCountryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Cron Modal --}}
    <div class="modal fade" id="cronModal" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">@lang('Please Set Cron Job Now')</h5>
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group text-center border-bottom mb-4">
                        <div class="text--primary">
                            <i class="las la-info-circle"></i>
                            @lang('Set the Cron time ASAP')
                        </div>
                        <p class="fst-italic">
                            @lang('Once per 5-15 minutes is ideal while once every minute is the best option')
                        </p>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="justify-content-between d-flex flex-wrap">
                                    <div>
                                        <label class="fw-bold">@lang('Cron Command')</label>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <input class="form-control form-control-lg" id="cron" readonly type="text" value="curl -s {{ route('cron') }}">
                                    <button class="input-group-text copytext btn--primary copyCronPath border--primary" data-id="cron" type="button"> @lang('Copy')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $lastCron = Carbon\Carbon::parse($general->last_cron)->diffInSeconds();
    @endphp

    @if ($lastCron >= 900)
        @include('admin.partials.cron_instruction')
    @endif

@endsection

@push('style')
    <style>
        .bg--red-shade {
            background-color: #f3d6d6;
        }
    </style>
@endpush

@push('script')
    <script src="{{ asset('assets/admin/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/chart.js.2.8.0.js') }}"></script>
    <script>
        "use strict";

        @if ($fiatCondition || $cryptoCondition)
            (function($) {
                var cronModal = new bootstrap.Modal(document.getElementById('cronModal'));
                cronModal.show();

                $(document).on('click', '.copyCronPath', function() {
                    var copyText = document.getElementById($(this).data('id'));
                    copyText.select();
                    copyText.setSelectionRange(0, 99999);
                    document.execCommand('copy');
                    notify('success', 'Copied: ' + copyText.value);
                });
            })(jQuery);
        @endif

        $('.copy-address').on('click', function() {
            var clipboard = new ClipboardJS('.copy-address');
            notify('success', 'Copied : ' + $(this).data('clipboard-text'));
        });

        var ctx = document.getElementById('userBrowserChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($chart['user_browser_counter']->keys()),
                datasets: [{
                    data: {{ $chart['user_browser_counter']->flatten() }},
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(231, 80, 90, 0.75)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                maintainAspectRatio: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            }
        });


        var ctx = document.getElementById('userOsChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($chart['user_os_counter']->keys()),
                datasets: [{
                    data: {{ $chart['user_os_counter']->flatten() }},
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(0, 0, 0, 0.05)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            },
        });


        // Donut chart
        var ctx = document.getElementById('userCountryChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($chart['user_country_counter']->keys()),
                datasets: [{
                    data: {{ $chart['user_country_counter']->flatten() }},
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(231, 80, 90, 0.75)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            }
        });
    </script>
@endpush
