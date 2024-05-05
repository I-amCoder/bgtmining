@extends($activeTemplate . 'layouts.master_with_menu')
@section('content')
    <script>
        function getCountDown(elementId, seconds) {
            var times = seconds;

            var x = setInterval(function() {
                var distance = times * 1000;

                if (distance < 0) {
                    clearInterval(x);
                    firePayment(elementId);
                    return
                }
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                document.getElementById(elementId).innerHTML = days + "d " + hours + "h " + minutes + "m " +
                    seconds + "s ";
                times--;
            }, 1000);
        }
    </script>


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Mining Balance: {{ auth()->user()->mining_balance }}
                </div>
                <div class="card-body">
                    BGT Mining
                    <br>
                    @if (now() > auth()->user()->next_mining_time)
                        <form action="{{ route('user.mining.earn') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Earn</button>
                        </form>
                    @else
                        <span id="timer"></span>
                        <script>
                            getCountDown("timer",
                                "{{ now()->gt(auth()->user()->next_mining_time) ? 0 : now()->diffInSeconds(auth()->user()->next_mining_time) }}"
                                )
                        </script>
                    @endif
                </div>
                <div class="card-body">
                    <a href="{{ route('user.mining.plans') }}">Upgrade Plan</a>
                </div>
            </div>
        </div>
    </div>
@endsection
