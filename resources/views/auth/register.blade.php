@extends('layouts/fullLayoutMaster')

@section('title', 'Register Page')

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/pages/authentication.css')) }}">
@endsection
@section('content')
    <section class="row flexbox-container">
        <div class="col-xl-8 col-10 d-flex justify-content-center">
            <div class="card bg-authentication rounded-0 mb-0">
                <div class="row m-0">
                    <div class="col-lg-6 d-lg-block d-none text-center align-self-center pl-0 pr-3 py-0">
                        <img src="{{ asset('images/pages/register.jpg') }}" alt="branding logo">
                    </div>
                    <div class="col-lg-6 col-12 p-0">
                        <div class="card rounded-0 mb-0 p-2">
                            <div class="card-header pt-50 pb-1">
                                <div class="card-title">
                                    <h4 class="mb-0">Create Account</h4>
                                </div>
                            </div>
                            <p class="px-2">Fill the below form to create a new account.</p>
                            <div class="card-content">
                                <div class="card-body pt-0">
                                    <form method="POST" action="{{ route('customer_registration') }}">
                                        @csrf


                                        <div class="form-label-group">
                                            <!-- <input type="email" id="inputEmail" class="form-control" placeholder="Email" required> -->
                                            <input id="first_name" type="text"
                                                class="form-control @error('first_name') is-invalid @enderror"
                                                name="first_name" placeholder="First Name" value="{{ old('first_name') }}"
                                                required autocomplete="First Name"
                                                maxlength="30"
                                                >
                                            <label for="first_name">first_name</label>
                                            @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>


                                        <div class="form-label-group">
                                            <!-- <input type="email" id="inputEmail" class="form-control" placeholder="Email" required> -->
                                            <input id="last_name" type="text"
                                                class="form-control @error('last_name') is-invalid @enderror"
                                                name="last_name" placeholder="Last Name" value="{{ old('last_name') }}"
                                                required autocomplete="Last Name"
                                                maxlength="30"

                                                >
                                            <label for="last_name">last_name</label>
                                            @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-label-group">
                                            <!-- <input type="email" id="inputEmail" class="form-control" placeholder="Email" required> -->
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                placeholder="Email" value="{{ old('email') }}" required
                                                autocomplete="email"
                                                maxlength="30"
                                                
                                                >
                                            <label for="email">Email</label>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>


                                        <div class="form-label-group">
                                            <!-- <input type="email" id="inputEmail" class="form-control" placeholder="Email" required> -->
                                            <input id="mobile_number" type="text"
                                                class="form-control @error('mobile_number') is-invalid @enderror"
                                                name="mobile_number" placeholder="Mobile Number (optional)" value="{{ old('mobile_number') }}"
                                                autocomplete="Mobile Number"
                                                maxlength="30"

                                                 >
                                            <label for="mobile_number">mobile_number</label>
                                            @error('mobile_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>


                                        <div class="form-label-group">
                                            <!-- <input type="password" id="inputPassword" class="form-control" placeholder="Password" required> -->
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                placeholder="Password" required autocomplete="new-password"
                                                maxlength="30"
                                                
                                                >
                                            <label for="password">Password</label>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-label-group">
                                            <!-- <input type="password" id="inputConfPassword" class="form-control" placeholder="Confirm Password" required> -->
                                            <input id="password-confirm" type="password" class="form-control"
                                                name="password_confirmation" placeholder="Confirm Password" required
                                                autocomplete="new-password"
                                                maxlength="30"
                                                
                                                >
                                            <label for="password-confirm">Confirm Password</label>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <fieldset class="checkbox">
                                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                                        <input type="checkbox" checked>
                                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                        <span class=""> I accept the terms & conditions.</span>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <a hidden href="login"
                                            class="btn btn-outline-primary float-left btn-inline mb-50">Login</a>
                                        <button type="submit"
                                            class="btn btn-primary float-right btn-inline mb-50">Register</a>
                                    </form>
                                    <button hidden id="home_button" type="submit"
                                        class="btn btn-primary float-right btn-inline" style="margin-right: 10px;"
                                        onclick="homeRed()">Home</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        function homeRed() {
            window.location.href = '/home';
        }
        // document.addEventListener('DOMContentLoaded', function() {
        //     document.getElementById('home_button').addEventListener('click', function() {
        //     });
        // });
    </script>
@endsection
