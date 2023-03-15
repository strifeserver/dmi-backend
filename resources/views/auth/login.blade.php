@extends('layouts/fullLayoutMaster')

@section('title', 'Login Page')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/pages/authentication.css')) }}">
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
  <div class="col-xl-8 col-11 d-flex justify-content-center">
    <div class="card bg-authentication rounded-0 mb-0">
      <div class="row m-0">
        <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
          <img src="{{ asset('/images/pages/'.$image) }}" alt="branding logo">
        </div>
        <div class="col-lg-6 col-12 p-0">


          <div class="card rounded-0 mb-0 px-2">
            @if(session('forced'))
            <div class="alert alert-warning mt-1" role="alert">
                <i class="feather icon-info"></i>
                {{ session('forced-reason') }}
            </div>
            @endif

            <div class="card-header pb-1">
              <div class="card-title">
                <h4 class="mb-0">Login</h4>
              </div>
            </div>

            <p class="px-2">Welcome back, please login to your account.</p>
            {{ Session::get('alert') }}
            @error('username')
                @if(strpos($message,'Too many login attempts') !== false )
                <p class="text-danger px-2"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{ $message }}</p>
                @else
                <p class="text-danger px-2"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{ $message }}</p>
                @endif
            @enderror

            @error('password')
                    <p class="text-danger px-2"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{ $message }}</p>
            @enderror

            @error('temp_password')
                    <p class="text-danger px-2"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{ $message }}</p>
            @enderror

            @if(session()->get('status'))
                    <p class="text-info px-2">{{ session()->get('status') }} </p>
            @endif

            @if(session()->get('error'))
                    <p class="text-danger px-2">{{ session()->get('error') }} </p>
            @endif

            @if(session()->get('success'))
                    <p class="text-info px-2">{{ session()->get('success') }} </p>
            @endif

            <div class="card-content">
              <div class="card-body pt-1">

                <form method="POST" action="{{ route('login') }}">
                  @csrf
                  <fieldset class="form-label-group form-group position-relative has-icon-left">

                    <input id="username" type="username" class="form-control @error('username') is-invalid @enderror"
                      name="username" placeholder="Username" value="{{ old('username') }}" required autocomplete="off"
                      autofocus >

                    <div class="form-control-position">
                      <i class="feather icon-user"></i>
                    </div>
                    <label for="username">Username</label>

                  </fieldset>

                  <fieldset class="form-label-group position-relative has-icon-left">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password"></label>
                      <a href="/forgot-password">
                    <small>Forgot Password?</small>
                    </a>
                  </div>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                      name="password" placeholder="Password" required autocomplete="current-password">

                    <div class="form-control-position" style="top: 20px;">
                      <i class="feather icon-lock"></i>
                    </div>
                    <label for="password" style="top:0px;">Password</label>

                  </fieldset>



                  
                  <div class="form-group d-flex justify-content-between align-items-center">
                    <div class="text-left">
                      <!-- <fieldset class="checkbox">
                        <div class="vs-checkbox-con vs-checkbox-primary">
                          <input type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                          <span class="vs-checkbox">
                            <span class="vs-checkbox--check">
                              <i class="vs-icon feather icon-check"></i>
                            </span>
                          </span>
                          <span class="">Remember me</span>
                        </div>
                      </fieldset> -->
                    </div>


                  </div>

                  @if(session()->get('message'))
                    @php
                      $message = json_decode(session()->get('message'), true);
                      $msg = $message['msg'];
                      $val = $message['val'];
                    @endphp

                    <div class="alert alert-warning" 
                      id="alertDisplay"
                      style="margin-top: 5px"
                      data-value="{{ $val }}">
                      <strong id="alert">{{ $msg }}</strong>
                    </div>
                    
                  @endif

                  <button type="submit" class="btn btn-primary float-right btn-inline">Login</button>
                </form>
              </div>
            </div>
            <div class="login-footer">

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@if(session()->get('message'))
<script type="text/javascript">
  var alert = document.getElementById('alertDisplay');
  var value = alert.attributes[3].nodeValue;

  if (value == 1) {
    setTimeout(function(){
      alert.style.display = 'none';
    }, 5000);
  }
</script>
@endif
@endsection
