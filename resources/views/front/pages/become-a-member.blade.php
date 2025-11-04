@extends('front.layout.app')
@section('content')

<section class="page-title-section bg-img cover-background top-position1 left-overlay-dark" data-overlay-dark="9" data-background="https://www.gaamraam.ngo/front/img/bg/about-bg.jpg" style="background-image: url(&quot;https://www.gaamraam.ngo/front/img/bg/about-bg.jpg&quot;);">
	<div class="container">
		<div class="row text-center">
			<div class="col-md-12">
				<h1>Become a Member</h1>
			</div>
			<div class="col-md-12">
				<ul>
					<li><a href="#">Home</a></li>
					<li><a href="#!">Become a Member</a></li>
				</ul>
			</div>
            <a href="{{ url('member-register?form=login') }}" class="become-memb butn md text-white mt-4 mb-2 mx-auto w-auto"><i class="fas fa-plus-circle icon-arrow before"></i><span class="label">Member Login</span><i class="fas fa-plus-circle icon-arrow after"></i></a>
		</div>
	</div>
</section>
<section class="pb-4 py-5">
    <div class="container">
        <div class="row">
            <div class="member-section top-member-div text-center">
                <p> @lang('messages.join_gaamraam_trust_empower_students_strengthen_communities_and_shape_haryanas_tomorrow')</p>
                <h4>@lang('messages.a_haryana_where_no_one_stands_alone') </h4>
            </div>
        </div>
        <div class="content-container">
            <div class="text-content">
                <h6>@lang('messages.together_we_rise_together_we_transform')</h6>
                <!-- <p><strong>As its firstborns</strong>, we must end the cycle of struggle and isolation—building a future where no one stands alone.</p> -->
                <p><em> @lang('messages.too_many_have_suffered_in_silence_risen_alone_and_felt_no_obligation_to_give_back_because_when_they_needed_support_society_turned_its_back')</em></p>
                <p class="text-warning font-weight-bold">@lang('messages.this_ends_with_us')</p>
                <p>@lang('messages.alone_we_are_weak_united_we_are_unstoppable')</p>
                <p>@lang('messages.we_must_rise_above_caste_religion_and_personal_barriers_to_build_a_future_where_no_one_is_left_behind')</p>
                <h6 class="py-3"> @lang('messages.this_is_more_than_duty_it_is_our_legacy')</h6>
                <a href="{{url('member-register')}}" class="register-btn">@lang('messages.start_your_impact_today')</a>
            </div>

            <div class="image-container">
                <img src="../public/front/images/memimg.jpg" alt="Membership Image">
            </div>
        </div>
    </div>
</section>
<!-- topsection -->

<section class="py-5 bg-very-light-gray">
    <div class="container">
        <h2 class="text-center h1 my-3">@lang('messages.be_the_change_choose_your_role')</h2>
        <div class="custom-tabs">
            <div class="custom-tab active" data-tab="tab1">@lang('messages.indian_member')</div>
            <div class="custom-tab" data-tab="tab2">@lang('messages.nri_member')</div>
        </div>
        <div class="custom-tab-content active" id="tab1">
            <h5 class="text-center">@lang('messages.be_the_change_in_your_community')</h5>
            <p class="text-center">@lang('messages.opportunities_arent_equal_for_everyone_but_together_we_can_change_that')</p>
            <ul>
                <li><strong>@lang('messages.membership_fee')</strong> @lang('messages.100_a_small_contribution_a_big_impact') </li>
                <li><strong>@lang('messages.on_ground_action')</strong> @lang('messages.be_the_force_of_change_participate_in_social_initiatives_awareness_drives_and_community_programs')</li>
                <li> <strong>@lang('messages.volunteer_leadership')</strong> @lang('messages.lead_teams_organize_events_and_make_a_real_impact_where_its_needed_most') </li>
                <li> <strong>@lang('messages.social_media_engagement')</strong> @lang('messages.use_your_voice_to_amplify_causes_mobilize_support_and_inspire_action') </li>
            </ul>
            <div class="d-flex justify-content-center">
                <a href="{{ url('member-register') }}?form=indian-member" class="join-noww">@lang('messages.join_now')</a>
            </div>
        </div>
        <div class="custom-tab-content" id="tab2">
            <h5 class="text-center">@lang('messages.stay_connected_to_your_roots_create_impact') </h5>
            <p class="text-center">
                @lang('messages.you_know_what_it_means_to_be_far_from_home_the_struggles_the_sacrifices_now_you_have_the_power_to_ensure_no_child_in_your_village_has_to_leave_just_to_survive')
            </p>
            <ul>
                <li><strong>@lang('messages.membership_fee')</strong>@lang('messages.just_one_hours_earnings_per_month_turn_your_success_into_someones_chance')</li>
                <li><strong>@lang('messages.digital_advocacy')</strong> @lang('messages.use_your_reach_to_spread_awareness_inspire_action_and_bring_people_together')</li>
                <li><strong>@lang('messages.global_outreach')</strong>@lang('messages.connect_with_changemakers_worldwide_and_expand_the_mission_beyond_borders')</li>
                <li> <strong>@lang('messages.strategic_support')</strong> @lang('messages.mentor_fund_or_network_because_real_change_knows_no_boundaries')
                </li>
            </ul>
            <div class="d-flex justify-content-center">
                <a href="{{ url('member-register') }}?form=nri-member" class="join-noww">@lang('messages.join_now')</a>
            </div>
        </div>


    </div>
</section>



<!-- Why Become a Member -->
<section class="why-member bg-very-light-gray">
    <div class="container">
        <h3>@lang('messages.why_become_a_member')</h3>
        <p>@lang('messages.being_a_member_unlocks_a_world_of_opportunities_from_learning_to_networking_we_ensure_you_gain_the_best_experience_possible')</p>

        <div class="row">
            <div class="col-lg-6">
                <div class="become-member-points">
                    <ul>
                        <li>✔ @lang('messages.create_future_leaders_your_support_empowers_bright_students_to_serve_the_nation')</li>
                        <li>✔ @lang('messages.100_percent_transparency_and_accountability_every_rupee_you_contribute_is_trackable_in_real_time')</li>
                        <li>✔ @lang('messages.your_contribution_your_influence_earn_social_points_that_give_you_real_decision_making_power')</li>

                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="become-member-points">
                    <ul>
                        <li>✔ @lang('messages.exclusive_benefits_for_top_contributors_special_access_to_key_events_leadership_roles_priority_seating')</li>
                        <li>✔ @lang('messages.rise_to_the_top_become_a_leader_in_gaamraam')
                            <ul>
                                <li> @lang('messages.your_social_points_determine_your_rank_influence_and_voting_power')</li>
                                <li>@lang('messages.the_path_to_leadership_is_100_percent_transparent_your_impact_speaks_for_itself')</li>
                            </ul>
                        </li>
                        <li><a href="{{url('member-register')}}" class="">@lang('messages.start_your_impact_today')</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <a href="{{url('member-register')}}" class="register-btn">@lang('messages.join_now')</a>
    </div>
</section>


<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="how-to-join">
                <h2 class="text-center mb-3">@lang('messages.how_to_join')</h2>
                <h6>@lang('messages.rs_100_per_month_a_students_future')</h6>
                <p>@lang('messages.your_support_funds_free_upsc_ssc_coaching_providing_mentorship_and_guidance_to_students_who_need_it_the_most')</p>
                <span>@lang('messages.three_easy_steps_to_join')</span>
                <ul>
                    <li>✔ @lang('messages.step_1_sign_up_fill_out_the_quick_membership_form')</li>
                    <li>✔ @lang('messages.step_2_contribute_rs_100_per_month_or_more_support_education_earn_social_points')</li>
                    <li>✔ @lang('messages.step_3_unlock_benefits_share_your_achievements_influence_decisions_showcase_your_impact')</li>
                </ul>
                <a href="{{url('member-register')}}" class="">@lang('messages.support_a_student_now')</a>

            </div>
        </div>
    </div>
</section>

<!-- social points -->

<section class="bg-very-light-gray py-1 ">
    <div class="container">
        <div class="tab-container">
            <h2 class="membrr-all text-center py-4">@lang('messages.membership_that_works_for_you')</h2>
            <div class="points-tabs">
                <div class="point-tab" data-tab="content-one">@lang('messages.social_point_system')</div>
                <div class="point-tab" data-tab="content-two">@lang('messages.ranks')</div>
                <div class="point-tab" data-tab="content-three">@lang('messages.member_rights')</div>
            </div>

            <div id="content-one" class="point-tab-content active">
                <div class="container">
                    <div class="row py-4">
                        <h3 class="text-center py-3">@lang('messages.social_point_system')</h3>
                        <p class="text-center">@lang('messages.every_contribution_is_fairly_counted_and_social_points_ensure_your_true_impact_is_recognised_with_full_transparency')</p>
                        <div class="table-content-div">
                            <table class="table table-striped social-pint-tbl">
                                <thead>
                                    <tr>
                                        <th>@lang('messages.activity')</th>
                                        <th>@lang('messages.social_points_earned')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>@lang('messages.membership_donation_contribution_every_rs_10')</td>
                                        <td>@lang('messages.1_point')</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('messages.1_hour_of_volunteering')</td>
                                        <td>@lang('messages.10_points')</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('messages.referring_a_new_member')</td>
                                        <td>@lang('messages.10_percent_of_their_earned_points_lifetime')</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('messages.completing_tasks_on_dashboard')</td>
                                        <td>@lang('messages.points_based_on_task_difficulty')</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="content-two" class="point-tab-content">
                <div class="container">
                    <h3 class="text-center py-3">@lang('messages.rank_heading')</h3>
                    <p class="text-center w-md-75  m-auto py-2">@lang('messages.rank_paragraph')</p>
                    <div class="row">
                        <div class="table-content-div">
                            <table class="table table-striped social-pint-tbl">
                                <thead>
                                    <tr>
                                        <th>@lang('messages.rank_table_heading_1')</th>
                                        <th>@lang('messages.rank_table_heading_2')</th>
                                        <th>@lang('messages.rank_table_heading_3')</th>
                                        <th>@lang('messages.rank_table_heading_4')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><img src="https://cdn-icons-png.flaticon.com/128/2583/2583434.png" alt=""></td>
                                        <td>@lang('messages.rank_type_1')</td>
                                        <td>@lang('messages.rank_marks_1')</td>
                                        <td>@lang('messages.rank_effect_1')</td>
                                    </tr>
                                    <tr>
                                         <td><img src="https://cdn-icons-png.flaticon.com/128/5406/5406792.png" alt=""></td>
                                        <td>@lang('messages.rank_type_2')</td>
                                        <td>@lang('messages.rank_marks_2')</td>
                                        <td>@lang('messages.rank_effect_2')</td>
                                    </tr>
                                    <tr>
                                         <td><img src="https://cdn-icons-png.flaticon.com/128/9540/9540763.png" alt=""></td>
                                        <td>@lang('messages.rank_type_3')</td>
                                        <td>@lang('messages.rank_marks_3')</td>
                                        <td>@lang('messages.rank_effect_3')</td>
                                    </tr>
                                    <tr>
                                         <td><img src="https://cdn-icons-png.flaticon.com/128/9433/9433085.png" alt=""></td>
                                        <td>@lang('messages.rank_type_4')</td>
                                        <td>@lang('messages.rank_marks_4')</td>
                                        <td>@lang('messages.rank_effect_4')</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div id="content-three" class="point-tab-content">
                <div class="container">
                    <h3 class="text-center py-3">@lang('messages.voting_heading')</h3>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="voting-pointss">
                                <h6>@lang('messages.voting_card_title_1')</h6>
                                <ul>
                                    <li>✔ @lang('messages.voting_title_points_11')</li>
                                    <li>✔ @lang('messages.voting_title_points_21')</li>
                                    <li>✔ @lang('messages.voting_title_points_31')</li>
                                </ul>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="voting-pointss">
                                <h6>@lang('messages.voting_card_title_2')</h6>
                                <ul>
                                    <li>✔ @lang('messages.voting_title_points_12')</li>
                                    <li>✔ @lang('messages.voting_title_points_22')
                                    </li>
                                </ul>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="voting-pointss">
                                <h6>@lang('messages.voting_card_title_3')</h6>

                                <ul>
                                    <li>✔ @lang('messages.voting_title_points_13')</li>
                                    <li>✔ @lang('messages.voting_title_points_23')</li>
                                    <li>✔ @lang('messages.voting_title_points_33')</li>
                                </ul>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="voting-pointss">
                                <h6>@lang('messages.voting_card_title_4')</h6>
                                <ul>
                                    <li>✔ @lang('messages.voting_title_points_14')</li>
                                    <li>✔ @lang('messages.voting_title_points_24')
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>





@endsection

@push('js')



@endpush