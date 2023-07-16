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
</style>

<nav
    class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-light navbar-shadow {{ $configData['navbarColor'] }}">
    <div class="navbar-wrapper " style="">
        <div class="navbar-container content">
            <div>
                <div class="mr-auto  bookmark-wrapper d-flex align-items-center">
                    <img src="http://127.0.0.1:8000/images/core_cust.png" alt=""
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
            <div>
                {{-- <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center"hidden>
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto"><a
                                class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                    class="ficon feather icon-menu"></i></a></li>
                    </ul>


                </div> --}}


                <div class="row mr-auto  bookmark-wrapper d-flex align-items-center text-color">
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
    document.getElementById('book_btn').addEventListener('click', function() {
        window.location.href = 'http://127.0.0.1:8000/survey_history/create';
    });

    document.getElementById('register_btn').addEventListener('click', function() {
        window.location.href = 'http://127.0.0.1:8000/register';
    });


    
    window.addEventListener('scroll', function() {
        var navbar = document.getElementById('menu_nav');
        var scrollPosition = window.scrollY;

        if (scrollPosition > 90) {
            navbar.classList.add('navbar-fixed');
        } else {
            navbar.classList.remove('navbar-fixed');
        }
    });
</script>
