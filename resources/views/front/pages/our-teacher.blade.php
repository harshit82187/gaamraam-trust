@extends('front.layout.app')
@section('content')
<section class="page-title-section bg-img cover-background top-position1 left-overlay-dark" data-overlay-dark="9" data-background="{{asset('front/img/bg/bg-04.jpg')}}">
	<div class="container">
		<div class="row text-center">
			<div class="col-md-12">
				<h1>Our Teacher</h1>
			</div>
			<div class="col-md-12">
				<ul>
					<li><a href="{{ url('/') }}">Home</a></li>
					<li><a href="{{ url()->current() }}">Our Teacher</a></li>
				</ul>
			</div>
		</div>
	</div>
</section>
<section>
    <div class="container">
        <div class="section-heading">
            <!-- <span class="sub-title">process</span> -->
            <h2 class="h1 mb-0">Our Teachers Staff</h2>
        </div>
        <div class="row">
            <div class="process-wrapper">
                <!-- <div class="process-background"></div> -->
                <div class="process-content-wrapper">
                    <div class="row mt-n1-9">
                        @if(!empty($teachers))
                        @foreach($teachers as $teacher)
                         <div class="col-lg-3 mt-1-9">
                            <div class="process-content-teacher">
                                <div class="student-image-block py-2">
                                    <img src="{{asset($teacher->image) }}" alt="{{ $teacher->name}}">
                                </div>
                                <!-- <div class="mb-1-6 mb-lg-1-9">
									<img src="https://server1.pearl-developer.com/gaamraam/public/front/images/process-01.png" alt="..." />
								</div> -->
                                <h3 class="h4">{{$teacher->name}}</h3>
                                <div class="social-media-block">
                                    Experience :  {{  $teacher->experience }} Year <br>
                                    {{  $teacher->education  }}
                                </div>
                                <p class="mb-0">
                                    {!!$teacher->about!!}
                                </p>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection