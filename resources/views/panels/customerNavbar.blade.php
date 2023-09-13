<style>
    .text-color {
        color: #6f6b7d !important;
    }

    .navbar-fixed {
        position: fixed;
        top: 0;
        width: 100%;
        /* Additional styles for the fixed navbar */
    }





    /*
    body {
        margin: 0;
        font-family: Arial, sans-serif;
    }

    header {
        background-color: #333;
        color: #fff;
        padding: 10px;
    } */

    .mobile-menu {
        /* display: flex; */
        align-items: center;
        justify-content: space-between;
    }

    .menu-items {
        display: none;
    }

    .menu-items ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .menu-items li {
        padding: 10px;
    }

    .menu-items li a {
        color: #fff;
        text-decoration: none;
    }

    /* Media query to show the menu on smaller screens */
    @media screen and (max-width: 768px) {
        .menu-toggle {
            display: block;
        }

        .menu-items {
            display: none;
        }

        .menu-items.show {
            display: block;
        }
    }




    .container_bar {
        display: inline-block;
        cursor: pointer;
    }

    .bar1,
    .bar2,
    .bar3 {
        width: 35px;
        height: 5px;
        background-color: #333;
        margin: 6px 0;
        transition: 0.4s;
    }

    .change .bar1 {
        transform: translate(0, 11px) rotate(-45deg);
    }

    .change .bar2 {
        opacity: 0;
    }

    .change .bar3 {
        transform: translate(0, -11px) rotate(45deg);
    }

    @media screen and (min-width: 768px) {
    .container_bar {
        display: none;
    }
}
</style>

<nav
    class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-light navbar-shadow {{ $configData['navbarColor'] }}">
    <div class="row navbar-wrapper " style="">
        <div class="col-lg-12 col-md-6 col-sm-2 navbar-container content">
            <div>
                <div class="mr-auto  bookmark-wrapper d-flex align-items-center">
                    <img src="/images/core_cust.png" alt=""
                        style="height: 60px;
                    width: 130px;">

                    <div class="carousel">
                        <div class="carousel-item active">
                            <img src="/images/parallax1.jpg" alt="">
                        </div>
                        <div class="carousel-item">
                            <img src="/images/parallax1.jpg" alt="">
                        </div>
                        <div class="carousel-item">
                            <img src="/images/parallax3.webp" alt="">
                        </div>
                    </div>
                </div>

                <center>
                    <h2>DMI MANAGEMENT AND ENGINEERING CONSULTANT</h2>
                    <center>


            </div>
            <hr>

        </div>
    </div>
</nav>
<nav id="menu_nav"
    class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-light {{ $configData['navbarColor'] }}">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            {{-- class="navbar-collapse" id="navbar-mobile" --}}



            <div class="mobile-menu">
                {{-- <button class="menu-toggle" onclick="toggleMenu()">Menu</button> --}}
                <div class="container_bar" onclick="myFunction(this)">
                    <div class="bar1"></div>
                    <div class="bar2"></div>
                    <div class="bar3"></div>
                </div>
                <center>

                    <nav class="menu-items" id="menuItems" style="color:black;">
                        <div class="col-md-3" style="text-align: center; line-height: 2;">
                            <button class="btn btn-secondary waves-effect waves-light text-color"
                                id="home_btn_mobile">Home</button>
                        </div>
                        <div class="col-md-3" style="text-align: center; line-height: 2;">
                            <button class="btn btn-secondary waves-effect waves-light text-color"
                                id="book_btn_mobile">Book</button>
                        </div>
                        <div class="col-md-3" style="text-align: center; line-height: 2;">
                            <button class="btn btn-secondary waves-effect waves-light text-color"
                                id="register_btn_mobile">Register</button>
                        </div>
                        <div class="col-md-3" style="text-align: center; line-height: 2;">
                            <button class="btn btn-secondary waves-effect waves-light text-color"
                                id="contact_btn_mobile">Contact
                                Us</button>
                        </div>
                        <div class="col-md-3" style="text-align: center; line-height: 2;">
                            <button class="btn btn-secondary waves-effect waves-light text-color"
                                id="about_us_btn_mobile">About
                                Us</button>
                        </div>

                    </nav>
                </center>
            </div>







            <div>
                {{-- <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center"hidden>
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto"><a
                                class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                    class="ficon feather icon-menu"></i></a></li>
                    </ul>


                </div> --}}


                <div id="navigation_wrapper" class="row mr-auto bookmark-wrapper d-flex align-items-center text-color"
                    hidden>
                    <div class="col-m-4">
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        {{-- class="btn btn-primary waves-effect waves-light" --}}
                    </div>
                    <div class="col-md-2 " style="text-align: center; line-height: 2;">
                        <button class="btn btn-secondary waves-effect waves-light text-color"
                            id="home_btn">Home</button>
                    </div>
                    <div class="col-md-2 " style="text-align: center; line-height: 2;">
                        <button class="btn btn-secondary waves-effect waves-light text-color"
                            id="book_btn">Book</button>
                    </div>
                    <div class="col-md-2 " style="text-align: center; line-height: 2;">
                        <button class="btn btn-secondary waves-effect waves-light text-color"
                            id="register_btn">Register</button>
                    </div>
                    <div class="col-md-2 " style="text-align: center; line-height: 2;">
                        <button class="btn btn-secondary waves-effect waves-light text-color" id="contact_btn">Contact
                            Us</button>
                    </div>
                    <div class="col-md-2 " style="text-align: center; line-height: 2;">
                        <button class="btn btn-secondary waves-effect waves-light text-color" id="about_us_btn">About
                            Us</button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</nav>
<script>
    try {
        document.getElementById('book_btn').addEventListener('click', function() {
            window.location.href = '/survey_history/create';
        });

        document.getElementById('register_btn').addEventListener('click', function() {
            window.location.href = '/register';
        });
    } catch (error) {

    }




    window.addEventListener('scroll', function() {
        var navbar = document.getElementById('menu_nav');
        var scrollPosition = window.scrollY;

        if (scrollPosition > 90) {
            navbar.classList.add('navbar-fixed');
        } else {
            navbar.classList.remove('navbar-fixed');
        }
    });


    function toggleMenu() {
        var menuItems = document.getElementById("menuItems");
        menuItems.classList.toggle("show");
    }




    function hideNavigationWrapperOnMobile() {
        var navigationWrapper = document.getElementById("navigation_wrapper");
        console.log(window.innerWidth)
        if (window.innerWidth <= 768) { // Adjust the breakpoint as per your needs
            navigationWrapper.style.display = "none !important";
            navigationWrapper.classList.remove("d-flex");
            console.log('d-flex')
        } else {

            navigationWrapper.style.display = "block !important";
            navigationWrapper.classList.add("d-flex");
        }
    }

    // Call the function on page load and on window resize
    hideNavigationWrapperOnMobile();
    window.addEventListener("resize", hideNavigationWrapperOnMobile);


    function myFunction(x) {

        toggleMenu()
        x.classList.toggle("change");
    }




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



        try {


            scrollToSection('home_btn_mobile', 'home_section_section');
            scrollToSection('contact_btn_mobile', 'contact_us_section');
            scrollToSection('about_us_btn_mobile', 'about_us_section');
            document.getElementById('register_btn_mobile').addEventListener('click', function() {
                window.location.href = '/register';
            });



            document.getElementById('book_btn_mobile').addEventListener('click', function() {
                window.location.href = '/survey_history/create';
            });

        } catch (error) {

        }







    });


</script>
