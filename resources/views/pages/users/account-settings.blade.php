@extends('layouts/contentLayoutMaster')

@section('title', 'Account Settings')

@section('vendor-style')
        <!-- vendor css files -->
        <link rel='stylesheet' href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
        <link rel='stylesheet' href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
@endsection
@section('page-style')
        <!-- Page css files -->
        <link rel="stylesheet" href="{{ asset(mix('css/plugins/extensions/noui-slider.css')) }}">
        <link rel="stylesheet" href="{{ asset(mix('css/core/colors/palette-noui.css')) }}">
@endsection

@section('content')
<!-- account setting page start -->
<section id="page-account-settings">
    <div class="row">
      <!-- left menu section -->
      
     
      
      <div class="col-md-3 mb-2 mb-md-0">
        <ul class="nav nav-pills flex-column mt-md-0 mt-1">
          <li class="nav-item">
            <a class="nav-link d-flex py-75 
            @if(($errors->has('current_password') or $errors->has('new-password')) or $gen == '' )
            
            @elseif((!$errors->has('current_password') or !$errors->has('new-password')) && $gen != '' )
            active
            
            @else 
            active
            @endif" id="account-pill-general" data-toggle="pill"
              href="#account-vertical-general" aria-expanded="true">
              <i class="feather icon-globe mr-50 font-medium-3"></i>
              General
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex py-75 
            @if(($errors->has('current_password') or $errors->has('new-password')) or $changepass != '' )
              active
            @elseif((!$errors->has('current_password') or !$errors->has('new-password')) && $changepass != '' ))
              active
            @else 
            @endif" 
            id="account-pill-password" data-toggle="pill"
              href="#account-vertical-password" aria-expanded="false">
              <i class="feather icon-lock mr-50 font-medium-3"></i>
              Change Password
            </a>
          </li>

         
        </ul>
      </div>
      <!-- right content section -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane 
                @if(($errors->has('current_password') or $errors->has('new-password')) or $gen == '' )
                @elseif((!$errors->has('current_password') or !$errors->has('new-password')) && $gen != '' )
                active
                @else 
                active
                @endif" id="account-vertical-general"
                  aria-labelledby="account-pill-general" aria-expanded="true">

                  @if(session()->get('success'))
                    <h5 class="text-success">{{ session()->get('success') }} </h5>
                  @endif
                  @if(session()->get('failed'))
                  <h5 class="text-danger">{!! (session()->get('failed')) !!} </h5>
                @endif
                  <!-- <div class="media">
                    <a href="javascript: void(0);">
                      <img src="{{ asset('images/portrait/small/avatar-s-12.jpg') }}" class="rounded mr-75"
                        alt="profile image" height="64" width="64">
                    </a>
                    <div class="media-body mt-75">
                      <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                        <label class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 cursor-pointer"
                          for="account-upload">Upload new photo</label>
                        <input type="file" id="account-upload" hidden>
                        <button class="btn btn-sm btn-outline-warning ml-50">Reset</button>
                      </div>
                      <p class="text-muted ml-75 mt-50"><small>Allowed JPG, GIF or PNG. Max
                          size of
                          800kB</small></p>
                    </div>
                  </div> -->
                  <hr>
                  
                  <input type="hidden" name="mode_error" value="{{session()->get('mode')}}" id="mode_error">
  
                  <form class="form form-horizontal" method="POST" action="{{ route('submit_account_settings') }}">
                    @csrf
                    
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <div class="controls">
                            <label for="account-username">Username</label>
                            <input type="hidden" name="_mode" value="changepass">
                            <input type="text" class="form-control" id="account-username" readonly="readonly" placeholder="Username"
                              value="{{$gen_info['username']}}" name="username" required
                              data-validation-required-message="This username field is required">
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <div class="controls">
                            <label for="account-name">First Name</label>
                            <input type="text" class="form-control" id="account-firstname" placeholder="Name"
                              value="{{$gen_info['firstname']}}" name="first_name" required
                              data-validation-required-message="This name field is required">
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <div class="controls">
                            <label for="account-name">Last Name</label>
                            <input type="text" class="form-control" id="account-lastname" placeholder="Name"
                              value="{{$gen_info['lastname']}}" name="last_name" required
                              data-validation-required-message="This name field is required">
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <div class="controls">
                            <label for="account-e-mail">E-mail</label>
                            <input type="email" class="form-control" id="account-e-mail" placeholder="Email"
                              value="{{$gen_info['email']}}" name="email" required
                              data-validation-required-message="This email field is required">
                          </div>
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-group">
                          <div class="controls">
                            <label for="Mobile Number">Mobile Number</label>
                            <input type="number" class="form-control" id="mobile_number" placeholder="Mobile Number"
                              value="{{$gen_info['mobile_number']}}" name="mobile_number" required
                              data-validation-required-message="This mobile_number field is required">
                          </div>
                        </div>
                      </div>
                   
                     
                      <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                        <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save
                          changes</button>
                      </div>
                    </div>
                    @method('PUT')
                    <input type="hidden" name="id" value = "{{$gen_info['id']}}">
                    <input type="hidden" name="mode" value = "account_settings">
                  </form>
                 
                </div>

                <div class="tab-pane 
                @if(($errors->has('current_password') or $errors->has('new-password')) or $changepass != '' )
                  active show
                @elseif((!$errors->has('current_password') or !$errors->has('new-password')) && $changepass != '' ))
                  active show
                @else 
                @endif fade" id="account-vertical-password" role="tabpanel"
                  aria-labelledby="account-pill-password" aria-expanded="false">

                  @if(session()->get('success'))
                    <h5 class="text-success">{{ session()->get('success') }} </h5>
                  @endif
                  @if(session()->get('failed'))
                    <h5 class="text-danger">{!! session()->get('failed') !!} </h5>
                  @endif

                  @if(count($errors->all()) > 0)
                  <h5 class="text-danger">Errors found.</h5>
                  @foreach ($errors->all() as $error)
                    <p class="text-danger">{{ $error }}<br></p>
                  @endforeach 
                  @endif

                  <form method="POST" action="{{ route('submit_account_settings') }}">
                    @csrf 
                    <div class="row">
                      @method('PUT')
                    <input type="hidden" name="id" value = "{{$gen_info['id']}}">
                      <input type="hidden" name="mode" value = "change_pass">
                      
                      
                       
                      <div class="col-12">
                        <div class="form-group">
                          <div class="controls">
                            <label for="account-old-password">Old Password</label>
                            <input type="password" class="form-control" id="account-old-password" required name="current_password"
                              placeholder="Old Password"
                              data-validation-required-message="This old password field is required">
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <div class="controls">
                            <label for="account-new-password">New Password</label>
                            <input type="password" name="new_password" id="new_password" class="form-control"
                              placeholder="New Password" required
                              data-validation-required-message="The password field is required" minlength="6">
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-group">
                          <div class="controls">
                            <label for="account-retype-new-password">Retype New
                              Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control" required
                              id="new-password_confirmation" data-validation-match-match="new-password"
                              placeholder="New Password"
                              data-validation-required-message="The Confirm password field is required" minlength="6">
                          </div>
                        </div>
                      </div>
                      <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                        <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save
                          changes</button>
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
<!-- account setting page end -->
@endsection

@section('vendor-script')
        <!-- vendor files -->
        <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/forms/validation/jqBootstrapValidation.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>
@endsection
@section('page-script')
        <!-- Page js files -->
        <script src="{{ asset(mix('js/scripts/pages/account-setting.js')) }}"></script>
        <script type="text/javascript">
          $(document).ready(function(){
            var mode = $('#mode_error').val();

            if (mode == 'change_pass') {
              $('#account-vertical-general').removeClass('active show');
              $('#account-pill-password').trigger('click');
            }
          });
        </script>
@endsection