@extends('front.layout.app')
@section('content')
<!-- PAGE TITLE
	================================================== -->
<section class="page-title-section bg-img cover-background top-position1 left-overlay-dark" data-overlay-dark="9" data-background="{{asset('front/img/bg/about-bg.jpg')}}">
	<div class="container">
		<div class="row text-center">
			<div class="col-md-12">
				<h1>@lang('messages.about_us')</h1>
			</div>
			<div class="col-md-12">
				<ul>
					<li><a href="#">@lang('messages.home')</a></li>
					<li><a href="#!">@lang('messages.about_us')</a></li>
				</ul>
			</div>
		</div>
	</div>
</section>
<!-- ABOUTUS
	================================================== -->
<section class="aboutus-style-02">
	<div class="container">
		<div class="row align-items-center mt-n1-9">

			<!-- <div class="col-lg-6 col-xl-5 mt-1-9"> -->
			<div class="section-heading text-start mb-0">
				<span class="sub-title">@lang('messages.about_us')</span>
			</div>
			<h2 class="h1 mb-1-6 text-primary">@lang('messages.you_and_we_stronger_together_as_gaamraam')</h2>
			<p>@lang('messages.we_are_not_celebrities_nor_do_we_stand_on_privilege_or_power_we_are_the_sons_and_daughters_of_haryana_rooted_in_our_land_and_strengthened_by_unity')
			</p>
			<p>@lang('messages.our_vision_is_simple_yet_powerful_to_give_back_to_our_people_stand_as_one_family_and_build_a_haryana_where_no_one_is_left_behind')</p>
			<p>@lang('messages.this_is_more_than_just_a_mission_it_is_our_shared_responsibility_alone_we_are_individuals_together_we_are_unstoppable')</p>
			<h6 class="w-75">@lang('messages.in_this_family_no_one_is_above_or_below_everyone_moves_forward_together')</h6>

		</div>
		<div class="shape20">
			<img src="{{asset('front/img/bg/bg-02.jpg')}}" alt="...">
		</div>
		<div class="shape18">
			<img src="{{asset('front/img/bg/bg-01.jpg')}}" alt="...">
		</div>
		<div class="shape21">
			<img src="{{asset('front/img/bg/bg-03.jpg')}}" alt="...">
		</div>
	</div>
</section>
<!-- EXTRA
	================================================== -->
<section class="py-0">
	<div class="row g-0">
		<div class="col-lg-6 order-2 order-lg-1">
			<div class="instructor-partner-content h-100 text-white">
				<h2 class="h1 mb-3 text-white">@lang('messages.how_we_do_it')</h2>
				<p class="what-para"> @lang('messages.at_gaamraam,_we_follow_a_self-sustaining_model_where_transparency,_opportunity,_and_collective_effort_drive_lasting_change.')</p>
					
				<ul>
					<li>✔ @lang('messages.shared_support,_shared_future') – @lang('messages.our_members_and_supporters_contribute_not_as_charity_but_as_an_investment_in_a_stronger_future_this_shared_responsibility_ensures_sustainability_and_removes_financial_barriers_to_opportunity.')</li>
					<li>✔@lang('messages.zero-cost_institutional_partnerships')– @lang('messages.we_partner_with_schools_and_colleges_that_provide_space,_while_we_arrange_expert_faculty,_study_materials,_and_technology—ensuring_free,_high-quality_education_for_all.') </li>
					<li>✔ @lang('messages.a_continuous_cycle_of_empowerment') – @lang('messages.the_students_we_support_today_become_mentors_and_leaders_tomorrow,_passing_on_the_same_support_they_once_received._this_ripple_effect_strengthens_communities_from_within,_ensuring_empowerment_is_not_just_a_moment_but_a_lifelong_commitment.')</li>
				</ul>
				<p>@lang('messages.together,_we_create_change—a_future_where_every_child_has_access_to_opportunities,_can_grow,_and_can_give_back_to_society.')</p>

				<!-- <a href="#!" class="butn white"><i class="fas fa-plus-circle icon-arrow before white"></i><span class="label">Apply Now</span><i class="fas fa-plus-circle icon-arrow after"></i></a> -->
			</div>
		</div>
		<div class="col-lg-6">
			<div class="instructor-content h-100 text-white">
				<h2 class="text-white h1 mb-3">@lang('messages.what_we_do')</h2>
				<p class="what-para">@lang('messages.empowering_the_youngest_members_of_our_family')</p>
				<p>@lang('messages.the_students_of_today_are_the_foundation_of_tomorrow._as_the_youngest_members_of_our_family,_they_deserve_every_opportunity_to_rise.')</p>

				<ul>
					<li>✔ @lang('messages.what_we_do_list_item_1')</li>
					<li>✔ @lang('messages.what_we_do_list_item_2')</li>
					<li>✔ @lang('messages.what_we_do_list_item_3')</li>
				</ul>
				<p> @lang('messages.what_we_do_list_para')</p>

			</div>
		</div>

	</div>

</section>

<!--  A Transparent and Fair System -->

<section>
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<div class="about-sectionn">
					<!-- <span class="sub-title">process</span> -->
					<h2 class="h1 my-3">@lang('messages.stronger_together—for_haryana,_by_haryana')</h2>
					<h4 style="line-height:40px;">@lang('messages.we_are_not_just_from_haryana—we_are_haryana._its_sons_and_daughters,_standing_together_for_its_future.')</h4>
					<p>@lang('messages.bound_by_our_roots_and_driven_by_purpose,_gaamraam_is_not_just_an_organisation;_it_is_a_movement—built_by_haryanvis,_for_haryanvis._a_system_rooted_in_transparency,_trust,_and_shared_responsibility.')</p>
					<p>@lang('messages.here,_every_contribution,_every_effort,_and_every_decision_is_accounted_for_with_complete_openness._every_rupee,_every_action,_and_every_sacrifice_is_valued—because_this_is_your_system,_your_movement,_your_haryana.')</p>
					<span>@lang('messages.this_isn’t_about_a_few—it’s_about_all_of_us.')</span>
					<h6>@lang('messages.together,_we_are_building_a_haryana_where_no_one_is_left_behind.')</h6>
				</div>

			</div>
			<div class="col-lg-6">
				<div class="about-imagee">
					<img src="../public/front/images/abouttt (1).jpg" alt="">
				</div>
			</div>
		</div>

	</div>
</section>



@endsection