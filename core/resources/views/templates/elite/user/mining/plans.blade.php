@extends($activeTemplate . 'layouts.master_with_menu')
@section('content')
    <h4>Upgrade Mining Plans</h4>
    <div class="row justify-content-center">
        @foreach ($plans as $plan)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card text-center">
                    <div class="card-header">
                        {{ $plan->plan_name }}
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                Price: ${{ number_format($plan->price) }}
                            </li>
                            <li class="list-group-item">
                                Daily Mining: {{ number_format($plan->return_interest) }} BGT
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        @if (auth()->user()->plan_id == $plan->id)
                            <span class="text-success">Current Plan</span>
                        @else
                            <a href="{{ route('user.mining.plans.buy', $plan->id) }}" class="btn btn-success ">
                                Buy
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
