@extends('front.layout.app')
@section('content')

<section class="page-title-section bg-img cover-background top-position1 left-overlay-dark" data-overlay-dark="9" data-background="img/bg/bg-04.jpg">
	<div class="container">
		<div class="row text-center">
			<div class="col-md-12">
				<h1>{{ session('locale','en')=='hi'?  $course->name_hi : $course->name  }}</h1>
			</div>
			<div class="col-md-12">
				<ul>
					<li><a href="{{url('/')}}">@lang('messages.course_home')</a></li>
					<li><a href="{{ url('course')}}">@lang('messages.course_title')</</a></li>
					<li><a href="javascript:void(0)">{{ session('locale','en')=='hi'?  $course->name_hi : $course->name  }}</a></li>

				</ul>
			</div>
		</div>
	</div>
</section>

<section class="courses">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-8 mb-2-9 mb-lg-0">
				<div class="row">
					<div class="col-md-12 mb-1-6 mb-md-1-9">
						<div class="courses-info mb-4">
							<div class="bg-light rounded py-4 px-4 mb-3">

								<h2 class="h1 mb-0">{{ session('locale','en')=='hi'?  $course->name_hi : $course->name  }}</h2>
							</div>
						</div>
						<figure class="mb-0">
							<img class="border-radius-5" src="{{ asset($course->image) }}" alt="{{ asset($course->image) }}">
						</figure>
					</div>
					<div class="col-md-12 mb-1-6 mb-md-2-9">
						<div class="horizontaltab tab-style1">
							<ul class="resp-tabs-list hor_1">
								@php
									$courseDetails = [
										1 => [
											trans('messages.what_is_upsc'),
											trans('messages.who_can_apply_upsc'),
											trans('messages.exam_structure'),
											trans('messages.course_plan_time')
										],
										2 => [
											trans('messages.what_is_ssc'),
											trans('messages.eligibility_ssc'),
											trans('messages.exam_pattern_ssc'),
											trans('messages.course_schedule_ssc')
										]
									];
								@endphp							
							@if(isset($courseDetails[$course->id]))
								@foreach($courseDetails[$course->id] as $detail)
									<li><span class="display-block xs-display-inline-block">{{ $detail }}</span></li>
								@endforeach
							@endif						

							</ul>
							<div class="resp-tabs-container hor_1">
								<div>
									<div class="row">
									   {!! session('locale','en')=='hi'?  $course->tab_one_hi : $course->tab_one  !!}
									</div>

								</div>
								<div>

									<div class="tab2-content">
									{!! session('locale','en')=='hi'?  $course->tab_two_hi : $course->tab_two  !!}

									</div>									
								

								</div>

								<!-- tab3 -->
								<div>
									<div class="tab2-content">
									{!! session('locale','en')=='hi'?  $course->tab_three_hi : $course->tab_three !!}
										

									
									</div>

								</div>

								<!-- tab4 -->
								<div>
									<div class="tab2-content">
									{!! session('locale','en')=='hi'?  $course->tab_four_hi : $course->tab_four  !!}

									
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
								<!-- <h3>Course details</h3> -->
								<h3>@lang('messages.course_why_join_us')</h3>
								<ul>
									@isset($why_join_usDetails)
									@foreach($why_join_usDetails as $why_join_usDetail)
									<li>{{ session('locale','en')=='hi'?  $why_join_usDetail['hi'] : $why_join_usDetail['en'] }}</li>
									@endforeach
									@endisset
									
								</ul>
							</div>
					
						</div>
						<div class="widget">
							<div class="widget-title">
								<!-- <h3>Course Categories</h3> -->
								<h3>@lang('messages.course_program_include')</h3>

							</div>
							<ul>
								@isset($programsDetails)
									@foreach($programsDetails as $programsDetail)
									<li>{{ session('locale','en')=='hi'?  $programsDetail['hi'] : $programsDetail['en'] }}</li>
									@endforeach
								@endisset
							</ul>
							<!-- <ul class="category-list">
								<li><i class="fas fa-hand-point-right"></i>Foundation Course <span>🏛️</span></li>
								<li><i class="fas fa-hand-point-right"></i> Prelims Crash Course <span>⏳</span></li>
								<li><i class="fas fa-hand-point-right"></i>Mains Answer Writing Program <span>✍️</span></li>
								<li><i class="fas fa-hand-point-right"></i>Optional Subject Coaching <span>📚</span></li>
								<li><i class="fas fa-hand-point-right"></i>Interview Guidance Program (Personality Test) <span>🎙️</span></li>
								<li><i class="fas fa-hand-point-right"></i>Weekend & Working Professionals’ Seminar's <span>🏢</span></li>
							</ul> -->
						</div>
						<div class="widget">
							<div class="widget-title">
								<!-- <h3>Popular Tags</h3> -->
								@if($course->id == 1)
								<h3>@lang('messages.course_prelims_prepration')</h3>
								@elseif($course->id == 2)
								<h3>@lang('messages.course_hssc_course_prepration')</h3>
								@endif
							</div>
							<ul style="margin-left:-9%;">
								{!! session('locale','en')=='hi'?  $course->preparation_plans_hi : $course->preparation_plans  !!}
							</ul>
							<!-- <ul class="course-tags">
								@foreach($tagsDetails as $tagsDetail)
								<li><a href="javascript:void(0)">{{ $tagsDetail }}</a></li>
								@endforeach

							</ul> -->
						</div>
						<div class="widget">
							<div class="widget-title">
								<h3>@lang('messages.course_main_ans_serise')</h3>

							</div>
							<ul>
								@isset($test_seriesDetails)
									@foreach($test_seriesDetails as $test_seriesDetail)
									<li>{{ session('locale','en')=='hi'?  $test_seriesDetail['hi'] : $test_seriesDetail['en'] }}</li>
									@endforeach
								@endisset
							</ul>
							<!-- <h4 class="display-27 display-md-25 display-xl-20 font-weight-800 mb-1-6 text-capitalize mt-3">Related Courses</h4> -->
							<!-- <div class="owl-carousel owl-theme related-courses-carousel">
								@isset($otherCourses)
								@foreach($otherCourses as $otherCourse)
								<div class="card card-style1 p-0 h-100">
									<a href="{{ route('course-detail',$otherCourse->slug) }}">
										<div class="card-img rounded-0">
											<div class="image-hover">
												<img class="rounded-top" src="{{ asset($otherCourse->image) }}" alt="{{ asset($otherCourse->image) }}">
											</div>

										</div>
										<div class="card-body position-relative pt-0 px-1-9 pb-1-9">
											<div class="pt-6">
												<h4 class="h4 mb-4">{{ $otherCourse->name }}</h4>
											</div>
										</div>
									</a>

								</div>
								@endforeach
								@endif

							</div> -->
						</div>
						<div class="widget">
							<div class="widget-title">
								<h3>@lang('messages.course_eligibility_criteria')</h3>
							</div>
							<ul>
								@isset($criteriaDetails)
									@foreach($criteriaDetails as $criteriaDetail)
									<li>{{ session('locale','en')=='hi'?  $criteriaDetail['hi'] : $criteriaDetail['en'] }}</li>
									@endforeach
								@endisset

							</ul>
						</div>
						<div class="widget">
							<div class="widget-title">
								<h4 class="display-27 display-md-25 display-xl-20 font-weight-800 mb-1-6 text-capitalize mt-3">@lang('messages.course_related_course')</h4>
							</div>
							<!-- <h4 class="display-27 display-md-25 display-xl-20 font-weight-800 mb-1-6 text-capitalize mt-3">Related Courses</h4> -->
							<div class="owl-carousel owl-theme related-courses-carousel">
								@isset($otherCourses)
								@foreach($otherCourses as $otherCourse)
								<div class="card card-style1 p-0 h-100">
									<a href="{{ route('course-detail',$otherCourse->slug) }}">
										<div class="card-img rounded-0">
											<div class="image-hover">
												<img class="rounded-top" src="{{ asset($otherCourse->image) }}" alt="{{ asset($otherCourse->image) }}">
											</div>

										</div>
										<div class="card-body position-relative pt-0 px-1-9 pb-1-9">
											<div class="pt-6">
												<h4 class="h4 mb-4">{{ session('locale','en')=='hi'?  $otherCourse->name_hi : $otherCourse->name  }}</h4>
											</div>
										</div>
									</a>

								</div>
								@endforeach
								@endif

							</div>
						</div>

					</div>
				</div>

			</div>
			<!--  end courses list right-->
		</div>
	</div>
</section>
@endsection