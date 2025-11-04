@extends('front.layout.app')
@section('content')
<style>
    
</style>
<section class="page-title-section bg-img cover-background top-position1 left-overlay-dark" data-overlay-dark="9" data-background="{{asset('front/img/bg/bg-04.jpg')}}">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-12">
                <h1>Faq</h1>
            </div>
            <div class="col-md-12">
                <ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url()->current() }}">Faq</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<div class="container my-5">
    <h2 class="text-center py-3">Frequently Asked Questions</h2>
    <div class="row">
        <div class="faq-tabss">
            <div class="tabs">
                <div class="faq-tab active" data-tab="tab1">Students</div>
                <div class="faq-tab" data-tab="tab2"> Members</div>
                <div class="faq-tab" data-tab="tab3"> Partner Institutions</div>

            </div>
            <div class="faq-tab-content active" id="tab1">
                <div class="accordion" id="faqAccordion">
                    <!-- FAQ 1 -->
                    <div class="accordion-item">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0 according-bttnn">
                                <button class="accordion-button " type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    1. Where are GaamRaam coaching classes held?

                                </button>
                            </h5>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqAccordion">
                            <div class="accordion-body">
                                Classes are conducted in almost every district headquarters and important blocks of Haryana, ensuring accessibility for students across various regions.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="accordion-item">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0 according-bttnn">
                                <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    2. How can I enroll in GaamRaam coaching?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#faqAccordion">
                            <div class="accordion-body">
                                You can sign up through our website, and we will send you further instructions via email and WhatsApp to complete your enrollment.

                            </div>
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="accordion-item">
                        <div class="card-header" id="headingThree">
                            <h5 class="mb-0 according-bttnn">
                                <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    3. What if I miss a live class?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#faqAccordion">
                            <div class="accordion-body">
                                Don’t worry! Recorded lectures are available for you to watch later at your convenience. However, attending live classes is highly recommended for better interaction, and it is mandatory unless an unavoidable situation arises.

                            </div>
                        </div>
                    </div>

                    <!-- FAQ 4 -->
                    <div class="accordion-item">
                        <div class="card-header" id="headingFour">
                            <h5 class="mb-0 according-bttnn">
                                <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    4. What support does GaamRaam provide to students?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#faqAccordion">
                            <div class="accordion-body">
                                <ul>
                                    <li>Live & Recorded Classes from top educators.</li>
                                    <li>Study Materials, e-Notes & Test Series for major exams.</li>
                                    <li>Mentorship & Progress Monitoring to track your improvement.</li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- FAQ 5 -->
                    <div class="accordion-item">
                        <div class="card-header" id="headingfour">
                            <h5 class="mb-0 according-bttnn">
                                <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseThree">
                                    5. How can I get help if I face any issues?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseFive" class="collapse" aria-labelledby="headingfour" data-parent="#faqAccordion">
                            <div class="accordion-body">
                                You can reach out through our website or visit your nearest GaamRaam partner institution. You can also WhatsApp us at 9053903100 or email GaamRaam.ngo@gmail.com.

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="faq-tab-content" id="tab2">

                <div class="accordion" id="faqAccordion">
                    <!-- FAQ 1 -->
                    <div class="accordion-item">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0 according-bttnn">
                                <button class="accordion-button " type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    1. What is the benefit of becoming a GaamRaam member?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqAccordion">
                            <div class="accordion-body">
                                As a member, you don’t just donate—you witness real change. You get:
                                <ul>
                                    <li>Transparency – Track how your contributions are making an impact.</li>
                                    <li> Active Participation – Get involved beyond donations.</li>
                                    <li>A Voice in Change – Be part of decision-making that shapes lives.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="accordion-item">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0 according-bttnn">
                                <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    2. How do I become a member?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#faqAccordion">
                            <div class="accordion-body">
                                You can sign up on our website and choose a membership plan that aligns with your commitment to social change.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="accordion-item">
                        <div class="card-header" id="headingThree">
                            <h5 class="mb-0 according-bttnn">
                                <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    3. Can I contribute without becoming a member?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes! But we encourage membership so you can see the long-term impact of your contribution and actively be part of the transformation.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 4 -->
                    <div class="accordion-item">
                        <div class="card-header" id="headingFour">
                            <h5 class="mb-0 according-bttnn">
                                <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    4. How can I track my contributions?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#faqAccordion">
                            <div class="accordion-body">
                                Our transparent system ensures every rupee is accounted for, and members receive regular updates on how their contributions are utilized.
                            </div>
                        </div>
                    </div>
                    <!-- FAQ 5 -->
                    <div class="accordion-item">
                        <div class="card-header" id="headingfour">
                            <h5 class="mb-0 according-bttnn">
                                <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseThree">
                                    5. How can I contact GaamRaam for membership-related queries?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseFive" class="collapse" aria-labelledby="headingfour" data-parent="#faqAccordion">
                            <div class="accordion-body">
                                You can WhatsApp us at 9053903100 or email GaamRaam.ngo@gmail.com for any membership-related assistance.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="faq-tab-content" id="tab3">

                <div class="accordion" id="faqAccordion">
                    <!-- FAQ 1 -->
                    <div class="accordion-item">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0 according-bttnn">
                                <button class="accordion-button " type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    1. How can an institution partner with GaamRaam?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqAccordion">
                            <div class="accordion-body">
                                Institutions can sign up on our website, and our team will guide them through the simple onboarding process.

                            </div>
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="accordion-item">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0 according-bttnn">
                                <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    2. What does a partner institution need to provide?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#faqAccordion">
                            <div class="accordion-body">
                                To ensure quality education, institutions need to provide:
                                <ul>
                                    <li>Classrooms (2:30 PM – 5:30 PM) for coaching sessions.</li>
                                    <li>A Class Coordinator to manage attendance and discipline.</li>
                                    <li>LCD/Projection Screens for interactive learning.</li>
                                    <li>WiFi Connectivity for seamless live sessions.</li>
                                    <li>Reliable Electricity Supply to power digital tools.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="accordion-item">
                        <div class="card-header" id="headingThree">
                            <h5 class="mb-0 according-bttnn">
                                <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    3. What support does GaamRaam provide to partner institutions?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#faqAccordion">
                            <div class="accordion-body">
                                GaamRaam takes care of:
                                <ul>
                                    <li>Hiring & paying expert faculty for live coaching.</li>
                                    <li>Providing study materials, e-notes, and test series.</li>
                                    <li>Monitoring student progress and offering regular feedback.</li>
                                    <li>Promoting your institution to attract more students.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 4 -->
                    <div class="accordion-item">
                        <div class="card-header" id="headingFour">
                            <h5 class="mb-0 according-bttnn">
                                <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    4. Is there any cost involved for partner institutions?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#faqAccordion">
                            <div class="accordion-body">
                                No! GaamRaam covers all operational expenses. Institutions only need to provide the necessary infrastructure and basic resources.
                            </div>
                        </div>
                    </div>
                    <!-- FAQ 5 -->
                    <div class="accordion-item">
                        <div class="card-header" id="headingfour">
                            <h5 class="mb-0 according-bttnn">
                                <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseThree">
                                    5. How can an institution get in touch for partnership?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseFive" class="collapse" aria-labelledby="headingfour" data-parent="#faqAccordion">
                            <div class="accordion-body">
                                Institutions can connect with us via our website, WhatsApp (9053903100), or email (GaamRaam.ngo@gmail.com).
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>


</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tabs = document.querySelectorAll(".faq-tab");
        const contents = document.querySelectorAll(".faq-tab-content");

        tabs.forEach(tab => {
            tab.addEventListener("click", function() {
                tabs.forEach(t => t.classList.remove("active"));
                contents.forEach(c => c.classList.remove("active"));

                this.classList.add("active");
                document.getElementById(this.dataset.tab).classList.add("active");
            });
        });
    });
</script>
@endsection