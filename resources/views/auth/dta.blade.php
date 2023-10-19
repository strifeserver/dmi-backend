@extends('layouts/fullLayoutMaster')

@section('title', 'Data Privacy Notice')

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/pages/authentication.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/pages/authentication.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="shortcut icon" type="image/x-icon" href="images/logo/dmicon.ico">
    <style>

    </style>
@endsection

@section('content')


    <div class="row">

        <div class="col-md-3">

        </div>

        <div class="col-md-6">
           <center> <h1>Data Privacy Notice</h1></center>

            <h2>1. Information We Collect:</h2>
            <p>We may collect and process the following types of personal information:</p>
            <ul>
                <li>Personal information, such as your name, email address, and contact details.</li>
                <li>Information you provide when using our services or website.</li>
                <li>Information about your interactions with our API on dmiph.online.</li>
            </ul>

            <h2>2. How We Use Your Data:</h2>
            <p>We use your data for the following purposes:</p>
            <ul>
                <li>To provide you with our services and support.</li>
                <li>To improve our services and tailor them to your needs.</li>
                <li>To communicate with you regarding updates, changes, or issues with our services.</li>
                <li>To ensure the security of our API on dmiph.online.</li>
            </ul>

            <h2>3. Accepting Cookies:</h2>
            <p>We use cookies to enhance your experience on our website. By clicking "Close" or continuing to use our site, you agree to our use of cookies. For more information</p>
 
            <h2>4. Data Security:</h2>
            <p>We take the security of your data seriously and have implemented the following measures:</p>
            <ul>
                <li>Encryption: Data transmitted to and from our services, including API interactions, is encrypted using
                    secure protocols.</li>
                <li>Access Control: We restrict access to your data to authorized personnel only.</li>
                <li>Regular Security Audits: We conduct security audits to identify and address potential vulnerabilities.
                </li>
                <li>Data Backup: We regularly back up data to prevent data loss in case of unexpected events.</li>
            </ul>

            <h2>5. API Access on dmiph.online:</h2>
            <p>Access to our API is restricted to the dmiph.online site. We ensure that:</p>
            <ul>
                <li>API Access Control: We use access controls and authentication methods to verify that API access is
                    granted only to authorized users and systems.</li>
                <li>Continuous Monitoring: Our security team constantly monitors API access to detect and respond to any
                    unauthorized or suspicious activity.</li>
                <li>Data Transmission Security: API data transmitted to and from dmiph.online is encrypted to protect it
                    from interception or tampering.</li>
            </ul>

            <h2>6. Your Rights:</h2>
            <p>You have the following rights regarding your personal information:</p>
            <ul>
                <li>The right to access and request a copy of your data.</li>
                <li>The right to rectify or update your data.</li>
                <li>The right to delete your data under certain circumstances.</li>
                <li>The right to object to the processing of your data.</li>
            </ul>

            <h2>7. Contact Information:</h2>
            <p>If you have any questions, concerns, or requests regarding your data or our data privacy practices, please
                contact us at dmi@dmionlineph.com .</p>

            <h2>8. Changes to This Privacy Notice:</h2>
            <p>We may update this privacy notice to reflect changes in our data practices. Please check this notice
                regularly for updates.</p>

            <p>Your privacy is important to us, and we are committed to safeguarding your data. We appreciate your trust in
                DMI.</p>


        </div>

        <div class="col-md-3">

        </div>
    </div>







@endsection
@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection

@section('page-script')

@endsection
