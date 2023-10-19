@isset($pageConfigs)
    {!! Helper::updatePageConfig($pageConfigs) !!}
@endisset

<!DOCTYPE html>
{{-- {!! Helper::applClasses() !!} --}}
@php
    $configData = Helper::applClasses();
@endphp

<html
    lang="@if (session()->has('locale')) {{ session()->get('locale') }}@else{{ $configData['defaultLanguage'] }} @endif"
    data-textdirection="{{ env('MIX_CONTENT_DIRECTION') === 'rtl' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DMI </title>
    <link rel="shortcut icon" type="image/x-icon" href="images/logo/dmicon.ico">
    {{-- Include core + vendor Styles --}}
    @include('panels/styles')

</head>

@isset($configData['mainLayoutType'])
    @extends($configData['mainLayoutType'] === 'horizontal' ? 'layouts.frontLayoutMaster' : 'layouts.frontLayoutMaster')
@endisset

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">

@endsection
@section('content')
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.0/dist/aos.css" />

    <script src="https://unpkg.com/aos@2.3.0/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1200,
        })
    </script>
    <style>
        body {
            overflow-x: hidden;
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE and Edge */
            overflow: -moz-scrollbars-none;
            /* Old Firefox */
            overscroll-behavior: none;
        }

        @font-face {
            font-family: 'FontAwesome';
            src: url('fonts/font-awesome/fonts/FontAwesome.otf') format('opentype');
        }

        h1 {
            font-family: 'FontAwesome', sans-serif;
        }

        #home_section {
            height: 90vh;
        }

        .parallax {
            /* The image used */
            background-image: url("/images/surveyorimg.jpg");
            opacity: 0.65;
            /* Set a specific height */
            min-height: 80vh;

            /* Create the parallax scrolling effect */
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .parallax-caption {
            position: absolute;
            top: 50%;
            /* width: 50%; */
        }


        .swal2-popup {
            width: 900px !important;
            /* Set the desired width here */
        }

        .swal2-popup .swal2-content {
            text-align: left !important;
        }

        .carousel {
            width: 100%;
            /* Adjust width as needed */
            height: 60px;
            /* Adjust height as needed */
            position: relative;
            overflow: hidden;
        }

        .carousel-item {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .carousel-item.active {
            display: block;
        }

        .carousel-item.fade-in {
            animation: fade-in 1s ease-in-out;
        }

        @keyframes fade-in {
            0% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }


        .carousel-item img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            mask-image: linear-gradient(to right, transparent 20px, black 100%);
            -webkit-mask-image: linear-gradient(to right, transparent 20px, black 100%);
            /* For Safari support */
            transform-origin: left top;
            transform: skewX(-15deg);
            -webkit-transform-origin: left top;
            -webkit-transform: skewX(-20deg);
            /* For Safari support */
        }

        .defaultextcolor {
            color: black;
        }

        #contact_us {}

        #about_us_section {
            height: 90vh;
            background-image: url('images/aboutuswallpaper.png');
            background-size: cover;
            /* Adjust the background size as needed */
            background-repeat: no-repeat;
            background-position: center bottom 60%;
            /* Prevent the background from repeating */
            /* Additional styles for the section */
        }

        .indented-paragraph {
            font-size: 18px;
            color: white;
            margin-left: 20px;
            /* Adjust the indentation value as needed */
        }

        .filler {
            height: 100px;
        }

        .fade-background {
            height: 160px;
            position: absolute;
            right: 10px;
            top: 75%;
            background: linear-gradient(to left, rgba(0, 91, 20, 0), rgba(0, 91, 20, 1) 10%, rgba(0, 91, 20, 1) 90%, rgba(0, 91, 20, 0));
            animation: fade-background 4s infinite;
            border-radius: 10px;
        }

        @keyframes fade-background {
            0% {
                background-position: 100% 0;
            }

            100% {
                background-position: 0 0;
            }
        }



        /* .btn1menu{
            margin-left: 420px;
            max-width: 4% !important;
        }
        .btn2menu{
            max-width: 3.5% !important;
        }
        .btn3menu{
            max-width: 5% !important;
        }
        .btn4menu{
            max-width: 6.5% !important;
        }
        .btn5menu{
            max-width: 3.5% !important;
        } */

        



    </style>
    <section style="height:50px;">

    </section>
    <section id="home_section">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="parallax" style=" " data-aos="fade-down">

                    {{-- <div class="row parallax-caption" > --}}
                    <div data-aos="fade-left" class="col-sm-1 col-md-4 col-lg-6  parallax-caption""
                        style="background-color:rgb(66, 127, 38); line-height: 2;">
                        <h1 style="color:white; opacity: 1 !important; text-align:center; line-height: 2;">
                            Welcome to DMI Survey Site</h1>
                    </div>

                    {{-- </div> --}}
                    <div class="fade-background" data-aos="fade-right">
                        <div style="margin: 30px;">
                            <center>

                                <p><strong>We are here to accomodate your needs. </strong></p>
                                <p><strong>Click sign up to start.</strong></p>
                                <button class="btn btn-outline-secondary waves-effect waves-light text-color"
                                    style="color:black !important; background-color:beige !important;" id="sign_up_btn">Sign
                                    Up</button>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section class="filler">

    </section>


    <section id="contact_us_section" data-aos="fade-up">
        <div class="row">
            <div class="col-lg-12 col-md-6 col-sm-3">
                <center>

                    <h1>Contact Us</h1>
                    <hr>
                    <img class="img-fluid" src="images/contactus.png" alt="">
                </center>
            </div>
        </div>
        <br>
        <br>
        <br>


    </section>

    <section class="filler">
        <hr>

    </section>

    <section id="about_us_section" class="defaultextcolor" data-aos="fade-up">
        <br>
        <br>
        <br>
        <br>
        <div class="row">
            <div class="col-md-12">
                <center>
                    <h1 style="color:white;">About Us</h1>
                </center>
                <hr>
            </div>

            <div class="col-md-11" style="margin-left: 50px; background-color: #8080809e; margin-top: 10px;">
                <p class="indented-paragraph" data-aos="fade-left">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>DMI-MEC</strong> was established to
                    provide advice and assistance that is responsive to the
                    needs of
                    the client through an inter-disciplinary approach borne out of the collective expertise and experience
                    of its key staff.
                <p>

                <p class="indented-paragraph" data-aos="fade-right">

                    Its services vary which include planning and feasibility studies; detailed
                    architectural and engineering design; organization and management, and training.
                    It has provided consultancy
                    services in an array of development projects, such areas as those in transportation, housing, urban
                    and regional development planning, water supply, surveys and mapping, enterprise, architecture and
                    environmental protection.
                </p>

                <p class="indented-paragraph" data-aos="fade-left">

                </p>

                <p class="indented-paragraph" data-aos="fade-right">
                    Services are offered in every phase of project development from
                    pre-feasibility
                    and feasibility studies, master plan preparation, detailed engineering design, to construction
                    supervision
                    and management.
                </p>

                <p class="indented-paragraph" data-aos="fade-left">
                    Our Key Staff include Engineer Planners, Architects, Economists, Financial Experts,
                    Surveyors, Cartographers and Computer Experts, among others.
                </p>


                <br>
                <br>
                <br>
                <br>
                <p class="indented-paragraph" data-aos="fade-right">

                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>The FIRM</strong> also maintains a pool of
                    Consultants compose of Civil Engineers, Hydraulic
                    Engineers,
                    Hydrologists, Electrical Engineers, Structural Engineers, Transportation and Traffic Engineers and
                    Planners, Urban Planners and Environmental Experts.
                <p>


            </div>

        </div>

    </section>
    <section class="filler">
    </section>
    <section class="filler" style="background-color: #658347;">
        <hr>
        <a href="/dpa" target="_blank" style="color:white; font-weight: bold; font-size: 16px;" class="ml-4">Data Privacy</a>
        <br>
        <a href="#contact_us_section"  style="color:white; font-weight: bold; font-size: 16px;" class="ml-4">Contact Us</a>
    </section>

    <script>
        function startCarousel() {
            const carouselItems = document.querySelectorAll('.carousel-item');
            let activeIndex = 0;

            setInterval(() => {
                carouselItems[activeIndex].classList.remove('active');
                carouselItems[activeIndex].classList.add('fade-in');
                activeIndex = (activeIndex + 1) % carouselItems.length;
                carouselItems[activeIndex].classList.add('active');
                setTimeout(() => {
                        carouselItems[activeIndex].classList.remove('fade-in');
                    },
                    1500
                ); // Adjust the duration of the fade-in animation (in milliseconds) to match the animation keyframes
            }, 3000); // Adjust the interval duration (in milliseconds) for the desired carousel transition
        }

        startCarousel();


        // 






        // Disable horizontal swipe behavior on mobile
        document.addEventListener('touchstart', handleTouchStart, false);
        document.addEventListener('touchmove', handleTouchMove, false);

        let xDown = null;
        let yDown = null;

        function handleTouchStart(evt) {
            xDown = evt.touches[0].clientX;
            yDown = evt.touches[0].clientY;
        }

        function handleTouchMove(evt) {
            if (!xDown || !yDown) {
                return;
            }

            const xUp = evt.touches[0].clientX;
            const yUp = evt.touches[0].clientY;

            const xDiff = xDown - xUp;
            const yDiff = yDown - yUp;

            if (Math.abs(xDiff) > Math.abs(yDiff)) {
                // Most significant direction
                evt.preventDefault();
            }

            // Reset values
            xDown = null;
            yDown = null;
        }


        try {
            document.getElementById('sign_up_btn').addEventListener('click', function() {
                window.location.href = '/register';
            });
        } catch (error) {

        }


        let startX;

        document.addEventListener('touchstart', function(event) {
            startX = event.touches[0].pageX;
        });




        document.addEventListener('touchmove', function(event) {
            // const deltaX = startX - currentX;
            // const currentX = event.touches[0].pageX;

            if (Math.abs(event.changedTouches[0].clientX) > 250) {
                console.log(event.changedTouches[0].clientX)
                const scrollContainer = document.querySelector(
                    '#home_section'); // Replace with your element selector
                scrollContainer.scrollLeft = 0;
                // event.preventDefault();





            }
        });

        document.addEventListener('touchmove', function(event) {
            const scrollableElement = document.documentElement; // Change this to your desired scrollable element
            const scrollTop = scrollableElement.scrollTop;
            const scrollHeight = scrollableElement.scrollHeight;
            const clientHeight = scrollableElement.clientHeight;

            if ((scrollTop === 0 && event.deltaY < 0) || (scrollTop + clientHeight >= scrollHeight && event.deltaY >
                    0)) {
                event.preventDefault();
            }
        });


        // Detect if the browser supports overscroll-behavior
        if ('overscrollBehavior' in document.documentElement.style) {
            console.log('OVER')
            // Apply overscroll-behavior property to the HTML and body elements
            document.documentElement.style.overscrollBehavior = 'none';
            document.body.style.overscrollBehavior = 'none';
            event.preventDefault();

        }
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
    

    <h2>3. Accepting Cookies:</h2>
    <p>We use cookies to enhance your experience on our website. By clicking "Close" or continuing to use our site, you agree to our use of cookies. For more information</p>
    

    <h2>4. Data Security:</h2>
    <p>We take the security of your data seriously and have implemented the following measures:</p>
    
        <p>Encryption: Data transmitted to and from our services, including API interactions, is encrypted using secure protocols.</p>
        <p>Access Control: We restrict access to your data to authorized personnel only.</p>
        <p>Regular Security Audits: We conduct security audits to identify and address potential vulnerabilities.</p>
        <p>Data Backup: We regularly back up data to prevent data loss in case of unexpected events.</p>
    

    <h2>5. API Access on dmiph.online:</h2>
    <p>Access to our API is restricted to the dmiph.online site. We ensure that:</p>
    
        <p>API Access Control: We use access controls and authentication methods to verify that API access is granted only to authorized users and systems.</p>
        <p>Continuous Monitoring: Our security team constantly monitors API access to detect and respond to any unauthorized or suspicious activity.</p>
        <p>Data Transmission Security: API data transmitted to and from dmiph.online is encrypted to protect it from interception or tampering.</p>
    

    <h2>6. Your Rights:</h2>
    <p>You have the following rights regarding your personal information:</p>
    
        <p>The right to access and request a copy of your data.</p>
        <p>The right to rectify or update your data.</p>
        <p>The right to delete your data under certain circumstances.</p>
        <p>The right to object to the processing of your data.</p>
    

    <h2>7. Contact Information:</h2>
    <p>If you have any questions, concerns, or requests regarding your data or our data privacy practices, please contact us at [Contact Email/Phone Number].</p>

    <h2>8. Changes to This Privacy Notice:</h2>
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