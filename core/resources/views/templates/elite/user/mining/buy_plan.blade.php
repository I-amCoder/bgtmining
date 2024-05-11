@extends($activeTemplate . 'layouts.master_with_menu')
@section('content')
    <h4>Buy Plan</h4>
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p>Plan Name: {{ $plan->plan_name }}</p>
                    <p>Plan Amount: ${{ number_format($plan->price, 2) }}</p>
                    <hr>
                    <div class="form-group">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select id="payment_method" class="form-select">
                            <option value>Select Payment Method</option>
                            @if ($jazzcash)
                                <option value="{{ json_encode($jazzcash) }}">USDT TRC-20</option>
                            @endif
                            @if ($easypaisa)
                                <option value="{{ json_encode($easypaisa) }}">Easypaisa</option>
                            @endif
                            @if ($bank)
                                <option value="{{ json_encode($bank) }}">Bank Account</option>
                            @endif
                        </select>
                    </div>
                    <hr>
                    <div id="method_details">

                    </div>

                </div>
            </div>
        </div>
    </div>
     <div class="row gy-4">
       
            <div class="col-lg-12">
                <div class="ptable-wrapper">
                    <table class="table table--responsive--lg">
                        <thead>
                            <tr>
                                <th>@lang('User name')</th>
                              
                                <th>@lang('MINING PLAN')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Status')</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                           @forelse ($deposits  as $deposit)
                             
                                
                                    <tr>
                                        <td>{{ $deposit->user->username }}</td>
                                       
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
        $("#payment_method").change(function(e) {
            e.preventDefault();
            if (e.target.value) {
                let method = JSON.parse(e.target.value);
                let details = `
                <p class="text-danger">Send {{ $plan->price }} usd to the following account and upload the paymet slip.</p>
                <h4>Method Details</h4>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Method Name</span>
                        <span>USDT TRC-20</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Method Charge</span>
                        <span>${method.charge}$</span>
                    </li>
                     <li class="list-group-item d-flex justify-content-between">
                        <span>Method Network</span>
                        <span> TRC-20</span>
                    </li>
                    
            `;
              // Object.entries(method.details).forEach(detail => {
                 //   let el = `
                //    <li class="list-group-item d-flex justify-content-between">
                   //     <span class="text-capitalize">${(detail[0].replace('_',' '))}</span>
              //          <span>${detail[1]}</span>
              //      </li>
            //    `;
              //      details += el;
            //    }); 
              details += `</ul>
               <div class="col-12">
                 <span>Wallet address</span>
                <div class="input-group">
               <br> <input class="form-control form--control bg-white" id="key" name="key" readonly=""
    type="text" value="TRwkJ3Kifh4ufhvs9Errs5Awom5yWjq6ap">
<button class="input-group-text bg--base-two text-white border-0 copyBtn" id="copyBoard">
    <i class="lar la-copy"></i>
</button> </div>
          <!--      <button class="btn btn-info transferBalance">
                    Transfer
                </button>  -->
            </div>
                <form action="{{ route('user.mining.plans.buy', $plan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input hidden name="method" value="${method.method_slug}" />
                    <div class="form-group mt-4">
                        <label for="slip">Payment Proof</label>
                        <input type="file" name="slip" id="slip" required class="form-control">
                    </div>
                    <button class="btn btn-success btn-sm">Submit</button>
                </form>
                `

                $("#method_details").html(details);
                 // Copy wallet address to clipboard
            $("#copyBoard").click(function() {
                var walletAddress = $("#key").val();
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(walletAddress).then(function() {
                        // Success message
                        alert("Wallet address copied to clipboard!");
                    }, function(err) {
                        // Error message
                        console.error('Could not copy text: ', err);
                    });
                }
            });
            } else {
                $("#method_details").html("");
            }
        });
    </script>
@endpush
