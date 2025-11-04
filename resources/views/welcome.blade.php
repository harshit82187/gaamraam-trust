 <!DOCTYPE html>
 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Gaam Raam Trust</title>
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
     <link rel="stylesheet" href="{{asset('front/css/responsive1.css')}}">
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
         <section class="banner">
             <div class="container">
                 <div id="carouselExampleCaptions" class="carousel slide">
                     <div class="carousel-indicators">
                         <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                         <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                         <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                     </div>
                     <div class="carousel-inner">
                         <div class="carousel-item active">
                             <div class="row">
                                 <div class="col-md-7">
                                     <div class="carousel_content">
                                         <h2>Change begins with  <span> education. </span></h2>
                                         <p>Free coaching by Gamram Charitable Trust in your village and block.</p>
                                         <div class="btn_group">
                                             <a type="button" href="{{url('connect_with_us')}}" class="custom_btn btn" url>Connect With Us</a>
                                             <a type="button" href="{{url('connect_with_us')}}"  class="custom_outline_btn btn">Enroll Now</a>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-md-5">
                                     <!-- <div class="carousel_img">
                                         <img src="{{asset('front/images/banner_image.png')}}" class="d-block w-100" alt="...">
                                     </div> -->
                                     <div class="enroll_now_f">
                                        <h5>Enter your details and our experts will get in touch with you shortly!</h5>
                                        <form action="#">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="name" aria-describedby="name" placeholder="Enter your Name">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="email" aria-describedby="email" placeholder="Enter your Email">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="phone" aria-describedby="phone" placeholder="+91-1234567990">
                                            </div>
                                            <div class="form-group">
                                                <select name="course" id="course">
                                                    <option value="Course_1" selected>Courses</option>
                                                    <option value="Course_upse" >UPSC</option>
                                                    <option value="Course_ssc" >SSC</option>
                                                </select>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" id="terms" name="terms" value="terms">
                                                <p>I authorize Online Manipal and its associates to contact me with updates & notifications via email, SMS, WhatsApp, and voice call. This consent will override any registration for DNC / NDNC.</p>
                                            </div>
                                            <a type="button" href="{{url('connect_with_us')}}"  class="custom_outline_btn btn">Enroll Now</a>
                                        </form>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="carousel-item">
                             <div class="row">
                                 <div class="col-md-7">
                                     <div class="carousel_content">
                                         <h2>बदलाव की शुरुआत शिक्षा के <span> साथ </span></h2>
                                         <p>गामराम चैरिटेबल ट्रस्ट द्वारा निःशुल्क कोचिंग आपके गाँव और ब्लॉक तक</p>
                                         <div class="btn_group">
                                             <button class="custom_btn btn">सदस्य बनें</button>
                                             <button class="custom_outline_btn btn">एक छात्र बनें</button>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-md-5">
                                     <div class="carousel_img">
                                         <img src="{{asset('front/images/banner_image.png')}}" class="d-block w-100" alt="...">
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="carousel-item">
                             <div class="row">
                                 <div class="col-md-7">
                                     <div class="carousel_content">
                                         <h2>बदलाव की शुरुआत शिक्षा के <span> साथ </span></h2>
                                         <p>गामराम चैरिटेबल ट्रस्ट द्वारा निःशुल्क कोचिंग आपके गाँव और ब्लॉक तक</p>
                                         <div class="btn_group">
                                             <button class="custom_btn btn">सदस्य बनें</button>
                                             <button class="custom_outline_btn btn">एक छात्र बनें</button>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-md-5">
                                     <div class="carousel_img">
                                         <img src="{{asset('front/images/banner_image.png')}}" class="d-block w-100" alt="...">
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="d-flex">
                         <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                             <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                             <span class="visually-hidden">Previous</span>
                         </button>
                         <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                             <span class="carousel-control-next-icon" aria-hidden="true"></span>
                             <span class="visually-hidden">Next</span>
                         </button>
                     </div>
                 </div>
             </div>
         </section>
         <section class="customers">
             <div class="container">
                 <div class="top_heading text-center mb-4">
                     <h3 class="section_heading">हमारे ग्राहक</h3>
                     <p>हम कुछ फॉर्च्यून 500+ ग्राहकों के साथ काम कर रहे हैं।</p>
                 </div>
                 <div class="customer_slider">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="custom_slider_text">
                                <h3>Learn with Our <span>Partners</span></h3>
                            </div>
                        </div>
                        <div class="col-md-10">
                        <div class="swiper mySwiper customer_swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{asset('front/images/customer_1.png')}}" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{asset('front/images/customer_2.png')}}" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{asset('front/images/customer_3.png')}}" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{asset('front/images/customer_4.png')}}" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{asset('front/images/customer_5.png')}}" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{asset('front/images/customer_6.png')}}" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{asset('front/images/customer_1.png')}}" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{asset('front/images/customer_2.png')}}" alt="">
                                </div>
                            </div>
                         <div class="swiper-pagination"></div>
                     </div>
                        </div>
                    </div>
                 </div>
             </div>
         </section>
         <section class="apply_process">
            <div class="container">
                <ul class="ammenities_list">
                    <li class="ammenities_item">
                        <div class="img_box">
                            <img src="{{asset('front/images/customer_1.png')}}" alt="">
                        </div>
                        <div class="ammenities_content">
                            <h5>Short courses</h5>
                            <p>Acquire new abilities at your own pace with our flexible online courses.</p>
                        </div>
                    </li>
                    <li class="ammenities_item">
                        <div class="img_box">
                            <img src="{{asset('front/images/customer_1.png')}}" alt="">
                        </div>
                        <div class="ammenities_content">
                            <h5>Short courses</h5>
                            <p>Acquire new abilities at your own pace with our flexible online courses.</p>
                        </div>
                    </li>
                    <li class="ammenities_item">
                        <div class="img_box">
                            <img src="{{asset('front/images/customer_1.png')}}" alt="">
                        </div>
                        <div class="ammenities_content">
                            <h5>Short courses</h5>
                            <p>Acquire new abilities at your own pace with our flexible online courses.</p>
                        </div>
                    </li>
                </ul>
            </div>
         </section>
         <section class="image_with_text_slider">
             <div class="container">
                 <div #swiperRef="" class="swiper mySwiper image_text_swiper">
                     <div class="swiper-wrapper">
                         <div class="swiper-slide">
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="image_section">
                                         <img src="{{asset('front/images/image_text_1.png')}}" alt="">
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="content_section">
                                         <h5>जगद्गुरु शंकराचार्य स्वामिश्रीः अविमुक्तेश्वरानंदः सरस्वती जी</h5>
                                         <p>ज्योतिर्मठ के वर्तमान जगद्गुरु शंकराचार्य स्वामिश्रीः परमाराध्य परमधर्माधीश उत्तराम्नाय ज्योतिष्पीठाधीश्वर जगद्गुरु शंकराचार्य स्वामिश्रीः अविमुक्तेश्वरानन्दः सरस्वती महाराज भारत की चार दिशाओं में चार वेदों के आधार पर चार आम्नाय पीठों की स्थापना कर देश की धार्मिक व साँस्कृतिक सीमा को सुदृढ बनाया</p>
                                         <button class="btn custom_btn">और पढ़ें</button>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="swiper-slide">
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="image_section">
                                         <img src="{{asset('front/images/image_text_1.png')}}" alt="">
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="content_section">
                                         <h5>जगद्गुरु शंकराचार्य स्वामिश्रीः अविमुक्तेश्वरानंदः सरस्वती जी</h5>
                                         <p>ज्योतिर्मठ के वर्तमान जगद्गुरु शंकराचार्य स्वामिश्रीः परमाराध्य परमधर्माधीश उत्तराम्नाय ज्योतिष्पीठाधीश्वर जगद्गुरु शंकराचार्य स्वामिश्रीः अविमुक्तेश्वरानन्दः सरस्वती महाराज भारत की चार दिशाओं में चार वेदों के आधार पर चार आम्नाय पीठों की स्थापना कर देश की धार्मिक व साँस्कृतिक सीमा को सुदृढ बनाया</p>
                                         <button class="btn custom_btn">और पढ़ें</button>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="swiper-slide">
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="image_section">
                                         <img src="{{asset('front/images/image_text_1.png')}}" alt="">
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="content_section">
                                         <h5>जगद्गुरु शंकराचार्य स्वामिश्रीः अविमुक्तेश्वरानंदः सरस्वती जी</h5>
                                         <p>ज्योतिर्मठ के वर्तमान जगद्गुरु शंकराचार्य स्वामिश्रीः परमाराध्य परमधर्माधीश उत्तराम्नाय ज्योतिष्पीठाधीश्वर जगद्गुरु शंकराचार्य स्वामिश्रीः अविमुक्तेश्वरानन्दः सरस्वती महाराज भारत की चार दिशाओं में चार वेदों के आधार पर चार आम्नाय पीठों की स्थापना कर देश की धार्मिक व साँस्कृतिक सीमा को सुदृढ बनाया</p>
                                         <button class="btn custom_btn">और पढ़ें</button>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="swiper-slide">
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="image_section">
                                         <img src="{{asset('front/images/image_text_1.png')}}" alt="">
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="content_section">
                                         <h5>जगद्गुरु शंकराचार्य स्वामिश्रीः अविमुक्तेश्वरानंदः सरस्वती जी</h5>
                                         <p>ज्योतिर्मठ के वर्तमान जगद्गुरु शंकराचार्य स्वामिश्रीः परमाराध्य परमधर्माधीश उत्तराम्नाय ज्योतिष्पीठाधीश्वर जगद्गुरु शंकराचार्य स्वामिश्रीः अविमुक्तेश्वरानन्दः सरस्वती महाराज भारत की चार दिशाओं में चार वेदों के आधार पर चार आम्नाय पीठों की स्थापना कर देश की धार्मिक व साँस्कृतिक सीमा को सुदृढ बनाया</p>
                                         <button class="btn custom_btn">और पढ़ें</button>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <!-- <div class="swiper-button-next"></div>
                     <div class="swiper-button-prev"></div>  -->
                     <div class="swiper-pagination"></div>
                 </div>
             </div>
         </section>
         <section class="courses">
            <div class="container">
                <div class="top_heading text-center mb-4">
                    <h5>OUR COURSES</h5>
                    <h3 class="section_heading">Explore top <span>courses</span></h3>
                </div>
                <div class="course_slider">
                    <div class="swiper mySwiper course_swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <a href="#">
                                <div class="course_item">
                                    <img src="https://eduma.thimpress.com/demo-online-learning/wp-content/uploads/sites/104/2022/10/lp-course-01-666x450.jpg" alt=""> 
                                    <div class="course_badge">Design</div>
                                    <div class="course_content">
                                        <div class="price_section">
                                            <div class="category_badge">Expert</div>
                                            <div class="amount">
                                                <span><strong>$30</strong>PH</span>
                                            </div>
                                        </div>
                                        <h3>Lorem ipsum dolor sit amet consectetur adipisicing.</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis nihil iure culpa error enim incidunt tenetur doloremque minima necessitatibus quod.</p>
                                        <div class="student_detail">
                                            <div class="detail_item">
                                                <span>36 Students</span>
                                            </div>
                                            <div class="detail_item">
                                                <span>5 Lessons</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="#">
                                <div class="course_item">
                                    <img src="https://eduma.thimpress.com/demo-online-learning/wp-content/uploads/sites/104/2022/10/lp-course-01-666x450.jpg" alt=""> 
                                    <div class="course_badge">Design</div>
                                    <div class="course_content">
                                        <div class="price_section">
                                            <div class="category_badge">Expert</div>
                                            <div class="amount">
                                                <span><strong>$30</strong>PH</span>
                                            </div>
                                        </div>
                                        <h3>Lorem ipsum dolor sit amet consectetur adipisicing.</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis nihil iure culpa error enim incidunt tenetur doloremque minima necessitatibus quod.</p>
                                        <div class="student_detail">
                                            <div class="detail_item">
                                                <span>36 Students</span>
                                            </div>
                                            <div class="detail_item">
                                                <span>5 Lessons</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="#">
                                <div class="course_item">
                                    <img src="https://eduma.thimpress.com/demo-online-learning/wp-content/uploads/sites/104/2022/10/lp-course-01-666x450.jpg" alt=""> 
                                    <div class="course_badge">Design</div>
                                    <div class="course_content">
                                        <div class="price_section">
                                            <div class="category_badge">Expert</div>
                                            <div class="amount">
                                                <span><strong>$30</strong>PH</span>
                                            </div>
                                        </div>
                                        <h3>Lorem ipsum dolor sit amet consectetur adipisicing.</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis nihil iure culpa error enim incidunt tenetur doloremque minima necessitatibus quod.</p>
                                        <div class="student_detail">
                                            <div class="detail_item">
                                                <span>36 Students</span>
                                            </div>
                                            <div class="detail_item">
                                                <span>5 Lessons</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="#">
                                <div class="course_item">
                                    <img src="https://eduma.thimpress.com/demo-online-learning/wp-content/uploads/sites/104/2022/10/lp-course-01-666x450.jpg" alt=""> 
                                    <div class="course_badge">Design</div>
                                    <div class="course_content">
                                        <div class="price_section">
                                            <div class="category_badge">Expert</div>
                                            <div class="amount">
                                                <span><strong>$30</strong>PH</span>
                                            </div>
                                        </div>
                                        <h3>Lorem ipsum dolor sit amet consectetur adipisicing.</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis nihil iure culpa error enim incidunt tenetur doloremque minima necessitatibus quod.</p>
                                        <div class="student_detail">
                                            <div class="detail_item">
                                                <span>36 Students</span>
                                            </div>
                                            <div class="detail_item">
                                                <span>5 Lessons</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="#">
                                <div class="course_item">
                                    <img src="https://eduma.thimpress.com/demo-online-learning/wp-content/uploads/sites/104/2022/10/lp-course-01-666x450.jpg" alt=""> 
                                    <div class="course_badge">Design</div>
                                    <div class="course_content">
                                        <div class="price_section">
                                            <div class="category_badge">Expert</div>
                                            <div class="amount">
                                                <span><strong>$30</strong>PH</span>
                                            </div>
                                        </div>
                                        <h3>Lorem ipsum dolor sit amet consectetur adipisicing.</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis nihil iure culpa error enim incidunt tenetur doloremque minima necessitatibus quod.</p>
                                        <div class="student_detail">
                                            <div class="detail_item">
                                                <span>36 Students</span>
                                            </div>
                                            <div class="detail_item">
                                                <span>5 Lessons</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                 </div>
            </div>
         </section>
         <section class="image_with_text_slider">
             <div class="container">
                 <div class="row">
                     <div class="col-md-6">
                         <div class="image_section">
                             <img src="{{asset('front/images/image_with_text_2.png')}}" alt="" style="max-width: fit-content;">
                         </div>
                     </div>
                     <div class="col-md-6">
                         <div class="content_section">
                             <h5>गामराम चैरिटेबल ट्रस्ट का उद्देश्य</h5>
                             <p>यह पहल इस विचार से प्रेरित है कि हर अभ्यर्थी अपनी क्षमता का पूरा उपयोग कर सके और अपने लक्ष्य को प्राप्त करने के लिए सभी संसाधनों से सुसज्जित हो, हमारे द्वारा हरियाणा के सभी 143 ब्लॉकों में निःशुल्क कोचिंग सेंटर खोले जा रहे है.
                                 प्रत्येक कोचिंग सेंटर में दो बैच संचालित किए जाएंगे, जहां पहले बैच में UPSC और HPSC परीक्षाओ की तैयारी कराई जाएगी, और दूसरे बैच में SSC और HSSC परीक्षाओ पर फोकस होगा प्रत्येक बैच में 100 सीटें उपलब्ध होंगी, ताकि I प्रतिभाशाली अभ्यर्थियों को बेहतर मार्गदर्शन और उच्च गुणवत्ता वाली तैयारी का अवसर प्रदान किया जा सके यह व्यवस्था छात्रों को उनके लक्ष्य की ओर अग्रसर होने में मजबूती प्रदान करेगी.</p>
                             <button class="btn custom_btn">और पढ़ें</button>
                         </div>
                     </div>
                 </div>
             </div>
         </section>
         <section class="apply_process">
             <div class="container">
                 <div class="row">
                     <div class="col-md-6">
                         <div class="content_section">
                             <h5>आवेदन और चयन प्रक्रिया</h5>
                             <p>ऑनलाइन रजिस्ट्रेशन एवं इंटरव्यू .</p>
                             <button class="btn custom_btn">और पढ़ें</button>
                         </div>
                     </div>
                     <div class="col-md-6">
                         <div class="process_points">
                             <ul>
                                 <li>
                                     <div class="process_item">
                                         <img src="{{asset('front/images/policy_1.svg')}}" alt="">
                                         <div class="item_content">
                                             <h5>संकल्प</h5>
                                             <a href="#">
                                                 <p>और पढ़ें</p>
                                             </a>
                                         </div>
                                     </div>
                                 </li>
                                 <li>
                                     <div class="process_item">
                                         <img src="{{asset('front/images/policy_2.svg')}}" alt="">
                                         <div class="item_content">
                                             <h5>दृष्टि</h5>
                                             <a href="#">
                                                 <p>और पढ़ें</p>
                                             </a>
                                         </div>
                                     </div>
                                 </li>
                                 <li>
                                     <div class="process_item">
                                         <img src="{{asset('front/images/policy_3.svg')}}" alt="">
                                         <div class="item_content">
                                             <h5>IAS और IPS</h5>
                                             <a href="#">
                                                 <p>और पढ़ें</p>
                                             </a>
                                         </div>
                                     </div>
                                 </li>
                                 <li>
                                     <div class="process_item">
                                         <img src="{{asset('front/images/policy_1.svg')}}" alt="">
                                         <div class="item_content">
                                             <h5>कक्षाएं</h5>
                                             <a href="#">
                                                 <p>और पढ़ें</p>
                                             </a>
                                         </div>
                                     </div>
                                 </li>
                             </ul>
                         </div>
                     </div>
                 </div>
             </div>
         </section>
         <section class="application">
             <div class="container">
                 <div class="top_heading text-center mb-5">
                     <h3 class="section_heading">आवेदन और चयन प्रक्रिया</h3>
                     <p>ऑनलाइन रजिस्ट्रेशन एवं इंटरव्यू</p>
                 </div>
                 <div class="row pt-4">
                     <div class="col-md-4">
                         <div class="aplication_items">
                             <img src="{{asset('front/images/policy_1.svg')}}" alt="">
                             <h5>वेबसाइट पर जाएं</h5>
                             <p>सभी इच्छुक अभ्यर्थी हमारी वेबसाइट gaamraam.ngo पर जाकर अपना ऑनलाइन रजिस्ट्रेशन कर सकते हैं रजिस्ट्रेशन के बाद, एक ऑनलाइन इंटरव्यू आयोजित किया जाएगा, जिसमें छात्रों की पढ़ाई के प्रति गंभीरता और समर्पण को परखा जाएगा।</p>
                         </div>
                     </div>
                     <div class="col-md-4">
                         <div class="aplication_items">
                             <img src="{{asset('front/images/policy_1.svg')}}" alt="">
                             <h5>ऑनलाइन जुड़ें</h5>
                             <p>संचालित होंगी अनुभवी शिक्षक नरूप से
                                 संचालित होंगी अनुभवी शिक्षक नियमित रूप से छात्रों को पढ़ाएंगे और परीक्षा की रणनीतियों पर मार्गदर्शन देंगे कक्षाओ में अनुशासन और नियमित उपस्थिति अनिवार्य होगी। समय-समय पर IAS और IPS अधिकारियों द्वारा विशेष सत्र </p>
                         </div>
                     </div>
                     <div class="col-md-4">
                         <div class="aplication_items">
                             <img src="{{asset('front/images/policy_1.svg')}}" alt="">
                             <h5>ऑनलाइन जुड़ें</h5>
                             <p>संचालित होंगी अनुभवी शिक्षक नरूप से
                                 संचालित होंगी अनुभवी शिक्षक नियमित रूप से छात्रों को पढ़ाएंगे और परीक्षा की रणनीतियों पर मार्गदर्शन देंगे कक्षाओ में अनुशासन और नियमित उपस्थिति अनिवार्य होगी। समय-समय पर IAS और IPS अधिकारियों द्वारा विशेष सत्र </p>
                         </div>
                     </div>
                 </div>
             </div>
         </section>
         <section class="registration_section">
             <div class="container">
                 <div class="row">
                     <div class="col-md-6">
                         <div class="registration_img">
                             <img src="{{asset('front/images/registration.png')}}" alt="">
                         </div>
                     </div>
                     <div class="col-md-6">
                         <div class="registration_content">
                             <h3>अभ्यर्थी हमारी वेबसाइट पर ऑनलाइन रजिस्ट्रेशन कर सकते हैं।</h3>
                             <button class="custom_btn btn mb-4">अभी अप्लाई करें</button>
                             <p>अभी आवेदन करें, इंतजार न करें, जाएं।</p>
                             <ul class="icon_list">
                                 <li>
                                     <img src="{{asset('front/images/customer_1.png')}}" alt="">
                                 </li>
                                 <li>
                                     <img src="{{asset('front/images/customer_2.png')}}" alt="">
                                 </li>
                                 <li>
                                     <img src="{{asset('front/images/customer_3.png')}}" alt="">
                                 </li>
                                 <li>
                                     <img src="{{asset('front/images/customer_4.png')}}" alt="">
                                 </li>
                                 <li>
                                     <img src="{{asset('front/images/customer_5.png')}}" alt="">
                                 </li>
                                 <li>
                                     <img src="{{asset('front/images/customer_6.png')}}" alt="">
                                 </li>
                             </ul>
                         </div>
                     </div>
                 </div>
             </div>
         </section>
         <!-- <section class="contact_us">
            <div class="container">
                <h2>Contact Us</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="contact_form">
                            <h5>Leave us a Message</h5>
                            <form action="#">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" class="form-control" id="name" aria-describedby="nam">
                                </div>
                                <div class="form-group">
                                    <label for="email_address">Email Address</label>
                                    <input type="text" class="form-control" id="email_address" aria-describedby="email_address">
                                </div>
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea name="message" id="message" rows="5"></textarea>
                                </div>
                                <button class="custom_btn btn mx-2">Submit</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contact_content">
                            <p>Weekend UX</p>
                            <p>B 37/3 Ground Floor Double Story Ramesh Nagar, Near Raja Garden Chowk, Delhi 110015</p>
                            <p><a href="tel:+919599272754">+91 9599272754</a></p>
                            <p><a href="mail:">hello@info.com.ng</a></p>
                            <ul class="social_icons">
                                <li><a href="#"></a></li>
                            </ul>
                            <img src="{{asset('front/images/contact_us_img.png')}}" alt="contact_us_img">
                        </div>
                    </div>
                </div>
            </div>
         </section> -->
         <section class="testimonial">
             <div class="container">
                 <div class="top_heading text-center mb-4">
                    <h5>STUDENTS SAY</h5>
                    <h3 class="section_heading">Satisfaction is always present</h3>
                 </div>
                 <div class="tesimonial_slider">
                     <div class="swiper mySwiper testimonial_swiper">
                         <div class="swiper-wrapper">
                             <div class="swiper-slide">
                                 <div class="testimonial_item">
                                     <div class="profile_detail">
                                         <img src="{{asset('front/images/customer_1.png')}}" alt="">
                                         <div class="profile_content">
                                             <h5>Pensive Tesla</h5>
                                             <span>15K Students</span>
                                         </div>
                                     </div>
                                     <div class="profile_description">
                                         <p>"I recommend Futurelearn to anyone looking to learn and upskill...If you are in the job market, you might want to add a new skill or forge a new path."</p>
                                         <div class="ratings">
                                             <i class="fa-solid fa-star"></i>
                                             <i class="fa-solid fa-star"></i>
                                             <i class="fa-solid fa-star"></i>
                                             <i class="fa-solid fa-star"></i>
                                             <i class="fa-solid fa-star"></i>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="swiper-slide">
                                 <div class="testimonial_item">
                                     <div class="profile_detail">
                                         <img src="{{asset('front/images/customer_1.png')}}" alt="">
                                         <div class="profile_content">
                                             <h5>Pensive Tesla</h5>
                                             <span>15K Students</span>
                                         </div>
                                     </div>
                                     <div class="profile_description">
                                         <p>"I recommend Futurelearn to anyone looking to learn and upskill...If you are in the job market, you might want to add a new skill or forge a new path."</p>
                                         <div class="ratings">
                                             <i class="fa-solid fa-star"></i>
                                             <i class="fa-solid fa-star"></i>
                                             <i class="fa-solid fa-star"></i>
                                             <i class="fa-solid fa-star"></i>
                                             <i class="fa-solid fa-star"></i>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="swiper-slide">
                                 <div class="testimonial_item">
                                     <div class="profile_detail">
                                         <img src="{{asset('front/images/customer_1.png')}}" alt="">
                                         <div class="profile_content">
                                             <h5>Pensive Tesla</h5>
                                             <span>15K Students</span>
                                         </div>
                                     </div>
                                     <div class="profile_description">
                                         <p>"I recommend Futurelearn to anyone looking to learn and upskill...If you are in the job market, you might want to add a new skill or forge a new path."</p>
                                         <div class="ratings">
                                             <i class="fa-solid fa-star"></i>
                                             <i class="fa-solid fa-star"></i>
                                             <i class="fa-solid fa-star"></i>
                                             <i class="fa-solid fa-star"></i>
                                             <i class="fa-solid fa-star"></i>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="swiper-slide">
                                 <div class="testimonial_item">
                                     <div class="profile_detail">
                                         <img src="{{asset('front/images/customer_1.png')}}" alt="">
                                         <div class="profile_content">
                                             <h5>Pensive Tesla</h5>
                                             <span>15K Students</span>
                                         </div>
                                     </div>
                                     <div class="profile_description">
                                         <p>"I recommend Futurelearn to anyone looking to learn and upskill...If you are in the job market, you might want to add a new skill or forge a new path."</p>
                                         <div class="ratings">
                                             <i class="fa-solid fa-star"></i>
                                             <i class="fa-solid fa-star"></i>
                                             <i class="fa-solid fa-star"></i>
                                             <i class="fa-solid fa-star"></i>
                                             <i class="fa-solid fa-star"></i>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="swiper-slide">
                                 <div class="testimonial_item">
                                     <div class="profile_detail">
                                         <img src="{{asset('front/images/customer_1.png')}}" alt="">
                                         <div class="profile_content">
                                             <h5>Pensive Tesla</h5>
                                             <span>15K Students</span>
                                         </div>
                                     </div>
                                     <div class="profile_description">
                                         <p>"I recommend Futurelearn to anyone looking to learn and upskill...If you are in the job market, you might want to add a new skill or forge a new path."</p>
                                         <div class="ratings">
                                             <i class="fa-solid fa-star"></i>
                                             <i class="fa-solid fa-star"></i>
                                             <i class="fa-solid fa-star"></i>
                                             <i class="fa-solid fa-star"></i>
                                             <i class="fa-solid fa-star"></i>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="swiper-pagination"></div>
                     </div>
                 </div>
             </div>
         </section>
         <section class="newsletter">
             <div class="container">
                 <div class="newsletter_section">
                     <div class="row">
                         <div class="col-md-7">
                             <div class="newsletter_content">
                                 <span></span>
                                 <h3>अभ्यर्थी हमारी वेबसाइट पर ऑनलाइन रजिस्ट्रेशन कर सकते हैं।</h3>
                                 <input type="search" placeholder="search Courses" class="form-control">
                             </div>
                         </div>
                         <div class="col-md-5">
                             <div class="newsletter_img">
                                 <img src="{{asset('front/images/registration.png')}}" alt="newsletter_img">
                             </div>
                         </div>
                     </div>
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
                                 <a href="#">Contact</a>
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


     <script>
         var swiper = new Swiper(".customer_swiper", {
             slidesPerView: 6,
             spaceBetween: 30,
             pagination: {
                 el: ".swiper-pagination",
                 clickable: true,
             },
         });
     </script>
     <script>
         var swiper = new Swiper(".testimonial_swiper", {
             slidesPerView: 3,
             spaceBetween: 30,
             loop:true,
             pagination: {
                 el: ".swiper-pagination",
                 clickable: true,
             },
         });
     </script>
     <script>
        var swiper = new Swiper(".course_swiper", {
            slidesPerView: 3,
            spaceBetween: 30,
            loop:true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
     </script>
     <script>
         var swiper = new Swiper(".image_text_swiper", {
             slidesPerView: 1,
             centeredSlides: true,
             loop: true,
             spaceBetween: 30,
             pagination: {
                 el: ".swiper-pagination",
                //  type: "dots",
                clickable: true,
             },
             navigation: {
                 nextEl: ".swiper-button-next",
                 prevEl: ".swiper-button-prev",
             },
         });

        //  var appendNumber = 4;
        //  var prependNumber = 1;
     </script>
 </body>

 </html>