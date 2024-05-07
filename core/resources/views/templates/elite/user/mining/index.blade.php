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
                document.getElementById(elementId).innerHTML =  hours + "h " + minutes + "m " +
                    seconds + "s ";
                times--;
            }, 1000);
        }
    </script>
@php
  $content = getContent('banner.content', true);
$planId = auth()->user()->plan_id;

$planName = '';
$earn= '';

switch ($planId) {
    case 17:
        $planName = 'Free Plan';
        $earn= '1';
        
        break;
    case 18:
        $planName = 'Level 1';
        $earn= '2';
        break;
    case 19:
        $planName = 'Level 2';
        $earn= '4';
        break;
        case 20:
        $planName = 'Level 3';
        $earn= '6';
        break;
        case 21:
        $planName = 'Level 4';
        $earn= '13';
        break;
        case 22:
        $planName = 'Level 5';
        $earn= '30';
        break;
        case 23:
        $planName = 'Level 6';
        $earn= '70';
        break;
          case 24:
        $planName = 'Level 7';
        $earn= '150';
        break;
          case 25:
        $planName = 'Level 8';
        $earn= '800';
        break;
          case 26:
        $planName = 'Level 9';
        $earn= '2000';
        break;
         
    default:
        $planName = 'Free Plan';
        $earn= '1';
}
@endphp

    <div class="row">
        <div class="col-md-12 ">
            <div class="card ">
               
                <div class="card-body">
                   <div class=''>
                        <form action="{{ route('user.mining.earn') }}" method="POST">
                            @csrf
                           <button type="submit" class=""> <i class="fa fa-bolt fa-3x pay1"></i></button>   <a href="https://bgtmining.bitcoingoldtrading.com/contact" ><i class="far fa-comment-dots fa-3x pay1"></i> </a> <a href="https://bgtmining.bitcoingoldtrading.com/user/referred/users" ><i class="fas fa-users fa-3x pay1"></i> </a> 
                             
                        </form>
                      <br>
                        
                 <div class="text-center">
    <a href="{{ route('user.mining.plans') }}" class="btn btn-danger mx-auto">Upgrade Plan</a>
</div>
<br>
          </div>             
                          
                        
                        <div class="container">
    <div class="row row-cols-2 row-cols-sm-2 g-3">
        <div class="col">
            <div class="card bg--base text-white">
                <div class="card-body">
                    <h5 class="card-title text-white">Total Mining</h5>
                    <p class="card-text"><small>{{ auth()->user()->mining_balance }} BGT</small></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h5 class="card-title text-white">Mining Timer</h5>
                    <p class="card-text"><small>  <span id="timer"></span><script>
                            getCountDown("timer",
                                "{{ now()->gt(auth()->user()->next_mining_time) ? 0 : now()->diffInSeconds(auth()->user()->next_mining_time) }}"
                                )
                        </script></small></p>
                </div>
            </div>
        </div>
     <div class="col">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h5 class="card-title text-white">Mining plan</h5>
                    <p class="card-text"><small>{{ $planName }} </small></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg--base text-white">
                <div class="card-body">
                    <h5 class="card-title text-white">Daily Mining</h5>
                    <p class="card-text"> {{ $earn }} BGT
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
                <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="banner-content">
                    <h2 class="banner-content__title">{{ __(@$content->data_values->heading) }} </h2>
                    <h4 class="banner-content__subtitle" s-break="3" s-color="base-two" s-length="2"><small>{{ __(@$content->data_values->subheading) }}</small></h4>
                </div>
            </div>
          
        </div>
    </div>    
             
        </div>
    </div>

    
@endsection


@push('style')
    <style>
    .banner-section {
    background-image: url('{{ getImage('assets/images/frontend/banner/' . @$content->data_values->image, '515x295') }}');
  
   
    /* Other styles for the section */
    width: 100%; /* Assuming you want the section to span the entire width */
    height: 100%; /* Set the height of the section */
}
body {
    margin: 0; /* Remove default margin */
    padding: 0; /* Optionally, remove default padding */
    background-image: url('{{ getImage('assets/images/frontend/banner/' . @$content->data_values->image, '515x295') }}');
    background-size: cover; /* Adjust as needed */
    background-position: center; /* Adjust as needed */
    /* Other styles for the body */
}


       .pay1 {
    margin-left: 10px;
    padding-top: 10px;
    background-color: orange;
    border-radius: 50%;
    width: 80px;
    height: 80px;
    text-align: center;
    color: white;
    border: 6px solid black; /* Added black border */
}

     
    </style>
@endpush

