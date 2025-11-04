@extends('front.layout.app')
@section('content')
<section class="page-title-section bg-img cover-background top-position1 left-overlay-dark" data-overlay-dark="9" data-background="{{asset('front/img/bg/bg-04.jpg')}}">
	<div class="container">
		<div class="row text-center">
			<div class="col-md-12">
				<h1>Privacy & Policy</h1>
			</div>
			<div class="col-md-12">
				<ul>
					<li><a href="{{ url('/') }}">Home</a></li>
					<li><a href="{{ url()->current() }}">Privacy & Policy</a></li>
				</ul>
			</div>
		</div>
	</div>

</section>
<section>
	<div class="container">
		<div class="row">
			<div class="privacy-contentt">
				<p>{!! $privacy_policy->value ?? '' !!}</p>
			</div>
		</div>
	</div>
</section>

@endsection