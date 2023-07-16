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
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Core - @yield('title') </title>
    <link rel="shortcut icon" type="image/x-icon" href="images/logo/favicon.ico">

    {{-- Include core + vendor Styles --}}
    @include('panels/styles')

</head>

@isset($configData['mainLayoutType'])
    @extends($configData['mainLayoutType'] === 'horizontal' ? 'layouts.frontLayoutMaster' : 'layouts.frontLayoutMaster')
@endisset


@section('content')
    <style>
        body {
            overflow-x: hidden;
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
            color:white;
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
    </style>
    <section class="filler">

    </section>
    <section id="home_section">

        <div class="parallax" style=" ">

            {{-- <div class="row parallax-caption" > --}}
            <div class="col-md-6  parallax-caption"" style="background-color:rgb(66, 127, 38); line-height: 2;">
                <h1 style="color:white; opacity: 1 !important; text-align:center; line-height: 2;">
                    Welcome to DMI Survey Site</h1>
            </div>

            {{-- </div> --}}
            <div class="fade-background">
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

    </section>

    <section class="filler">

    </section>


    <section id="contact_us_section">
        <br>
        <br>
        <br>

        <center>
            <h1>Contact Us</h1>
            <hr>
            <img src="images/contactus.png" alt="">
        </center>
    </section>

    <section class="filler">

    </section>

    <section id="about_us_section" class="defaultextcolor">
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
                <p class="indented-paragraph">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>DMI-MEC</strong> was established to
                    provide advice and assistance that is responsive to the
                    needs of
                    the client through an inter-disciplinary approach borne out of the collective expertise and experience
                    of its key staff.
                <p>

                <p class="indented-paragraph">

                    Its services vary which include planning and feasibility studies; detailed
                    architectural and engineering design; organization and management, and training.
                    It has provided consultancy
                    services in an array of development projects, such areas as those in transportation, housing, urban
                    and regional development planning, water supply, surveys and mapping, enterprise, architecture and
                    environmental protection.
                </p>

                <p class="indented-paragraph">

                </p>

                <p class="indented-paragraph">
                    Services are offered in every phase of project development from
                    pre-feasibility
                    and feasibility studies, master plan preparation, detailed engineering design, to construction
                    supervision
                    and management.
                </p>

                <p class="indented-paragraph">
                    Our Key Staff include Engineer Planners, Architects, Economists, Financial Experts,
                    Surveyors, Cartographers and Computer Experts, among others.
                </p>

            </div>
            <div class="col-md-6 offset-md-3" style="background-color: #8080809e;">
                <p class="indented-paragraph">

                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>The FIRM</strong> also maintains a pool of
                    Consultants compose of Civil Engineers, Hydraulic
                    Engineers,
                    Hydrologists, Electrical Engineers, Structural Engineers, Transportation and Traffic Engineers and
                    Planners, Urban Planners and Environmental Experts.
                <p>

            </div>
        </div>

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

        document.addEventListener('DOMContentLoaded', function() {
            function scrollToSection(buttonId, sectionId) {
                var button = document.getElementById(buttonId);
                var section = document.getElementById(sectionId);

                button.addEventListener('click', function() {
                    if (section) {
                        var scrollOptions = {
                            behavior: 'smooth',
                            block: 'start'
                        };

                        if (buttonId === 'home_btn') {
                            window.scrollTo({
                                top: 0, // Scroll to the top of the page
                                ...scrollOptions
                            });
                        } else {
                            window.scrollTo({
                                top: section.offsetTop,
                                ...scrollOptions
                            });
                        }
                    }
                });
            }

            scrollToSection('home_btn', 'home_section');
            scrollToSection('contact_btn', 'contact_us_section');
            scrollToSection('about_us_btn', 'about_us_section');
        });
        document.getElementById('sign_up_btn').addEventListener('click', function() {
        window.location.href = '/register';
    });

        // 
    </script>
@endsection
