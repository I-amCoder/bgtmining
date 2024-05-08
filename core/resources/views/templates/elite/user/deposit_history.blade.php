@extends($activeTemplate . 'layouts.master_with_menu')
@section('content')
    <div class="row gy-4">
       
            <div class="col-lg-12">
                <div class="ptable-wrapper">
                    <table class="table table--responsive--lg">
                        <thead>
                            <tr>
                                <th>@lang('User name')</th>
                                <th>@lang('Eamil')</th>
                                <th>@lang('MINING PLAN')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Status')</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                           @forelse ($deposits  as $deposit)
                             
                                
                                    <tr>
                                        <td>{{ $deposit->user->username }}</td>
                                        <td>{{ $deposit->user->email }}</td>
                                        <td>{{ $deposit->plan->plan_name }}</td>
                                        <td>{{ $deposit->amount }}</td>
                                       
                                        <td>{{ $deposit->status }}</td>
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
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.approveBtn').on('click', function() {

                var modal = $('#approveModal');
                modal.find('.withdraw-amount').text($(this).data('amount'));
                modal.find('.withdraw-charge').text($(this).data('charge'));
                modal.find('.withdraw-after_charge').text($(this).data('after_charge'));
                modal.find('.withdraw-payable').text($(this).data('payable'));

                modal.modal('show');
            });

        })(jQuery);
    </script>
@endpush
