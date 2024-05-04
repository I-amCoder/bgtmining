@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Username')</th>
                                    <th>@lang('Email')</th>
                                    <th>@lang('Plan')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Proof')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($deposits  as $deposit)
                                    <tr>
                                        <td>{{ $deposit->user->username }}</td>
                                        <td>{{ $deposit->user->email }}</td>
                                        <td>{{ $deposit->plan->plan_name }}</td>
                                        <td>{{ $deposit->amount }}</td>
                                        <td>
                                            <button data-path="{{ '/assets/images/payment_slips' . '/' . $deposit->proof }}"
                                                class="btn btn-sm btn-info viewProof">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </td>
                                        <td>{{ $deposit->status }}</td>
                                        <td>
                                            @if ($deposit->status == 'Pending')
                                                <button data-action="Approve"
                                                    data-href="{{ route('admin.plan_deposit.approve', $deposit->id) }}"
                                                    class="btn btn-outline-success btn-sm deposit-action"><i
                                                        class="fa fa-check"></i></button>

                                                <button data-action="Reject"
                                                    data-href="{{ route('admin.plan_deposit.reject', $deposit->id) }}"
                                                    class="btn btn-outline-danger btn-sm deposit-action"><i
                                                        class="fa fa-trash"></i></button>
                                            @else
                                                <span class="text-muted">No Actions</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100">Currently you don't have any deposits</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="depositActionModal" tabindex="-1" aria-labelledby="depositActionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="depositActionModalLabel">Delete Plan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Are you sure to <span class="action"></span> this plan</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary "><span class="action text-light"></span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="depositProofModal" tabindex="-1" aria-labelledby="depositProofModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="depositProofModalLabel">Payment Proof</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <img style="width: 100%" alt="Proof">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(".deposit-action").click(function(e) {
            e.preventDefault();
            let modal = $("#depositActionModal");
            modal.find('form').attr('action', $(this).data('href'));
            modal.find('.action').text($(this).data('action'));
            modal.modal('show');
        });

        $(".viewProof").click(function(e) {
            e.preventDefault();
            let modal = $("#depositProofModal");
            modal.find('img').attr('src', $(this).data('path'));
            modal.modal('show');
        })
    </script>
@endpush
