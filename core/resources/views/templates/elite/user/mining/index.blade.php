@extends($activeTemplate . 'layouts.master_with_menu')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Mining Balance: {{ auth()->user()->mining_balance }}
                </div>
                <div class="card-body">
                    BGT Mining
                    <br>
                    <form action="{{ route('user.mining.earn') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Earn</button>
                    </form>
                </div>
                <div class="card-body">
                    <a href="{{ route('user.mining.plans') }}">Upgrade Plan</a>
                </div>
            </div>
        </div>
    </div>
@endsection
