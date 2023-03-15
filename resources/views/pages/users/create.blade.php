
@extends('layouts/contentLayoutMaster')

@section('title', $title)

@section('content')
<section id="basic-horizontal-layouts">
  <div class="row match-height">

      <div class="col-md-6 col-12 offset-md-3">
          <div class="card">
              <div class="card-header">
                  <h4 class="card-title">{{$mode}} {{$title}}</h4>
              </div>
              <div class="card-content">
                  <div class="card-body">
                      <form class="form form-horizontal" method="POST" action="{{(($mode == 'Update') ? route('users.update', $edit->id) : route('users.store'))}}">
                        @csrf
                          <div class="form-body">
                              <div class="row">
                                @foreach ($errors->all() as $error)
                                {{ $error }}<br/>
                            @endforeach                                      <!--  ////////////////GOOGLE 2 Way login ////////////// -->
                                      @if(@$static['google2fa']['status'] == '1')
                                      <div class="col-12">
                                        <div class="form-group row">
                                          <div class="col-md-4">
                                            <span>Google Authenticator</span>
                                          </div>
                                          <div class="col-md-8">
                                              <input type="text" class="form-control" name="google2fa_secret" readonly="true"
                                              value="{{ $static['google2fa']['generatedsecret'] }}"
                                              >
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-12">
                                        <div class="form-group row">
                                          <div class="col-md-4">

                                          </div>

                                          <div class="col-md-8">
                                              <img src="{{ $static['google2fa']['qr_image'] }}" style="height:150px;">
                                          </div>

                                        </div>
                                      </div>
                                      @endif
                                       <!--  ////////////////GOOGLE 2 Way login ////////////// -->

                                      <div class="col-12">
                                        <div class="form-group row">
                                          <div class="col-md-4">
                                            <span>Username</span>
                                          </div>
                                          <div class="col-md-8">
                                              <div class="position-relative has-icon-left">
                                                  <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" placeholder="Username" value="{{($mode == 'Update') ? $edit->username: old('username')}}" required autocomplete="username" autofocus>
                                                  @error('username')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                  @enderror
                                                  <div class="form-control-position">
                                                     <i class="feather icon-user"></i>
                                                </div>
                                              </div>
                                          </div>
                                        </div>
                                      </div>

                                     @if ($mode != 'Update')
                                      <div class="col-12">
                                        <div class="form-group row">
                                          <div class="col-md-4">
                                            <span>Password</span>
                                          </div>
                                          <div class="col-md-8">
                                              <div class="position-relative has-icon-left">
                                                   <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new-password">
                                                    @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                  @enderror
                                                  <div class="form-control-position">
                                                     <i class="feather icon-user"></i>
                                                </div>
                                              </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-12">
                                        <div class="form-group row">
                                          <div class="col-md-4">
                                            <span>Confirm Password</span>
                                          </div>
                                          <div class="col-md-8">
                                              <div class="position-relative has-icon-left">
                                                 <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                                                  <div class="form-control-position">
                                                     <i class="feather icon-user"></i>
                                                </div>
                                              </div>
                                          </div>
                                        </div>
                                      </div>
                                      @endif






                                  <div class="col-12">
                                      <div class="form-group row">
                                          <div class="col-md-4">
                                            <span>First Name</span>
                                          </div>
                                          <div class="col-md-8">
                                              <div class="position-relative has-icon-left">
                                                  <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" placeholder="First Name" value="{{($mode == 'Update') ? $edit->first_name: old('first_name')}}" required autocomplete="OFF" autofocus>
                                                  @error('first_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                  @enderror
                                                  <div class="form-control-position">
                                                     <i class="feather icon-user"></i>
                                                </div>
                                              </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-12">
                                        <div class="form-group row">
                                          <div class="col-md-4">
                                            <span>Last Name</span>
                                          </div>
                                          <div class="col-md-8">
                                              <div class="position-relative has-icon-left">
                                                  <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" placeholder="Username" value="{{($mode == 'Update') ? $edit->last_name: old('last_name')}}" required autocomplete="OFF" autofocus>
                                                  @error('last_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                  @enderror
                                                  <div class="form-control-position">
                                                     <i class="feather icon-user"></i>
                                                </div>
                                              </div>
                                          </div>
                                        </div>
                                      </div>



                                      <div class="col-12">
                                        <div class="form-group row">
                                          <div class="col-md-4">
                                            <span>Email Address</span>
                                          </div>
                                          <div class="col-md-8">
                                              <div class="position-relative has-icon-left">
                                                  <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email Address" value="{{($mode == 'Update') ? $edit->email: old('email')}}" required autocomplete="email" autofocus>
                                                  @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                  @enderror
                                                  <div class="form-control-position">
                                                     <i class="feather icon-user"></i>
                                                </div>
                                              </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-12">
                                        <div class="form-group row">
                                          <div class="col-md-4">
                                            <span>Mobile Number</span>
                                          </div>
                                          <div class="col-md-8">
                                              <div class="position-relative has-icon-left">
                                                <input type="text" name="mobile_number" id="numberlis" hidden>
                                                <input id="mobile_number" type="text" class="form-control @error('mobile_number') is-invalid @enderror" name="mobile_number" placeholder="Mobile Number" value="{{($mode == 'Update') ? $edit->mobile_number: old('mobile_number')}}" required autocomplete="OFF" autofocus>
                                                  @error('mobile_number')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                  @enderror
                                                  <div class="form-control-position">
                                                     <i class="feather icon-user"></i>
                                                </div>
                                              </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-md-12">
                                        <div class="form-group row">
                                          
                                          <div class="col-md-4">
                                            <span>Acess Level:  </span>
                                          </div>
                                     
                                          <div class="col-md-8">
                                            <select class="form-control" name="access_level" id="access_level">
                                              <option value="" {{ $mode == 'Update' ? '' : 'selected' }}
                                                  style="display:none;">Please Select ....</option>
                                              @foreach ($static['access_levels'] as $core_user_level)
                                                  <option value="{{ $core_user_level->id }}"
                                                      {{ $mode == 'Update' && $core_user_level->id == $edit->access_level ? 'selected' : '' }}>
                                                      {{ $core_user_level->accesslevel }}</option>
                                              @endforeach
                                            </select>
                                          </div>

                                        </div>
                                      </div>


                                      <div class="col-md-12">
                                        <div class="form-group row">
                                          
                                          <div class="col-md-4">
                                            <span>Status:  </span>
                                          </div>

                                          <div class="col-md-8">
                                            <select class="form-control" name="account_status" id="account_status">
                                              <option value="" {{ $mode == 'Update' ? '' : 'selected' }}
                                                  style="display:none;">Please Select ....</option>
                                              @foreach ($static['system_statuses'] as $core_status)
                                                  <option value="{{ $core_status->id }}"
                                                      {{ $mode == 'Update' && $core_status->id == $edit->account_status ? 'selected' : '' }}>
                                                      {{ $core_status->status_name }}</option>
                                              @endforeach
                                            </select>
                                          </div>

                                        </div>
                                      </div>
  
                                  </div>
                                  @if ($mode == 'Update')
                                    @method('PUT')
                                    <input type="hidden" name="id" value = "{{($mode == 'Update') ? $edit->id: ''}}">
                                    <input type="hidden" name="mode" value = "{{$mode}}">
                                  @endif
                                  <div class="offset-md-1">
                                      <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                      <button type="reset" class="btn btn-primary mr-1 mb-1">Reset</button>
                                      <a href="{{route('users.index')}}" class="btn btn-outline-primary mr-1 mb-1">Back</a>
                                  </div>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
@endsection


@section('page-script')
<script src="{{ asset('js/scripts/imask/imask.js') }}"></script>

@endsection