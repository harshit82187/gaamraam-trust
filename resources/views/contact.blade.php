<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gaam Raam</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=
Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('front/css/style.css')}}">


</head>

<body class="antialiased">
<header>
         <nav class="navbar navbar-expand-lg">
             <div class="container">
                 <a class="navbar-brand" href="{{url('/')}}">
                     <img src="{{asset('front/images/Gaam_Raam_logo.png')}}" alt="">
                 </a>
                 <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                     <span class="navbar-toggler-icon"></span>
                 </button>
                 <div class="collapse navbar-collapse" id="navbarSupportedContent">
                     <ul class="navbar-nav m-auto mb-2 mb-lg-0 mt-0">
                         <li class="nav-item">
                             <a class="nav-link active" aria-current="page" href="{{url('/')}}">Home</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" aria-current="page" href="#">About Us</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" aria-current="page" href="#">Testimonial</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" aria-current="page" href="{{url('contact')}}">Contact Us</a>
                         </li>
                     </ul>
                     <div class="side_content">
                        <a href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
                        <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                        <a href="{{url('connect_with_us')}}" class="custom_btn btn">Connect me</a>
                     </div>
                 </div>
             </div>
         </nav>
     </header>
    <div class="main">
        <section class="quote py-5">
            <div class="container">
                <div class="row">
                    <div class="section_heading text-center border-0 mb-4">
                        <h3>CONTACT US</h3>
                        <p>Your perspective is invaluable to us. We eagerly await your input..</p>
                    </div>
                    <div class="col-md-6">
                        <img src="https://sherpabrokerage.com/assets/img/work-risk-free.svg" alt="Image work-risk-free" class="w-100">
                    </div>
                    <div class="col-md-6">
                        <form action="" method="POST">
                            <div class="right_form">
                                <div class="">
                                    <div class="contact_title">
                                        <h3>Get in touch</h3>
                                        <p>Fill out the form and we'll get back to you with a personalized quote.</p>
                                    </div>
                                    <form action="{{ route('contact-us') }}" method="POST" >
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="custom-form">
                                                    <label for="name" class="form-label">Name</label>
                                                    <div class="custom-input">
                                                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div class="col-md-12">
                                                <div class="custom-form">
                                                    <label for="phone_number" class="form-label">Phone Number</label>
                                                    <div class="custom-input">
                                                        <input type="tel" class="form-control" name="phone_number" id="phone_number" placeholder="Enter Your Phone Number" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value =
                                                        this.value.slice(0, this.maxLength);">
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div class="col-md-12">
                                                <div class="custom-form">
                                                    <label for="email_address" class="form-label">Email Address</label>
                                                    <div class="custom-input">
                                                        <input type="email" class="form-control" name="email" id="email_address" placeholder="Enter Email Address">
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div class="col-12">
                                                <div class="custom-form">
                                                    <label for="exampleFormControlTextarea" class="form-label">Brief you requirement.</label>
                                                    <div class="custom-textarea">
                                                        <textarea class="form-control" name="message" id="exampleFormControlTextarea" placeholder="Enter Your Message" rows="5"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-3">Send</button>
                                    </form>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <section class="map-section">
            <div class="container-fluid p-0">
                <div class="map-box">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3679.040780152256!2d75.8847027749467!3d22.763867825933563!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3962fd4e63771855%3A0xd25abcfc4f9af86a!2sMarks%20Print%20%5BThe%20Label%20Masters%5D!5e0!3m2!1sen!2sin!4v1738662625924!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </section>
    </div>
    <footer>
        <div class="container">
            <div class="top_footer">
                <div class="row">
                    <div class="col-md-3">
                        <ul>
                            <li class="footer_link_header">Get in touch</li>
                            <li class="footer_links_item">
                                <div class="icon_box"><i class="fa-solid fa-phone"></i></div>
                                <div class="footer_link_content">
                                    <span>Call us directly?</span>
                                    <a href="#">+1 234 567 8910</a>
                                </div>
                            </li>
                            <li class="footer_links_item">
                                <div class="icon_box"><i class="fa-solid fa-location-dot"></i></div>
                                <div class="footer_link_content">
                                    <span>Address</span>
                                    <a href="#">Howard Street, San Francisco</a>
                                </div>
                            </li>
                            <li class="footer_links_item">
                                <div class="icon_box"><i class="fa-solid fa-envelope"></i></div>
                                <div class="footer_link_content">
                                    <span>Email</span>
                                    <a href="#">contact@eduma.com</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <ul>
                            <li class="footer_link_header">Need some help?</li>
                            <li class="footer_links">
                                <a href="#">FAQs</a>
                            </li>
                            <li class="footer_links">
                                <a href="{{url('contact')}}">Contact</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <ul>
                            <li class="footer_link_header">Popular subjects</li>
                            <li class="footer_links">
                                <a href="#">Developer</a>
                            </li>
                            <li class="footer_links">
                                <a href="#">Marketing</a>
                            </li>
                            <li class="footer_links">
                                <a href="#">Business</a>
                            </li>
                            <li class="footer_links">
                                <a href="#">Design</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <ul>
                            <li class="footer_link_header">Need some help?</li>
                            <li class="footer_links">
                                <a href="#"><i class="fa-brands fa-youtube"></i>Youtube</a>
                            </li>
                            <li class="footer_links">
                                <a href="#"><i class="fa-brands fa-facebook"></i>Facebook</a>
                            </li>
                            <li class="footer_links">
                                <a href="#"><i class="fa-brands fa-instagram"></i>Instagram</a>
                            </li>
                            <li class="footer_links">
                                <a href="#"><i class="fa-brands fa-twitter"></i>Twitter</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>





    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>