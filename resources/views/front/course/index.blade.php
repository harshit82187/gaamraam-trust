@extends('front.layout.app')
@section('content')
<section class="page-title-section bg-img cover-background top-position1 left-overlay-dark" data-overlay-dark="9" data-background="{{asset('front/img/bg/bg-04.jpg')}}">
	<div class="container">
		<div class="row text-center">
			<div class="col-md-12">
				<h1>@lang('messages.course')</h1>
			</div>
			<div class="col-md-12">
				<ul>
					<li><a href="{{ url('/') }}">@lang('messages.home')</a></li>
					<li><a href="{{ url()->current() }}">@lang('messages.course')</a></li>
				</ul>
			</div>
		</div>
	</div>
</section>
<section>
	<div class="container">
		<div class="section-heading">
			<h2 class="h1 mb-0">@lang('messages.our_online_courses')</h2>
		</div>
		<div class="row g-xxl-5 mt-n2-6 justify-content-center">
			@if(isset($courses) && count($courses) > 0)
			@foreach($courses as $course)
			<div class="col-md-6 col-xl-4 mt-2-6">
				<a href="{{ route('course-detail', $course->slug) }}">
					<div class="card card-style1 p-0 h-100">
						<div class="card-img rounded-0">
							<div class="image-hover">
								<img class="rounded-top" src="{{ asset($course->image) }}" alt="{{ asset($course->image) }}">
							</div>
						</div>
						<div class="card-body position-relative pt-0 px-1-9 pb-1-9">
							<div class="card-author d-flex"> </div>
							<div class="pt-6">
									<h3 class="h4 mb-4"><a href="{{ route('course-detail', $course->slug) }}">
									{{ session('locale','en')=='hi'?  $course->name_hi : $course->name  }}
									</a></h3>
							</div>
						</div>
					</div>
				</a>
			</div>
			@endforeach
			@endif
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="d-flex justify-content-center mt-3">
					{{ $courses->links() }}
				</div>
			</div>
		</div>
	</div>
</section>
@endsection