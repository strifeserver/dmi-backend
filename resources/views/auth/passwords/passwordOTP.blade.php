@extends('layouts/fullLayoutMaster')

@section('title', 'One Time Password (OTP)')

@section('page-style')
        {{-- Page Css files --}}
        <link rel="stylesheet" href="{{ asset(mix('css/pages/authentication.css')) }}">
        <style>
  section.row.flexbox-container {
    background: #414561;
}

.card.bg-authentication.rounded-0.mb-0 {
 
    padding: 10px !important;
    border-radius: 10px !important;
   }

   button.btn.btn-primary.float-right.btn-inline.waves-effect.waves-light {
    background: #414561 !important;
}
</style>
@endsection
@section('content')
<section class="row flexbox-container">
  <div class="col-xl-7 col-10 d-flex justify-content-center">
      <div class="card bg-authentication rounded-0 mb-0 w-100">
          <div class="row m-0">
              <div class="col-lg-6 d-lg-block d-none text-center align-self-center p-0">
                  <img src="{{ asset('/images/pages/login.png') }}" alt="branding logo">
              </div>
              <div class="col-lg-6 col-12 p-0">
                  <div class="card rounded-0 mb-0 px-2">
                      <div class="card-header pb-1">
                          <div class="card-title">
                              <h4 class="mb-0">Enter One Time Password (OTP)</h4>
                          </div>
                      </div>
                      

                      <div class="card-content">
                          @if(session()->get('error'))
                                    <p class="px-2 text-danger">{{ session()->get('error') }} </p>
                          @endif

                          @error('new-password')
                                 <p class="px-2 text-danger">{{ $message }}</p>
                          @enderror

                          
                          <div class="card-body pt-1">
                            <form method="POST" action="{{ url('passwordOTP') }}">
                              @csrf
                                
                              
                                <fieldset class="form-label-group">
                                    <input id="otp" type="number" autofocus 
                                    class="form-control @error('otp') is-invalid @enderror" 
                                    name="otp" placeholder="One Time Password" required maxlength="6" >
                                    <label for="password">OTP</label>
                                </fieldset>
                                <p id="opt_msg" class="text-danger">OTP Expires in </span> Minutes</p>
                                <p id="exp_msg" class="text-danger" style="display:none;">OTP Expired</p>

                        
                               
                                
                                <div class="row pt-2">
                                   
                                    <div class="col-12 col-md-6 mb-1">
                                        <button type="submit" class="btn btn-primary btn-block px-0">Submit</button>
                                    </div>
                                    <div class="col-12 col-md-6 mb-1">
                                        
                                        <a class="btn btn-primary btn-block px-0" href="{{url('ResendOTP')}}">Resend OTP ({{$resend}})</a>
                                    </div>
                                </div>
                            </form>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
@endsection

<script>
// Set the date we're counting down to
//var countDownDate = new Date("Jan 5, 2021 15:37:25").getTime();
//var countDownDate = new Date("Apr 29, 2020 20:40:00").getTime();
var countDownDate = new Date("<?=$expired_on?>").getTime();

// Update the count down every 1 second
var x = setInterval(function() {
  var now = new Date().getTime();
  var distance = countDownDate - now;
  var tmpminutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var tmpseconds =  Math.floor((distance % (1000 * 60)) / 1000);
  var minutes = ("0" + tmpminutes).slice(-2);
  var seconds = ("0" + tmpseconds).slice(-2);
  
    var y = document.getElementById("opt_msg");
    var display_txt = 'OTP Expires in '+minutes + ":" + seconds +' Minutes';
    y.innerHTML = display_txt
  
  if (distance < 0) {
    clearInterval(x);
    var x1 = document.getElementById("exp_msg");
    x1.innerHTML = 'Your OTP is expired kindly resend';
    y.innerHTML = ''
    y.innerHTML = display_txt
    y.style.display = "none";
    x1.style.display = "block";
  }else{

  }
}, 1000);
</script>

