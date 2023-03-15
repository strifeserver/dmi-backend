@extends('layouts/fullLayoutMaster')

@section('title', 'Reset Password')

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
                  <img src="{{ asset('/images/pages/'.$image) }}" alt="branding logo">
              </div>
              <div class="col-lg-6 col-12 p-0">
                  <div class="card rounded-0 mb-0 px-2">
                      <div class="card-header pb-1">
                          <div class="card-title">
                              <h4 class="mb-0">Reset Password</h4>
                          </div>
                      </div>
                      <!-- <p class="px-2">Please enter your new password.</p> -->
                      <div class="card-content">
                          <div class="card-body pt-1">
                            @if(session()->get('error'))
                                  <p class="text-danger">{{ session()->get('error') }} </p>
                            @endif

                            @error('new-password')
                                   <p class="text-danger">{{ $message }}</p>
                            @enderror
                      
                            <br> 
                            <form method="POST" action="{{ url('passwordExpiration') }}">
                              @csrf
                                
                                

                                  
                                <fieldset class="form-label-group">
                                    <input id="current_password" type="password" 
                                    class="form-control @error('current_password') is-invalid @enderror" 
                                    name="current_password" placeholder="Current Password" 
                                    required  autofocus>
                                    <label for="current_password">Current Password</label>
                                
                                   
                                </fieldset>



                                <fieldset class="form-label-group">
                                    <input id="new-password" type="password" 
                                    class="form-control @error('new-password') is-invalid @enderror" 
                                    name="new-password" placeholder="Password" required >
                                    <label for="password">New Password</label>
                                   
                                </fieldset>


                        
                                <fieldset class="form-label-group">
                                    <input id="new-password_confirmation" type="password" class="form-control" name="new-password_confirmation" 
                                    placeholder="Confirm New Password" required >
                                    <label for="password-confirm">Confirm New Password</label>
                                </fieldset>

                            

                                <div class="row pt-2">
                                    <div class="col-12 col-md-6 mb-1">
                                        <a href="login" class="btn btn-outline-primary btn-block px-0">Go Back to Login</a>
                                    </div>
                                    <div class="col-12 col-md-6 mb-1">
                                        <button type="submit" class="btn btn-primary btn-block px-0">Reset</button>
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
