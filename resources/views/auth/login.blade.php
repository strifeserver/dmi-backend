@extends('layouts/fullLayoutMaster')

@section('title', 'Login Page')

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/pages/authentication.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/pages/authentication.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">

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

        .swal2-popup {
            width: 900px !important;
            /* Set the desired width here */
        }

        .swal2-popup .swal2-content {
            text-align: left !important;
        }
    </style>
@endsection

@section('content')
    <section class="row flexbox-container">
        <div class="col-xl-8 col-11 d-flex justify-content-center">
            <div class="card bg-authentication rounded-0 mb-0">
                <div class="row m-0">
                    <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
                        <img src="{{ asset('/images/pages/' . $image) }}" alt="branding logo">
                    </div>
                    <div class="col-lg-6 col-12 p-0">


                        <div class="card rounded-0 mb-0 px-2">
                            @if (session('forced'))
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
                                @if (strpos($message, 'Too many login attempts') !== false)
                                    <p class="text-danger px-2"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                        {{ $message }}</p>
                                @else
                                    <p class="text-danger px-2"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                        {{ $message }}</p>
                                @endif
                            @enderror

                            @error('password')
                                <p class="text-danger px-2"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                    {{ $message }}</p>
                            @enderror

                            @error('temp_password')
                                <p class="text-danger px-2"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                    {{ $message }}</p>
                            @enderror

                            @if (session()->get('status'))
                                <p class="text-info px-2">{{ session()->get('status') }} </p>
                            @endif

                            @if (session()->get('error'))
                                <p class="text-danger px-2">{{ session()->get('error') }} </p>
                            @endif

                            @if (session()->get('success'))
                                <p class="text-info px-2">{{ session()->get('success') }} </p>
                            @endif

                            <div class="card-content">
                                <div class="card-body pt-1">

                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <fieldset class="form-label-group form-group position-relative has-icon-left">

                                            <input id="username" type="username"
                                                class="form-control @error('username') is-invalid @enderror" name="username"
                                                placeholder="Username" value="{{ old('username') }}" required
                                                autocomplete="off" autofocus maxlength="30">

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
                                            <input id="password" type="password" maxlength="30"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                placeholder="Password" required autocomplete="current-password">

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

                                        @if (session()->get('message'))
                                            @php
                                                $message = json_decode(session()->get('message'), true);
                                                $msg = $message['msg'];
                                                $val = $message['val'];
                                            @endphp

                                            <div class="alert alert-warning" id="alertDisplay" style="margin-top: 5px"
                                                data-value="{{ $val }}">
                                                <strong id="alert">{{ $msg }}</strong>
                                            </div>
                                        @endif

                                        <button type="submit" class="btn btn-primary float-right btn-inline">Login</button>
                                        <a href="/dpa" target="_blank" style="font-size: 12px;">Data Privacy Notice</a>
                                    </form>

                                    <button hidden id="home_button" type="submit"
                                        class="btn btn-primary float-right btn-inline" style="margin-right: 10px;"
                                        onclick="homeRed()">Home</button>

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
    @if (session()->get('message'))
        <script type="text/javascript">
            var alert = document.getElementById('alertDisplay');
            var value = alert.attributes[3].nodeValue;

            if (value == 1) {
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 5000);
            }
        </script>
    @endif




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
@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')
    <script>
        // Check if the alert cookie exists
        if (!getCookie('alertShown')) {
            // Show the SweetAlert
            Swal.fire({
                title: '<strong>Data Privacy Notice</strong>',
                icon: 'info',
                html: `
    
    <h2>1. Information We Collect:</h2>
    <p>We may collect and process the following types of personal information:</p>
    
        <p>Personal information, such as your name, email address, and contact details.</p>
        <p>Information you provide when using our services or website.</p>
        <p>Information about your interactions with our API on dmiph.online.</p>
    

    <h2>2. How We Use Your Data:</h2>
    <p>We use your data for the following purposes:</p>
    
        <p>To provide you with our services and support.</p>
        <p>To improve our services and tailor them to your needs.</p>
        <p>To communicate with you regarding updates, changes, or issues with our services.</p>
        <p>To ensure the security of our API on dmiph.online.</p>
    

    <h2>3. Data Security:</h2>
    <p>We take the security of your data seriously and have implemented the following measures:</p>
    
        <p>Encryption: Data transmitted to and from our services, including API interactions, is encrypted using secure protocols.</p>
        <p>Access Control: We restrict access to your data to authorized personnel only.</p>
        <p>Regular Security Audits: We conduct security audits to identify and address potential vulnerabilities.</p>
        <p>Data Backup: We regularly back up data to prevent data loss in case of unexpected events.</p>
    

    <h2>4. API Access on dmiph.online:</h2>
    <p>Access to our API is restricted to the dmiph.online site. We ensure that:</p>
    
        <p>API Access Control: We use access controls and authentication methods to verify that API access is granted only to authorized users and systems.</p>
        <p>Continuous Monitoring: Our security team constantly monitors API access to detect and respond to any unauthorized or suspicious activity.</p>
        <p>Data Transmission Security: API data transmitted to and from dmiph.online is encrypted to protect it from interception or tampering.</p>
    

    <h2>5. Your Rights:</h2>
    <p>You have the following rights regarding your personal information:</p>
    
        <p>The right to access and request a copy of your data.</p>
        <p>The right to rectify or update your data.</p>
        <p>The right to delete your data under certain circumstances.</p>
        <p>The right to object to the processing of your data.</p>
    

    <h2>6. Contact Information:</h2>
    <p>If you have any questions, concerns, or requests regarding your data or our data privacy practices, please contact us at [Contact Email/Phone Number].</p>

    <h2>7. Changes to This Privacy Notice:</h2>
    <p>We may update this privacy notice to reflect changes in our data practices. Please check this notice regularly for updates.</p>

    <p>Your privacy is important to us, and we are committed to safeguarding your data. We appreciate your trust in DMI.</p>


    `,
                showCloseButton: true,
                showCancelButton: false,
                focusConfirm: false,
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Close',
            }).then(() => {
                // Set a cookie to indicate that the alert has been shown (expires in 7 days)
                setCookie('alertShown', 'true', 7);
            });
        }

        // Function to get a cookie by name
        function getCookie(name) {
            var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            return match ? match[2] : null;
        }

        // Function to set a cookie with an expiration date in days
        function setCookie(name, value, days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            var expires = 'expires=' + date.toUTCString();
            document.cookie = name + '=' + value + '; ' + expires;
        }
    </script>
@endsection