@extends('front.layout.app')

@section('content')

<br><br><br>
<div class="container">
    <div class="row py-3 ">
        <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center my-1 my-lg-0">
            <div class="register-process-div">
                <div class="image-block-register">
                    <img src="./front/images/register/student-enrollment.jpeg" alt="">
                </div>
                <div class="steps-div-block">
                    <h3>@lang('messages.sign_up_&_get_started')</h3>

                </div>
            </div>

        </div>
        <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center my-1 my-lg-0">
            <div class="register-content-div">
                <p>
                    @lang('messages.you_are_in_the_right_place_for_free_upsc_&_ssc_coaching_!')
                </p>
                <h5 class="step-heading">@lang('messages.fill_out_the_sign_up_form_to_begin_your_enrollment_you_will_need_to_enter')</h5>
                <p>Begin your enrollment by completing the Sign-Up form on this website. You’ll need to provide:</p>
                <ul>
                    <li>@lang('messages.your_full_name')</li>
                    <li>@lang('messages.whatsapp_number_for_communication')</li>
                    <li>@lang('messages.email_id_your_username')</li>
                    <li>@lang('messages.create_a_password_for_login')</li>
                    <li>@lang('messages.select_your_course_upsc_or_ssc')</li>
                </ul>
                <p>After submitting the form, you’ll receive a confirmation email with your login details.</p>
                <p>Seats are limited Sign Up Now!</p>
                <p>@lang('messages.after_signing_up_you_will_receive_a_confirmation_email_with_your_login_details')</p>
                <p>@lang('messages.your_enrollment_starts_as_soon_as_you_sign_up')</p>
                <p>@lang('messages.seats_are_limited_sign_up_now')</p>
            </div>
        </div>
    </div>
    <hr>
    <div class="row py-3 reverse-row-div">
        <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center my-1 my-lg-0">
            <div class="register-content-div">
                <h5 class="step-heading">Access Your Student Dashboard</h5>
                <p>After signing up:</p>
                <ul>
                    <li>Click on Student Login at the top of the website.</li>
                    <li>Log in using your registered email ID and password.</li>
                    <li>Access your Student Dashboard.</li>
                </ul>
                <p>Inside the dashboard:</p>
                <ul>
                    <li>Upload your required documents.</li>
                    <li>Our team will verify them.</li>
                    <li>You’ll receive an email notification once your documents are approved.</li>
                </ul>
                <p>Upload your documents on time to avoid delays.</p>
            </div>
        </div>
        <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center my-1 my-lg-0">
            <div class="register-process-div">
                <div class="image-block-register">
                    <img src="./front/images/register/documentverification.jpg" alt="">
                </div>
                <div class="steps-div-block">
                    <h3>Access Your Student Dashboard</h3>

                </div>
            </div>

        </div>
    </div>
    <hr>
    <div class="row py-3">
        <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center my-1 my-lg-0">
            <div class="register-process-div">
                <div class="image-block-register">
                    <img src="./front/images/register/apptitude.jpg" alt="">
                </div>
                <div class="steps-div-block">
                    <h3>Digital Student I-Card</h3>
                    <p>After successful document verification, you’ll receive your Digital Student I-Card, which is
                        required to attend online classes.</p>
                </div>
            </div>

        </div>
        <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center my-1 my-lg-0">
            <div class="register-content-div">
                <h5 class="step-heading">Online Class Schedule</h5>
                <p>After signing up:</p>
                <ul>
                    <li>Class Start Date: 10 July 2025</li>
                    <li>Mode: Live online classes (accessible via mobile or laptop)
                        <ul>
                            <p>Morning Classes: 7:00 AM – 8:30 AM</p>
                            <li>Followed by a Doubt-Clearing Session (continues until all doubts are
                            resolved)</li>
                        </ul>
                    </li>
                    <li>Evening Classes: 7:00 PM – 8:30 PM
                        <ul>
                            <li>Followed by a Doubt-Clearing Session (open-ended until all doubts are
                            cleared)</li>
                        </ul>
                    </li>
                </ul>
                <h5>Class Guidelines</h5>
                <ul>
                    <li>Attendance is mandatory for all live sessions.</li>
                    <li>Students must join on time and stay until class and doubt sessions are complete.</li>
                    <li>Maintain discipline and actively participate.</li>
                    <li>Use a stable internet connection for uninterrupted learning</li>
                </ul>
                <p>Learn from anywhere. Pay nothing. Focus on your future.</p>
                <p>Sign up today — your journey begins on 10th July!</p>
            </div>
        </div>
    </div>
    <!-- <hr> -->
    <div class="row py-3 reverse-row-div d-none">
        <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center my-1 my-lg-0">
            <div class="register-content-div">
                <p>@lang('messages.students_who_qualify_after_the_aptitude_test_will_receive_their_official_student_i_card_which_is_required_for_attending_physical_classes_at_their_selected_institution')</p>
                <h5 class="step-heading">@lang('messages.class_start_date')</h5>
                <p>@lang('messages.april_30_2025')</p>
                <p>@lang('messages.at_partnered_colleges_universities_or_schools_near_you')</p>
                <p>@lang('messages.upsc_classes_time')</p>
                <!-- <p>@lang('messages.ssc_classes_time')</p> -->
                <h5>@lang('messages.key_features')</h5>
                <ul>
                    <li>@lang('messages.mandatory_attendence_&_discipline')</li>
                    <li>@lang('messages.strict_adherence_to_class_guidelines')</li>
                </ul>
                <p>@lang('messages.get_ready_to_begin_your_journey_stay_committed_and_focused')</p>

            </div>
        </div>
        <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center my-1 my-lg-0">
            <div class="register-process-div">
                <div class="image-block-register">
                    <img src="./front/images/register/classes.jpeg" alt="">
                </div>
                <div class="steps-div-block">
                    <h3>
                        @lang('messages.step_4')
                    </h3>
                    <h3>@lang('messages.attend_physical_classes')</h3>
                </div>
            </div>

        </div>
    </div>
    <!-- <hr> -->

</div>




@endsection