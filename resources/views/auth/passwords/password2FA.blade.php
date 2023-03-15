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
                              <h4 class="mb-0">Google Authentication</h4>
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
                            <form method="POST" action="{{ url('password2FA') }}">
                              @csrf
                                
                              
                                <fieldset class="form-label-group">
                                    <input id="totp" type="number" maxlength="6" 
                                    class="form-control @error('totp') is-invalid @enderror" 
                                    name="totp" placeholder="Enter 6 digit code here" required >
                                    <label for="totp">2FA</label>
                                </fieldset>

                        
                               

                                <div class="row pt-2">
                                   
                                    <div class="col-12 col-md-6 mb-1">
                                        <button type="submit" class="btn btn-primary btn-block px-0">Submit</button>
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
