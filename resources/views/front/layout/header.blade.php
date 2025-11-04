@php $courses = \App\Models\Course::where('status','1')->get();  @endphp
<header class="header-style1 menu_area-light">
	<div class="navbar-default border-bottom border-color-light-white">
		<!-- start top search -->
		<div class="top-search bg-primary">
			<div class="container">
				<form
					class="search-form"
					action="search.html"
					method="GET"
					accept-charset="utf-8">
					<div class="input-group">
						<span class="input-group-addon cursor-pointer">
							<button
								class="search-form_submit fas fa-search text-white"
								type="submit"></button>
						</span>
						<input
							type="text"
							class="search-form_input form-control"
							name="s"
							autocomplete="off"
							placeholder="Type & hit enter..." />
						<span class="input-group-addon close-search mt-1"><i class="fas fa-times"></i></span>
					</div>
				</form>
			</div>
		</div>
		<!-- end top search -->
		<div class="container">
			<div class="row align-items-center">
				<div class="col-12 col-lg-12">
					<div class="menu_area alt-font">
						<nav class="navbar navbar-expand-lg navbar-light p-0">
							<div class="navbar-header navbar-header-custom">
								<!-- start logo -->
								<a href="{{ url('/') }}" class="">
									<img src="{{ url($websiteLogo) }}" alt="{{ url($websiteLogo) }}" />
								</a>
								<!-- end logo -->
							</div>
							<div class="navbar-toggler bg-primary"></div>
							<ul
								class="navbar-nav ms-auto"
								id="nav"
								style="display: none">
								<li><a href="{{url('/')}}">@lang('messages.home')</a></li>
								@if(count($courses) == 1)
									<li><a href="{{url('course-detail/upsc-union-public-service-commision')}}">@lang('messages.course')</a></li>
									@else
									<li><a href="{{url('course')}}">@lang('messages.course')</a></li>
								@endif
								<li><a href="{{url('become-a-member')}}">@lang('messages.member')</a></li>
								<!-- <li><a href="{{ url('our-institutions') }}">@lang('messages.institutions')</a></li> -->
								<li><a href="{{url('about')}}">@lang('messages.about_us')</a></li>
								<!-- <li><a href="{{ url('member-register?form=login') }}" class="admin-login">@lang('messages.member_login')</a></li> -->
								<li class="mt-0 mt-lg-3">
									<form action="{{ route('change.language') }}" method="GET" id="languageForm">
										<select name="locale" onchange="this.form.submit()" class="form-select">
											<option value="en" {{ session('locale', 'en') == 'en' ? 'selected' : '' }}>English</option>
											<option value="hi" {{ session('locale', 'en') == 'hi' ? 'selected' : '' }}>Hindi</option>
										</select>
									</form>
								</li>

							</ul>
							<!-- <div id="google_translate_element"></div> -->

							<!-- end menu area -->
							<!-- start attribute navigation -->
							<div
								class="attr-nav align-items-xl-center ms-xl-auto main-font">
								<ul>
									<li class="d-xl-inline-block">
										<a href="{{ route('donate-now') }}" class="butn md text-white donate-header"><i class="fas fa-plus-circle icon-arrow before"></i><span class="label">@lang('messages.donate_now')</span><i class="fas fa-plus-circle icon-arrow after"></i></a>
									</li>
								</ul>
							</div>
							<!-- end attribute navigation -->
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
