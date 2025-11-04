@extends('front.layout.app')
@section('content')

<section class="page-title-section bg-img cover-background top-position1 left-overlay-dark" data-overlay-dark="9" data-background="img/bg/bg-04.jpg">
	<div class="container">
		<div class="row text-center">
			<div class="col-md-12">
				<h1>{{ $course->name ?? '' }}</h1>
			</div>
			<div class="col-md-12">
				<ul>
					<li><a href="{{url('/')}}">Home</a></li>
					<li><a href="{{ url('course')}}">Course</a></li>
					<li><a href="javascript:void(0)">{{ $course->name ?? '' }}</a></li>

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

								<h2 class="h1 mb-0">{{ $course->name ?? '' }}</h2>
							</div>
						</div>
						<figure class="mb-0">
							<img class="border-radius-5" src="{{ asset($course->image) }}" alt="{{ asset($course->image) }}">
						</figure>
					</div>
					<div class="col-md-12 mb-1-6 mb-md-2-9">
						<div class="horizontaltab tab-style1">
							<ul class="resp-tabs-list hor_1">
								<li><span class="display-block xs-display-inline-block">What is UPSC?</span></li>
								<li><span class="display-block xs-display-inline-block">Who Can Apply for UPSC?</span></li>
								<li><span class="display-block xs-display-inline-block">Exam Structure</span></li>
								<li><span class="display-block xs-display-inline-block">Course Plan & Schedule</span></li>

							</ul>
							<div class="resp-tabs-container hor_1">
								<div>
									<div class="row">
										{!! $course->tab_one ?? '' !!}
									</div>

								</div>
								<div>

									<div class="tab2-content">
										<h5>1. Nationality Criteria:</h5>
										<ul>
											<li>Only Indian citizens can apply for IAS, IPS, and IFS.
											</li>
											<li>Indian citizens and certain other nationalities (as per UPSC rules) can apply for other central
												services.</li>
										</ul>
									</div>

									<div class="tab2-content">
										<h5>2. Educational Qualification:</h5>
										<ul>
											<li>A graduate degree (in any subject) from a recognised university.</li>
											<li>Final-year students can apply but must submit proof of graduation before Mains.</li>
											<li>No minimum percentage requirement in graduation.</li>
										</ul>
									</div>
									<div class="tab2-content">
										<h5>3. Age Limit & Attempt Criteria:</h5>
										<table class="table">
											<thead>
												<tr>

													<th scope="col">Category</th>
													<th scope="col">Age limit</th>
													<th scope="col">Number of Attempt</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>General</td>
													<td>21 to 32

														years</td>
													<td>6 Attempts</td>
												</tr>
												<tr>

													<td>OBC</td>
													<td>21 to 35
														years</td>
													<td>9 Attempts</td>
												</tr>
												<tr>

													<td>SC/ST</td>
													<td>21 to 37
														years</td>
													<td>Unlimited Attempts</td>
												</tr>
												<td>PwBD</td>
												<td>21 to 42
													years</td>
												<td>As per category rules</td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="tab2-content">
										<h5>4. Physical & Medical Standards:</h5>
										<ul>
											<li>Required for IPS, IFS, and certain services.</li>
											<li>Candidates must meet vision, hearing, height, and general health standards.</li>

										</ul>
									</div>
									<div class="tab2-content">
										<h5>5. Reservation & Relaxation Benefits:</h5>
										<ul>
											<li>SC/ST & OBC Candidates – Age relaxation and fee exemption.</li>
											<li>EWS (Economically Weaker Section) Candidates – 10% reservation in vacancies.</li>

										</ul>
									</div>

								</div>

								<!-- tab3 -->
								<div>
									<div class="tab2-content">
										<h5>Stage 1: Prelims (May-June 2026)</h5>
										<p>The UPSC Preliminary Examination is a screening test and does not count towards the final
											ranking. Only candidates who clear Prelims cut-off qualify for Mains.</p>
										<h6>Prelims Exam Pattern</h6>
										<table class="table">
											<thead>
												<tr>

													<th scope="col">Paper</th>
													<th scope="col">Subject</th>
													<th scope="col">Marks</th>
													<th scope="col">Duration</th>
													<th scope="col">Negative Marking</th>
												</tr>
											</thead>
											<tbody>
												<tr>

													<td>Paper 1</td>
													<td>General Studies</td>
													<td>200</td>
													<td>2 Hours</td>
													<td>Yes (-0.33 per wrong answer)</td>
												</tr>
												<tr>

													<td>Paper 2</td>
													<td>CSAT (Aptitude Test)</td>
													<td>200</td>
													<td>2 Hours</td>
													<td>Yes (-0.33 per wrong answer)</td>
												</tr>
											</tbody>
										</table>
										<div class="paper-2-content">
											<h5>Paper 1: General Studies (GS)</h5>
										</div>
										<ul>
											<li>Number of Questions: 100
											</li>
											<li>
												<h6>Syllabus Coverage:</h6>
											</li>
											<ul>


												<li>History of India & Indian National Movement</li>
												<li>Indian Polity & Governance (Constitution, Panchayati Raj, Public Policy)</li>
												<li>Geography (Physical, Social, Economic Geography of India & World)</li>
												<li>Indian Economy (Basic concepts, budgeting, planning, growth & development)</li>
												<li>General Science & Technology</li>
												<li>Environmental Ecology, Climate Change, & Biodiversity</li>
												<li>Current Affairs (National & International Importance)</li>
											</ul>
											<li>
												<h6>Cut-off Based Selection:</h6>
											</li>
											<ul>
												<li>The cut-off varies yearly based on difficulty level and competition.</li>
												<li>Marks in Paper 1 decide selection for Mains.</li>
											</ul>
										</ul>
										<h5>Paper 2: CSAT (Civil Services Aptitude Test)</h5>
										<ul>
											<li>Number of Questions: 80</li>
											<li>
												<h6>Syllabus Coverage:</h6>
											</li>
											<ul>
												<li>Comprehension & English Language Skills</li>
												<li>Logical Reasoning & Analytical Ability</li>
												<li>Basic Mathematics & Data Interpretation (10th Standard Level)</li>
											</ul>
											<li>Only 33% required to qualify (Marks not counted in ranking).</li>
											<li>Many students struggle due to overconfidence – regular practice is necessary.</li>
										</ul>
										<h5>Stage 2: Mains (September-October 2026)</h5>

										<h6>Mains Exam Pattern</h6>
										<table class="table">
											<thead>
												<tr>

													<th scope="col">Paper</th>
													<th scope="col">Subject</th>
													<th scope="col">Marks</th>
													<th scope="col">Nature</th>

												</tr>
											</thead>
											<tbody>
												<tr>

													<td>Paper A</td>
													<td>Indian Language</td>
													<td>300</td>
													<td>Qualifying (Min 25%)</td>

												</tr>
												<tr>
													<td>Paper B</td>
													<td>English</td>
													<td>300</td>
													<td>Qualifying (Min 25%)</td>
												</tr>
												<tr>
													<td>Paper 1</td>
													<td>Essay</td>
													<td>250</td>
													<td>Counted for Merit</td>
												</tr>
												<tr>
													<td>Paper 2</td>
													<td>General Studies 1 (GS-1)</td>
													<td>250</td>
													<td>Counted for Merit</td>
												</tr>
												<tr>
													<td>Paper 3</td>
													<td>General Studies 2 (GS-2)</td>
													<td>250</td>
													<td>Counted for Merit</td>
												</tr>
												<tr>
													<td>Paper 4</td>
													<td>General Studies 3 (GS-3)</td>
													<td>250</td>
													<td>Counted for Merit</td>
												</tr>
												<tr>
													<td>Paper 5</td>
													<td>General Studies 4 (GS-4 -
														Ethics)</td>
													<td>250</td>
													<td>Counted for Merit</td>
												</tr>
												<tr>
													<td>Paper 6</td>
													<td>Optional Subject (Paper 1)</td>
													<td>250</td>
													<td>Counted for Merit</td>
												</tr>
												<tr>
													<td>Paper 7</td>
													<td>Optional Subject (Paper 2)</td>
													<td>250</td>
													<td>Counted for Merit</td>
												</tr>
											</tbody>
										</table>
										<h6>✔ Total Marks in Mains: 1750</h6>
										<h6>✔ GS-1 to GS-4 Cover:</h6>
										<ul>
											<li>Indian Heritage & Culture, History, and Geography (GS-1)</li>
											<li>Governance, Constitution, Polity, Social Justice, & International Relations (GS-2)</li>
											<li>Indian Economy, Science & Technology, Environment, and Security Issues (GS-3)</li>
											<li>Ethics, Integrity, and Aptitude (GS-4)</li>

										</ul>
										<h6>✔ Essay Paper:</h6>
										<ul>
											<li>Two essays to be written (250 Marks)</li>
											<li>Topics can be on: Governance, Philosophy, Ethics, Social Issues, etc.</li>
										</ul>
										<h6>Optional Subject (Paper 1 & 2):</h6>
										<ul>
											<li>Candidates choose 1 Optional Subject (like History, Public Administration, Political Science,
												Sociology, etc.)</li>
											<li>Each paper carries 250 Marks (Total 500 Marks)</li>
										</ul>
										<h6>Total Marks for Mains = 1750 (Excluding Language Papers A & B, which are just qualifying).</h6>

										<h5>Stage 3: Interview (Feb-March 2027)</h5>
										<ul>
											<li>Conducted at UPSC Bhavan, Delhi</li>
											<li>Marks: 275</li>
											<li>Total Merit Calculation: Mains (1750) + Interview (275) = 2025 Marks</li>
										</ul>
										<h6>Personality Test Details:</h6>
										<ul>
											<li>The Interview Board assesses:</li>
											<ul>
												<li>Mental Alertness & Decision-Making</li>
												<li>Leadership & Communication Skills</li>
												<li>Social Awareness & Ethical Integrity</li>
												<li>Knowledge of Current Affairs</li>
											</ul>
										</ul>
										<h6>✔ No fixed syllabus – Focus is on personality and judgment.</h6>
										<h6>✔ A well-balanced personality is crucial to score well.</h6>
										<h6>UPSC Final Merit Calculation</h6>
										<ul>
											<li>Prelims → Qualifying (Only used for Mains selection)</li>
											<li>Mains → 1750 Marks (Merit-Determining)</li>
											<li>Interview → 275 Marks (Personality Test)</li>
										</ul>
										<h6>Final Rank = Mains (1750) + Interview (275) = 2025 Marks</h6>
										<p>Cut-offs vary yearly based on difficulty level and competition.</p>
									</div>

								</div>

								<!-- tab4 -->
								<div>
									<div class="tab2-content">
										<h6>Subject-Wise Course Schedule (2025-26)</h6>
										<table class="table">
											<thead>
												<tr>
													<th scope="col">Subject</th>
													<th scope="col">Duration (Weeks)</th>
													<th scope="col">Start Date</th>
													<th scope="col">End Date</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>Geography</td>
													<td>7-9 weeks</td>
													<td>30 Apr 2025</td>
													<td>31 June 2025</td>
												</tr>
												<tr>
													<td>Economics + Agriculture & Food Security</td>
													<td>6-7 weeks</td>
													<td>1 July 2025</td>
													<td>15 Aug 2025</td>
												</tr>
												<tr>
													<td>Ancient & Medieval History + Art & Culture</td>
													<td>5-6 weeks</td>
													<td>16 Aug 2025</td>
													<td>20 Sep 2025</td>
												</tr>
												<tr>
													<td>Modern History + Post-Independence History</td>
													<td>4-5 weeks</td>
													<td>21 Sep 2025</td>
													<td>5 Nov 2025</td>
												</tr>
												<tr>
													<td>Polity & International Relations</td>
													<td>5-6 weeks</td>
													<td>6 Nov 2025</td>
													<td>5 Dec 2025</td>
												</tr>
												<tr>
													<td>Ethics + Governance Case Studies</td>
													<td>7-9 weeks</td>
													<td>26 Dec 2025</td>
													<td>20 Jan 2026</td>
												</tr>											
												<tr>
													<td>Indian Society & Social Justice</td>
													<td>4-5 weeks</td>
													<td>21 Jan 2026</td>
													<td>28 Feb 2026</td>
												</tr>
												<tr>
													<td>Biodiversity & Environment</td>
													<td>3-4 weeks</td>
													<td>29 Feb 2026</td>
													<td>15 Mar 2026</td>
												</tr>
												<tr>
													<td>Internal Security + Cybersecurity & Border Security</td>
													<td>2 weeks</td>
													<td>16 Mar 2026</td>
													<td>1 Apr 2026</td>
												</tr>
												<tr>
													<td>Disaster Management</td>
													<td>2 weeks</td>
													<td>2 Apr 2026</td>
													<td>14 Apr 2026</td>
												</tr>
												<tr>
													<td>World History</td>
													<td>2 weeks</td>
													<td>15 Apr 2026</td>
													<td>29 Apr 2026</td>
												</tr>
												<tr>
													<td>Science & Technology</td>
													<td>3-4 weeks</td>
													<td>30 Apr 2026</td>
													<td>20 May 2026</td>
												</tr>
												<tr>
													<td>Essay Writing</td>
													<td>2 weeks</td>
													<td>21 May 2026</td>
													<td>4 Jun 2026</td>
												</tr>
											</tbody>
											<tr>
													<td>CSAT</td>
													<td>5-6 weeks</td>
													<td>5 Jun 2026</td>
													<td>18 Jul 2026</td>
												</tr>
										</table>
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
								<h3>Why Join Us?</h3>
								<ul>
									@isset($why_join_usDetails)
									@foreach($why_join_usDetails as $why_join_usDetail)
									<li>{{ $why_join_usDetail }}</li>
									@endforeach
									@endisset
									
								</ul>
							</div>
							<!-- <ul class="course-list">
								@foreach($courseDetails as $detail)
								@php
								$icons = [
								'Duration' => 'time',
								'Viewers' => 'eye',
								'Lectures' => 'files',
								'Students' => 'user',
								'Certificate' => 'medall',
								'Level' => 'menu-alt',
								'Skill level' => 'stats-up',
								'Language' => 'world',
								];
								$iconClass = $icons[$detail['key']] ?? 'info';
								@endphp
								<li>
									<span><i class="ti-{{ $iconClass }} pe-2"></i>{{ $detail['key'] }}</span>
									{{ $detail['value'] }}
								</li>
								@endforeach
							</ul> -->
						</div>
						<div class="widget">
							<div class="widget-title">
								<!-- <h3>Course Categories</h3> -->
								<h3>Program Includes:</h3>

							</div>
							<ul>
								@isset($programsDetails)
									@foreach($programsDetails as $programsDetail)
									<li>{{ $programsDetail }}</li>
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
								<h3>Prelims Preparation Plan</h3>
							</div>
							<ul>
								@isset($preparation_plansDetails)
									@foreach($preparation_plansDetails as $preparation_plansDetail)
									<li>{{ $preparation_plansDetail }}</li>
									@endforeach
								@endisset
							</ul>
							<!-- <ul class="course-tags">
								@foreach($tagsDetails as $tagsDetail)
								<li><a href="javascript:void(0)">{{ $tagsDetail }}</a></li>
								@endforeach

							</ul> -->
						</div>
						<div class="widget">
							<div class="widget-title">
								<h3>Mains Answer Writing & Test Series</h3>

							</div>
							<ul>
								@isset($test_seriesDetails)
									@foreach($test_seriesDetails as $test_seriesDetail)
									<li>{{ $test_seriesDetail }}</li>
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
								<h3>Eligibility Criteria for Admission:</h3>
							</div>
							<ul>
								@isset($criteriaDetails)
									@foreach($criteriaDetails as $criteriaDetail)
									<li>{{ $criteriaDetail }}</li>
									@endforeach
								@endisset

							</ul>
						</div>
						<div class="widget">
							<div class="widget-title">
								<h4 class="display-27 display-md-25 display-xl-20 font-weight-800 mb-1-6 text-capitalize mt-3">Related Courses</h4>
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
												<h4 class="h4 mb-4">{{ $otherCourse->name }}</h4>
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