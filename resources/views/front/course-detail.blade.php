@extends('front.layout.app')
@section('content')


<!-- PAGE TITLE

        ================================================== -->

<section class="page-title-section bg-img cover-background top-position1 left-overlay-dark" data-overlay-dark="9" data-background="img/bg/bg-04.jpg">

    <div class="container">

        <div class="row text-center">

            <div class="col-md-12">

                <h1>Course Details</h1>

            </div>

            <div class="col-md-12">

                <ul>

                    <li><a href="{{url('/')}}">Home</a></li>

                    <li><a href="{{url('course-detail')}}">Course Details</a></li>

                </ul>

            </div>

        </div>

    </div>

</section>



<!-- COURSES DETAILS

        ================================================== -->

<section class="courses">

    <div class="container">

        <div class="row">



            <div class="col-md-12 col-lg-8 mb-2-9 mb-lg-0">

                <div class="row">

                    <div class="col-md-12 mb-1-6 mb-md-1-9">

                        <div class="courses-info mb-4">



                            <div class="bg-light rounded py-4 px-4 mb-3">

                                <div class="section-heading mb-0 text-start">

                                    <span class="sub-title">Learning</span>

                                </div>

                                <h2 class="h1 mb-0">UPSC(Uninon Public Service Commision)</h2>

                            </div>





                        </div>

                        <figure class="mb-0">

                            <img class="border-radius-5" src="{{asset('front/img/content/courses-details-01.jpg')}}" alt="...">

                        </figure>

                    </div>

                    <div class="col-md-12 mb-1-6 mb-md-2-9">

                        <div class="horizontaltab tab-style1">

                            <ul class="resp-tabs-list hor_1">

                                <li><span class="display-block xs-display-inline-block">Discription</span></li>

                                <li><span class="display-block xs-display-inline-block">Members</span></li>

                                <li><span class="display-block xs-display-inline-block">Curriculum</span></li>

                                <li><span class="display-block xs-display-inline-block">Reviews</span></li>

                            </ul>

                            <div class="resp-tabs-container hor_1">

                                <div>

                                    <div class="row">

                                        <div class="col-md-12 mb-1-6 mb-lg-1-9">

                                            <h3>Course Overview</h3>

                                            <p class="alt-font font-weight-500 text-color mb-0">Our UPSC (Union Public Service Commission) coaching program is designed to provide aspirants with the best resources, expert guidance, and a structured study plan to crack the Civil Services Examination (CSE). This comprehensive course covers the entire UPSC syllabus, focusing on conceptual clarity, analytical skills, and answer-writing techniques.</p>

                                        </div>

                                        <div class="col-md-12 mb-1-6 mb-lg-1-9">

                                            <h3>Modes of Learning – Flexible & Accessible</h3>

                                            <p class="alt-font font-weight-500 text-color">We offer both online and offline coaching options to cater to students from different locations and backgrounds:</p>

                                            <ul class="course-detail-list">

                                                <li><i class="ti-check-box vertical-align-middle text-secondary pe-2"></i>Classroom Coaching</li>

                                                <li><i class="ti-check-box vertical-align-middle text-secondary pe-2"></i>Live Online Classes</li>

                                                <li><i class="ti-check-box vertical-align-middle text-secondary pe-2"></i>Self-Paced Learning in your Nearby Location</li>

                                                <li><i class="ti-check-box vertical-align-middle text-secondary pe-2"></i>Essay Writing Practice</li>

                                                <li><i class="ti-check-box vertical-align-middle text-secondary pe-2"></i>Prelims Mock Tests</li>
                                                <li><i class="ti-check-box vertical-align-middle text-secondary pe-2"></i>Mains Answer Writing Sessions</li>
                                                <li><i class="ti-check-box vertical-align-middle text-secondary pe-2"></i>Ethics, Integrity & Aptitude</li>
                                                <li><i class="ti-check-box vertical-align-middle text-secondary pe-2"></i>personalized mentoring</li>
                                            </ul>

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <h3>Description</h3>

                                        <p class="alt-font font-weight-500 text-color mb-0">The Union Public Service Commission (UPSC) exam is one of the most prestigious and challenging competitive exams in India. It is conducted annually to recruit officers for Indian Administrative Services (IAS), Indian Police Services (IPS), Indian Foreign Services (IFS), and other Central Government Services. To clear this exam, aspirants need structured guidance, expert mentorship, and a well-planned preparation strategy. Our UPSC coaching classes provide the perfect platform to help you achieve your dream of serving the nation.</p>
                                        <p>We understand the challenges faced by aspirants while preparing for the UPSC Civil Services Examination (CSE). Our coaching program is designed to provide:</p>
                                        <p>Our team of highly experienced educators, retired civil servants, and UPSC toppers provide strategic guidance and personalized mentoring to each student.</p>
                                        <p>Every aspirant has a different learning pace. We create personalized study plans to ensure effective time management and goal-based preparation. Additionally, regular doubt-clearing sessions help students resolve their queries instantly.</p>
                                        <p>Clearing Prelims and Mains is just part of the journey. Our UPSC Interview Guidance Program helps students develop the confidence, articulation skills, and presence of mind required for the final selection. Mock interviews with expert panels ensure that aspirants are well-prepared for the real UPSC interview.</p>
                                    </div>

                                </div>

                                <div>

                                    <div class="row mb-1-6 mb-lg-1-9 mb-xl-2-5">

                                        <div class="col-md-12">

                                            <h3>Instructor Description</h3>

                                            <p class="alt-font font-weight-500 text-color mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6 mb-1-6 mb-sm-1-9 mb-lg-0">

                                            <div class="team-style1 text-center">

                                                <img src="{{asset('front/img/team/team-01.jpg')}}" class="border-radius-5" alt="...">

                                                <div class="team-info">

                                                    <h3 class="text-primary mb-1 h4">Murilo Souza</h3>

                                                    <span class="font-weight-600 text-secondary">Web Designer</span>

                                                </div>

                                                <div class="team-overlay">

                                                    <div class="d-table h-100 w-100">

                                                        <div class="d-table-cell align-middle">

                                                            <h3><a href="#" class="text-white">About Murilo Souza</a></h3>

                                                            <p class="text-white mb-0">I preserve each companion certification and I'm an authorized AWS solutions architect professional.</p>

                                                            <ul class="social-icon-style1">

                                                                <li><a href="#!"><i class="fab fa-facebook-f"></i></a></li>

                                                                <li><a href="#!"><i class="fab fa-twitter"></i></a></li>

                                                                <li><a href="#!"><i class="fab fa-youtube"></i></a></li>

                                                                <li><a href="#!"><i class="fab fa-linkedin-in"></i></a></li>

                                                            </ul>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-6 mb-1-6 mb-sm-1-9 mb-lg-0">

                                            <div class="team-style1 text-center">

                                                <img src="{{asset('front/img/team/team-02.jpg')}}" class="border-radius-5" alt="...">

                                                <div class="team-info">

                                                    <h3 class="text-primary mb-1 h4">Balsam Samira</h3>

                                                    <span class="font-weight-600 text-secondary">Photographer</span>

                                                </div>

                                                <div class="team-overlay">

                                                    <div class="d-table h-100 w-100">

                                                        <div class="d-table-cell align-middle">

                                                            <h3><a href="#" class="text-white">About Balsam Samira</a></h3>

                                                            <p class="text-white mb-0">I preserve each companion certification and I'm an authorized AWS solutions architect professional.</p>

                                                            <ul class="social-icon-style1">

                                                                <li><a href="#!"><i class="fab fa-facebook-f"></i></a></li>

                                                                <li><a href="#!"><i class="fab fa-twitter"></i></a></li>

                                                                <li><a href="#!"><i class="fab fa-youtube"></i></a></li>

                                                                <li><a href="#!"><i class="fab fa-linkedin-in"></i></a></li>

                                                            </ul>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div>

                                    <div class="row">

                                        <div class="col-lg-12">

                                            <div id="accordion" class="accordion-style1">

                                                <div class="card">

                                                    <div class="card-header" id="headingOne">

                                                        <h5 class="mb-0">

                                                            <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">

                                                                Section 1: Welcome to the Courses

                                                            </button>

                                                        </h5>

                                                    </div>

                                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-bs-parent="#accordion">

                                                        <div class="card-body">

                                                            <ul class="curriculum-lists">

                                                                <li>

                                                                    <div class="titles">

                                                                        <i class="fas fa-play-circle"></i>

                                                                        <h3>

                                                                            Lecture 1.0

                                                                        </h3>

                                                                        <h5 class="display-29 display-lg-28 display-xl-27 mb-0">

                                                                            <a href="#!">Introduction of java</a>

                                                                        </h5>

                                                                        <div class="access-type">

                                                                            <i class="fas fa-eye"></i>

                                                                        </div>

                                                                    </div>

                                                                    <div class="intro">

                                                                        <div class="item">

                                                                            <p class="alt-font">

                                                                                Published - 15 Aug

                                                                            </p>

                                                                        </div>

                                                                        <div class="item">

                                                                            <p class="alt-font">

                                                                                Duration: 1 hours 30 min

                                                                            </p>

                                                                            <a href="#!">Preview</a>

                                                                        </div>

                                                                    </div>

                                                                </li>

                                                                <li>

                                                                    <div class="titles">

                                                                        <i class="fas fa-file"></i>

                                                                        <h3>

                                                                            Lecture 1.2

                                                                        </h3>

                                                                        <h5 class="display-29 display-lg-28 display-xl-27 mb-0">

                                                                            <a href="#!">Basic development</a>

                                                                        </h5>

                                                                        <div class="access-type">

                                                                            <i class="ti-lock"></i>

                                                                        </div>

                                                                    </div>

                                                                    <div class="intro">

                                                                        <div class="item">

                                                                            <p class="alt-font">

                                                                                Published - 28 Apr

                                                                            </p>

                                                                        </div>

                                                                        <div class="item">

                                                                            <p class="alt-font">

                                                                                Duration: 3 hour 45 min

                                                                            </p>

                                                                            <a href="#!">Preview</a>

                                                                        </div>

                                                                    </div>

                                                                </li>

                                                            </ul>

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="card">

                                                    <div class="card-header" id="headingTwo">

                                                        <h5 class="mb-0">

                                                            <button class="btn btn-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">

                                                                Section 2: How to use Java

                                                            </button>

                                                        </h5>

                                                    </div>

                                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordion">

                                                        <div class="card-body">

                                                            <ul class="curriculum-lists">

                                                                <li>

                                                                    <div class="titles">

                                                                        <i class="fas fa-play-circle"></i>

                                                                        <h3>

                                                                            Lecture 1.0

                                                                        </h3>

                                                                        <h5 class="display-29 display-lg-28 display-xl-27 mb-0">

                                                                            <a href="#!">Introduction of java</a>

                                                                        </h5>

                                                                        <div class="access-type">

                                                                            <i class="fas fa-eye"></i>

                                                                        </div>

                                                                    </div>

                                                                    <div class="intro">

                                                                        <div class="item">

                                                                            <p class="alt-font">

                                                                                Published - 15 Aug

                                                                            </p>

                                                                        </div>

                                                                        <div class="item">

                                                                            <p class="alt-font">

                                                                                Duration: 1 hour 30 min

                                                                            </p>

                                                                            <a href="#!">Preview</a>

                                                                        </div>

                                                                    </div>

                                                                </li>

                                                                <li>

                                                                    <div class="titles">

                                                                        <i class="fas fa-file"></i>

                                                                        <h3>

                                                                            Lecture 1.2

                                                                        </h3>

                                                                        <h5 class="display-29 display-lg-28 display-xl-27 mb-0">

                                                                            <a href="#!">Basic development</a>

                                                                        </h5>

                                                                        <div class="access-type">

                                                                            <i class="ti-lock"></i>

                                                                        </div>

                                                                    </div>

                                                                    <div class="intro">

                                                                        <div class="item">

                                                                            <p class="alt-font">

                                                                                Published - 28 Apr

                                                                            </p>

                                                                        </div>

                                                                        <div class="item">

                                                                            <p class="alt-font">

                                                                                Duration: 3 hour 45 min

                                                                            </p>

                                                                            <a href="#!">Preview</a>

                                                                        </div>

                                                                    </div>

                                                                </li>

                                                            </ul>

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="card">

                                                    <div class="card-header" id="headingThree">

                                                        <h5 class="mb-0">

                                                            <button class="btn btn-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">

                                                                Section 3: Final chapters

                                                            </button>

                                                        </h5>

                                                    </div>

                                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-bs-parent="#accordion">

                                                        <div class="card-body">

                                                            <ul class="curriculum-lists">

                                                                <li>

                                                                    <div class="titles">

                                                                        <i class="fas fa-play-circle"></i>

                                                                        <h3>

                                                                            Lecture 1.0

                                                                        </h3>

                                                                        <h5 class="display-29 display-lg-28 display-xl-27 mb-0">

                                                                            <a href="#!">Introduction of java</a>

                                                                        </h5>

                                                                        <div class="access-type">

                                                                            <i class="fas fa-eye"></i>

                                                                        </div>

                                                                    </div>

                                                                    <div class="intro">

                                                                        <div class="item">

                                                                            <p class="alt-font">

                                                                                Published - 15 Aug

                                                                            </p>

                                                                        </div>

                                                                        <div class="item">

                                                                            <p class="alt-font">

                                                                                Duration: 1 hour 30 min

                                                                            </p>

                                                                            <a href="#!">Preview</a>

                                                                        </div>

                                                                    </div>

                                                                </li>

                                                                <li>

                                                                    <div class="titles">

                                                                        <i class="fas fa-file"></i>

                                                                        <h3>

                                                                            Lecture 1.2

                                                                        </h3>

                                                                        <h5 class="display-29 display-lg-28 display-xl-27 mb-0">

                                                                            <a href="#!">Basic development</a>

                                                                        </h5>

                                                                        <div class="access-type">

                                                                            <i class="ti-lock"></i>

                                                                        </div>

                                                                    </div>

                                                                    <div class="intro">

                                                                        <div class="item">

                                                                            <p class="alt-font">

                                                                                Published - 28 Apr

                                                                            </p>

                                                                        </div>

                                                                        <div class="item">

                                                                            <p class="alt-font">

                                                                                Duration: 3 hour 45 min

                                                                            </p>

                                                                            <a href="#!">Preview</a>

                                                                        </div>

                                                                    </div>

                                                                </li>

                                                            </ul>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div>

                                    <div class="row mb-1-6 mb-lg-1-9 mb-xl-2-5">

                                        <div class="col-md-12">

                                            <h4 class="display-27 display-md-25 display-xl-20 font-weight-800 mb-1-6 text-capitalize">Reviews</h4>

                                            <div class="row">

                                                <div class="col-md-4">

                                                    <div class="bg-very-light-gray text-center">

                                                        <div class="rating-box">

                                                            <span class="rating-number">5</span>

                                                            <ul class="list-unstyled">

                                                                <li><i class="fa fa-star"></i></li>

                                                                <li><i class="fa fa-star"></i></li>

                                                                <li><i class="fa fa-star"></i></li>

                                                                <li><i class="fa fa-star"></i></li>

                                                                <li><i class="fa fa-star"></i></li>

                                                            </ul>

                                                            <span class="display-30 text-color font-weight-800">8 Ratings</span>

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="col-md-8">

                                                    <div class="row">

                                                        <div class="col-sm-12 mb-3">

                                                            <div class="progress-text">

                                                                <div class="row">

                                                                    <div class="col-7">5 Stars</div>

                                                                    <div class="col-5 text-end">95%</div>

                                                                </div>

                                                            </div>

                                                            <div class="progress progress-medium">

                                                                <div class="animated custom-bar progress-bar slideInLeft" style="width: 95%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="10" role="progressbar"></div>

                                                            </div>

                                                        </div>

                                                        <div class="col-sm-12 mb-3">

                                                            <div class="progress-text">

                                                                <div class="row">

                                                                    <div class="col-7">4 Stars</div>

                                                                    <div class="col-5 text-end">70%</div>

                                                                </div>

                                                            </div>

                                                            <div class="progress progress-medium">

                                                                <div class="animated custom-bar progress-bar slideInLeft" style="width: 70%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="10" role="progressbar"></div>

                                                            </div>

                                                        </div>

                                                        <div class="col-sm-12 mb-3">

                                                            <div class="progress-text">

                                                                <div class="row">

                                                                    <div class="col-7">3 Stars</div>

                                                                    <div class="col-5 text-end">45%</div>

                                                                </div>

                                                            </div>

                                                            <div class="progress progress-medium">

                                                                <div class="animated custom-bar progress-bar slideInLeft" style="width: 45%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="10" role="progressbar"></div>

                                                            </div>

                                                        </div>

                                                        <div class="col-sm-12 mb-3">

                                                            <div class="progress-text">

                                                                <div class="row">

                                                                    <div class="col-7">2 Stars</div>

                                                                    <div class="col-5 text-end">30%</div>

                                                                </div>

                                                            </div>

                                                            <div class="progress progress-medium">

                                                                <div class="animated custom-bar progress-bar slideInLeft" style="width: 30%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="10" role="progressbar"></div>

                                                            </div>

                                                        </div>

                                                        <div class="col-sm-12">

                                                            <div class="progress-text">

                                                                <div class="row">

                                                                    <div class="col-7">1 Stars</div>

                                                                    <div class="col-5 text-end">15%</div>

                                                                </div>

                                                            </div>

                                                            <div class="progress progress-medium">

                                                                <div class="animated custom-bar progress-bar slideInLeft" style="width: 15%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="10" role="progressbar"></div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="row mb-1-6 mb-lg-1-9 mb-xl-2-5">

                                        <h4 class="display-27 display-md-25 display-lg-24 display-xl-20 font-weight-800 mb-1-6 text-capitalize">Comments</h4>

                                        <div class="col-lg-12">

                                            <div class="comment-box">

                                                <div class="author-thumb">

                                                    <img class="border-radius-50" src="{{asset('front/img/avatar/avatar-15.jpg')}}" alt="...">

                                                </div>

                                                <div class="ps-10 ps-md-11">

                                                    <div class="mb-3">

                                                        <h6 class="display-29 display-lg-28 font-weight-800"><a href="#!">Denis Irwin</a></h6>

                                                        <div class="review-rating">

                                                            <i class="fas fa-star"></i>

                                                            <i class="fas fa-star"></i>

                                                            <i class="fas fa-star"></i>

                                                            <i class="fas fa-star"></i>

                                                            <i class="fas fa-star"></i>

                                                        </div>

                                                    </div>

                                                    <p class="mb-3 display-30 display-md-29 alt-font text-color font-weight-500">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

                                                    <div class="font-weight-800">

                                                        <a href="#!" class="display-30 display-md-29"> <i class="fa fa-reply display-31 pe-2" aria-hidden="true"></i> Reply </a>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="comment-box">

                                                <div class="author-thumb">

                                                    <img class="border-radius-50" src="{{asset('front/img/avatar/avatar-10.jpg')}}" alt="...">

                                                </div>

                                                <div class="ps-10 ps-md-11">

                                                    <div class="mb-3">

                                                        <h6 class="display-29 display-lg-28 font-weight-800"><a href="#!">Bruno Roach</a></h6>

                                                        <div class="review-rating">

                                                            <i class="fas fa-star"></i>

                                                            <i class="fas fa-star"></i>

                                                            <i class="fas fa-star"></i>

                                                            <i class="fas fa-star"></i>

                                                        </div>

                                                    </div>

                                                    <p class="mb-3 display-30 display-md-29 alt-font text-color font-weight-500">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

                                                    <div class="font-weight-800">

                                                        <a href="#!" class="display-30 display-md-29"> <i class="fa fa-reply display-31 pe-2" aria-hidden="true"></i> Reply </a>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="comment-box">

                                                <div class="author-thumb">

                                                    <img class="border-radius-50" src="{{asset('front/img/avatar/avatar-13.jpg')}}" alt="...">

                                                </div>

                                                <div class="ps-10 ps-md-11">

                                                    <div class="mb-3">

                                                        <h6 class="display-29 display-lg-28 font-weight-800"><a href="#!">John Martin</a></h6>

                                                        <div class="review-rating">

                                                            <i class="fas fa-star"></i>

                                                            <i class="fas fa-star"></i>

                                                            <i class="fas fa-star"></i>

                                                            <i class="fas fa-star"></i>

                                                            <i class="fas fa-star"></i>

                                                        </div>

                                                    </div>

                                                    <p class="mb-3 display-30 display-md-29 alt-font text-color font-weight-500">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

                                                    <div class="font-weight-800">

                                                        <a href="#!" class="display-30 display-md-29"> <i class="fa fa-reply display-31 pe-2" aria-hidden="true"></i> Reply </a>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="comment-box mb-0">

                                                <div class="author-thumb">

                                                    <img class="border-radius-50" src="{{asset('front/img/avatar/avatar-09.jpg')}}" alt="...">

                                                </div>

                                                <div class="ps-10 ps-md-11">

                                                    <div class="mb-3">

                                                        <h6 class="display-29 display-lg-28 font-weight-800"><a href="#!">John Martin</a></h6>

                                                        <div class="review-rating">

                                                            <i class="fas fa-star"></i>

                                                            <i class="fas fa-star"></i>

                                                            <i class="fas fa-star"></i>

                                                            <i class="fas fa-star"></i>

                                                            <i class="fas fa-star"></i>

                                                        </div>

                                                    </div>

                                                    <p class="mb-3 display-29 alt-font text-color font-weight-500">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

                                                    <div class="font-weight-800">

                                                        <a href="#!" class="display-30 display-md-29"> <i class="fa fa-reply display-31 pe-2" aria-hidden="true"></i> Reply </a>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="comment-form">

                                            <h4 class="display-27 display-md-25 display-lg-24 display-xl-20 font-weight-800 mb-1-6 text-capitalize">Leave A Comment</h4>

                                            <!-- Form -->

                                            <form>

                                                <div class="row">

                                                    <div class="form-group">

                                                        <textarea name="reply" rows="6" class="form-control h-100" placeholder="Your Reply"></textarea>

                                                    </div>

                                                    <div class="col-sm-6">

                                                        <div class="form-group">

                                                            <input type="text" class="form-control" name="name" placeholder="Your Name">

                                                        </div>

                                                    </div>

                                                    <div class="col-sm-6">

                                                        <div class="form-group">

                                                            <input type="email" class="form-control" name="email" placeholder="Email Address">

                                                        </div>

                                                    </div>

                                                </div>

                                                <div>

                                                    <button type="submit" class="butn"><i class="fas fa-plus-circle icon-arrow before"></i><span class="label">Submit</span><i class="fas fa-plus-circle icon-arrow after"></i></button>

                                                </div>

                                            </form>

                                            <!-- End Form -->

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-12">

                        <h4 class="display-27 display-md-25 display-xl-20 font-weight-800 mb-1-6 text-capitalize">Related Courses</h4>

                        <div class="owl-carousel owl-theme related-courses-carousel">

                            <div class="card card-style1 p-0 h-100">

                                <div class="card-img rounded-0">

                                    <div class="image-hover">

                                        <img class="rounded-top" src="{{asset('front/img/content/courses-01.jpg')}}" alt="...">

                                    </div>

                                    <a href="{{url('course')}}" class="course-tag">Business</a>

                                    <a href="#!"><i class="far fa-heart"></i></a>

                                </div>

                                <div class="card-body position-relative pt-0 px-1-9 pb-1-9">

                                    <div class="pt-6">

                                        <h3 class="h4 mb-4"><a href="{{url('course')}}">UPSC(Union Public Service Commision)</a></h3>

                                    </div>

                                </div>

                            </div>

                            <div class="card card-style1 p-0 h-100">

                                <div class="card-img rounded-0 border-color-secondary">

                                    <div class="image-hover">

                                        <img class="rounded-top" src="{{asset('front/img/content/courses-02.jpg')}}" alt="...">

                                    </div>

                                    <a href="{{url('course')}}" class="course-tag secondary">Design</a>

                                    <a href="#!"><i class="far fa-heart"></i></a>

                                </div>

                                <div class="card-body position-relative pt-0 px-1-9 pb-1-9">

                                    <div class="pt-6">

                                        <h3 class="h4 mb-4"><a href="{{url('course')}}">SSC(Service Selection Commision)</a></h3>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>



            <!--  start courses list right-->

            <div class="col-md-12 col-lg-4">

                <div class="ps-lg-1-6 ps-xl-1-9">

                    <div class="sidebar">

                        <div class="widget">

                            <div class="widget-title">

                                <h3>Find Your Courses</h3>

                            </div>

                            <form class="search">

                                <input type="text" placeholder="Search Your Courses">

                                <button type="submit"><i class="fas fa-search"></i></button>

                            </form>

                        </div>

                        <div class="widget">

                            <div class="widget-title">

                                <h3>Course Details</h3>

                            </div>

                            <ul class="course-list">

                                <li><span><i class="ti-time pe-2"></i>Duration</span>3 hours</li>

                                <li><span><i class="ti-eye pe-2"></i>Viewers</span>350</li>

                                <li><span><i class="ti-files pe-2"></i>Lectures</span>15</li>

                                <li><span><i class="ti-user pe-2"></i>Students</span>100</li>

                                <li><span><i class="ti-medall pe-2"></i>Certificate</span>Yes</li>

                                <li><span><i class="ti-menu-alt pe-2"></i>Level</span>Beginner</li>

                                <li><span><i class="ti-stats-up pe-2"></i>Skill level</span>All Levels</li>

                                <li><span><i class="ti-world pe-2"></i>Language</span>Hindi/English</li>

                            </ul>

                        </div>

                        <div class="widget">

                            <div class="widget-title">

                                <h3>Course Categories</h3>

                            </div>

                            <ul class="category-list">

                                <li><a href="#!">Foundation Course 🏛️<span></span></a></li>

                                <li><a href="#!"> Prelims Crash Course ⏳<span></span></a></li>

                                <li><a href="#!">Mains Answer Writing Program ✍️<span></span></a></li>

                                <li><a href="#!">Optional Subject Coaching 📚<span></span></a></li>

                                <li><a href="#!">Interview Guidance Program (Personality Test) 🎙️<span></span></a></li>

                                <li><a href="#!">Weekend & Working Professionals’ Seminar's 🏢<span></span></a></li>

                            </ul>

                        </div>

                        <div class="widget">

                            <div class="widget-title">

                                <h3>Popular Tags</h3>

                            </div>

                            <ul class="course-tags">

                                <li><a href="#!">Business</a></li>

                                <li><a href="#!">Courses</a></li>

                                <li><a href="#!">Guides</a></li>

                                <li><a href="#!">Tips</a></li>

                                <li><a href="#!">Education</a></li>

                                <li><a href="#!">Marketing</a></li>

                                <li><a href="#!">Technology</a></li>

                            </ul>

                        </div>
                    </div>

                </div>

            </div>

            <!--  end courses list right-->



        </div>

    </div>

</section>


@endsection