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
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Plan')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($records  as $history)
                                    <tr>
                                        <td>{{ $history->amount }}</td>
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
                        <button type="submit" class="btn btn-primary">Transfer Now</button>
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
