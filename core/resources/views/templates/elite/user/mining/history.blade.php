@extends($activeTemplate . 'layouts.master_with_menu')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card b-radius--10 ">
                <div class="card-header">
                    <p>Mining Balance: {{ auth()->user()->mining_balance }}</p>
                    <button class="btn btn-dark transferBalance">Transfer to main wallet</button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Earn')</th>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Plan')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($records  as $history)
                                    <tr>
                                        <td>{{ $history->amount }} BGT</td>
                                        <td>{{ $history->created_at->format('H:i - d M, Y') }}</td>
                                        <td>{{ $history->plan->plan_name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100">Currently you don't have any plans</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
     <div class="row">
        <div class="col-lg-12">
            <form action="" class="ptable-filter align-items-end" id="searchForm" method="GET">
                <div class="d-flex gap-3 flex-wrap align-items-end justify-content-center">
                    <div class="flex-fill">
                        <div class="form-group">
                            <label class="form--label">@lang('TRX No.')</label>
                            <input class="form-control form--control" name="search" placeholder="@lang('Transaction No.')" type="text" value="{{ request()->search }}">
                        </div>
                    </div>
                    <div class="flex-fill">
                        <div class="form-group">
                            <label class="form--label">@lang('Type')</label>
                            <select class="select form--control" name="type">
                                <option value="">@lang('All')</option>
                                <option @selected(request()->type == '+') value="+">@lang('Plus')</option>
                                <option @selected(request()->type == '-') value="-">@lang('Minus')</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex-fill">
                        <div class="form-group">
                            <label class="form--label">@lang('Crypto currency')</label>
                            <select class="select form--control" name="crypto">
                                <option value="">@lang('All')</option>
                                @foreach ($cryptos as $cryptoData)
                                    <option @selected(request()->crypto == $cryptoData->id) value="{{ $cryptoData->id }}">{{ __($cryptoData->code) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex-fill">
                        <div class="form-group">
                            <label class="form--label">@lang('Remark')</label>
                            <select class="select form--control" name="remark">
                                <option value="">@lang('Any')</option>
                                @foreach ($remarks as $remark)
                                    <option @selected(request()->remark == $remark->remark) value="{{ $remark->remark }}">{{ __(keyToTitle($remark->remark)) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex-fill">
                        <button class="btn btn--base" type="submit"><i class="las la-filter"></i> @lang('Filter')</button>
                        <a class="btn btn--light clearBtn" href="{{ route('user.transaction.index') }}"><i class="las la-undo-alt"></i> @lang('Reset')</a>
                    </div>
            </form>
        </div>
        @if (blank($transactions))
            <div class="col-12">
                <x-no-data message="No transaction found"></x-no-data>
            </div>
        @else
            <div class="col-lg-12">
                <div class="table-acordion-wrapper mt-4">
                    <div class="accordion table--acordion" id="transactionAccordion">
                        @foreach ($transactions as $transaction)
                            <div class="accordion-item transaction-item">
                                <h2 class="accordion-header" id="h-{{ $transaction->id }}">
                                    <button class="accordion-button collapsed" data-bs-target="#id-{{ $transaction->id }}" data-bs-toggle="collapse" type="button">
                                        <div class="col-lg-4 col-sm-5 col-8 order-1 icon-wrapper">
                                            <div class="left">
                                                <div class="icon tr-icon icon-success ">
                                                    @if ($transaction->trx_type == '+')
                                                    <i class="las la-long-arrow-alt-right"></i>
                                                    @else
                                                    <i class="las la-long-arrow-alt-left"></i>
                                                    @endif
                                                </div>
                                                <div class="content">
                                                    <h6 class="trans-title">{{ __($transaction->crypto->code) }}</h6>
                                                    <span class="time text-muted mt-2">{{ showDateTime($transaction->created_at, 'M d Y @g:i:sa') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-4 col-12 order-sm-2 order-3 content-wrapper">
                                            <p class="trx-no text-muted"><b>#{{ $transaction->trx }}</b></p>
                                        </div>
                                        <div class="col-lg-4 col-sm-3 col-4 order-sm-3 order-2 text-end amount-wrapper">
                                            <p class="btc">
                                                <b>{{ showAmount($transaction->amount, 8) }} {{ __($transaction->crypto->code) }}</b><br>
                                                <small class="fw-bold text-muted">{{ showAmount($transaction->post_balance, 8) }} {{ __($transaction->crypto->code) }}</small>
                                            </p>

                                        </div>
                                    </button>
                                </h2>
                                <div aria-labelledby="h-{{ $transaction->id }}" class="accordion-collapse collapse" data-bs-parent="#transactionAccordion" id="id-{{ $transaction->id }}">
                                    <div class="accordion-body">
                                        <ul class="caption-list">
                                            <li>
                                                <span class="caption">@lang('Charge')</span>
                                                <span class="value">{{ showAmount($transaction->charge, 8) }} {{ __($transaction->crypto->code) }}</span>
                                            </li>
                                            <li>
                                                <span class="caption">@lang('Post Balance')</span>
                                                <span class="value">{{ showAmount($transaction->post_balance, 8) }} {{ __($transaction->crypto->code) }}</span>
                                            </li>
                                            <li>
                                                <span class="caption">@lang('Details')</span>
                                                <span class="value">{{ __($transaction->details) }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if ($transactions->hasPages())
                    {{ $transactions->links() }}
                @endif
            </div>
        @endif
    </div>

    <div class="modal fade" id="transferModal" tabindex="-1" aria-labelledby="transferModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transferModalLabel">Transfer Balance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('user.mining.transfer') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="amount">Enter BGT</label>
                            <input type="number" step="any" class="form-control" name="amount" id="amount">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Transfer Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
@endsection
@push('script')
    <script>
        $(".transferBalance").click(function(e) {
            e.preventDefault();
            let modal = $("#transferModal");
            modal.modal('show');
        });
    </script>
@endpush
