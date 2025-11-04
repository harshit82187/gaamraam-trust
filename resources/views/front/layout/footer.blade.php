@php    $visitorCount = \App\Models\VisitorToken::count();
	     $courses = \App\Models\Course::where('status','1')->get();
@endphp
<footer class="bg-dark">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-lg-3 mb-2-5 mb-lg-0">
				<a href="{{ url('/') }}" class="footer-logo">
				<img src="{{ url($websiteLogo) }}" class="mb-4" alt="Footer Logo" />
				</a>
				<div class="contact-detaills">
					<ul>
						<li><i class="fa-solid fa-location-dot"></i> {{ $address }}</li>
						<li><i class="fa-solid fa-phone"></i> {{ $mobile1 }}</li>
						<li><i class="fa-solid fa-envelope"></i> {{ $adminEmail }}</li>
					</ul>
				</div>
				<div class="my-3 text-center">
					<div class="d-flex gap-2">
						<a href="{{ $socialMediaConfig['facebook'] ?? '' }}" target="_blank" type="button" class="btn btn-primary btn-icon waves-effect waves-light"><i class="fa-brands fa-facebook-f"></i></i></a>
						<a href="{{ $socialMediaConfig['instagram'] ?? '' }}" target="_blank" type="button" class="btn btn-insta btn-icon waves-effect waves-light"><i class="fa-brands fa-instagram"></i></i></a>
						<a href="{{ $socialMediaConfig['youtube'] ?? '' }}" target="_blank" type="button" class="btn bg-danger  btn-icon waves-effect waves-light"><i class="fa-brands fa-youtube text-white"></i></i></a>
					</div>
				</div>
				<div class="quform-elements">
					<div class="row">
						<div class="col-md-12">
							<div class=" mb-0">
								<form action="{{ route('subscriber') }}" method="POST">
									@csrf
									<div class="quform-input d-flex align-items-center">
										<div class="d-flex w-100">
											<input class="form-control" id="subscriber-email" type="email" name="email" placeholder="@lang('messages.subscribe_with_us')" />

										</div>
										<button class="btn btn-white text-primary m-0 px-2 footer-bbnt" type="submit">
										<i class="fas fa-paper-plane"></i>
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-6 col-md-6 col-lg-2 mb-2-5 mb-lg-0">
				<div class="ps-md-1-6 ps-lg-1-9">
					<h3 class="text-primary h5 mb-2-2">@lang('messages.about_us')</h3>
					<ul class="footer-list">
						<li><i class="fas fa-info-circle"></i> <a href="{{ url('about') }}">@lang('messages.about_us')</a></li>
						@if(count($courses) == 1)
							<li><i class="fas fa-book-open"></i> <a href="{{url('course-detail/upsc-union-public-service-commision')}}">@lang('messages.course')</a></li>
							@else
							<li><i class="fas fa-book-open"></i> <a href="{{ url('course') }}">@lang('messages.course')</a></li>
						@endif
						<!-- <li><i class="fas fa-envelope"></i> <a href="{{ url('our-institutions') }}">@lang('messages.institutions')</a></li> -->
						<li><i class="fas fa-user-shield"></i> <a href="{{ url('privacy-policy') }}">@lang('messages.privacy_policy')</a>
						</li>
					</ul>
					<div class="d-flex mt-5 position-relative">
						<div class="g-recaptcha mt-3" data-sitekey="6LcdiiIrAAAAAM95DdpLGBA57sVf2XZ-B1Ot4_Kw"></div>
						<span id="captchaError" style="font-size: 20px;" class="text-danger"></span>
					</div>
				</div>
			</div>
			<div class=" col-6 col-md-6 col-lg-3 mb-2-5 mb-md-0">
				<div class="ps-lg-1-9 ps-xl-2-5">
					<h3 class="text-primary h5 mb-2-2">@lang('messages.link')</h3>
					<ul class="footer-list">
						<!-- <li><i class="fas fa-newspaper"></i> <a href="{{ url('blog') }}">Blogs</a></li> -->
						<!-- <li><i class="fas fa-user-graduate"></i> <a href="{{ url('student-review') }}">Student
							Review</a></li> -->
						<li><i class="fas fa-question-circle"></i> <a href=" {{ url('faq') }}">@lang('messages.faq')</a></li>
						<li><i class="fas fa-university"></i> <a href="{{ url('contact') }}">@lang('messages.contact')</a></li>
						<li><i class="fas fa-file-contract"></i> <a href="{{ url('term-condition') }}">@lang('messages.term_and_condition')</a></li>
						<li><i class="fas fa-users"></i> @lang('messages.total_visitors'): {{ $visitorCount ?? '0'}}</li>
					</ul>
				</div>
			</div>
			@php $courses = \App\Models\Course::where('status','1')->get(); @endphp
			<div class="col-md-6 col-lg-4">
				<div class="ps-md-1-9">
					<h3 class="text-primary h5 mb-2-2">@lang('messages.course')</h3>
					@if (isset($courses) && !empty($courses))
					@foreach ($courses as $course)
					<div class="gap-2 media footer-border">
						<img class="border-radius-5" style="max-width: 30%;height: 73px;vertical-align: top; object-fit:cover;"
							src="{{ url($course->image) }}" alt="{{ url($course->image) }}">
						<div class="media-body align-self-center">
							<h4 class="h6 mb-2"><a href="{{ route('course-detail', $course->slug) }}"
								class="text-white text-primary-hover">{{ session('locale','en')=='hi'?  $course->name_hi : $course->name  }}</a></h4>
						</div>
					</div>
					@endforeach
					@endif
				</div>
			</div>
		</div>
		<div class="footer-bar text-center">
			<p class="mb-0 text-white font-weight-500">
				{{ date('Y') }} © All Rights Reserved By <i class="fa fa-heart heart text-danger"></i>
				<a href="{{ url('/') }}" target="_blank" class="text-secondary">Gaam Raam Trust</a> And Powered By
				<a href="{{ url('https://www.pearlorganisation.com/') }}" target="_blank" class="text-secondary">Pearl
				Organisation</a>
			</p>
		</div>
	</div>
</footer>
