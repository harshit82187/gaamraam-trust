@extends('front.layout.app')
@section('content')
<section class="page-title-section bg-img cover-background top-position1 left-overlay-dark" data-overlay-dark="9" data-background="{{asset('front/img/bg/bg-04.jpg')}}">
	<div class="container">
		<div class="row text-center">
			<div class="col-md-12">
				<h1>Term & Condition</h1>
			</div>
			<div class="col-md-12">
				<ul>
					<li><a href="{{ url('/') }}">Home</a></li>
					<li><a href="{{ url()->current() }}">Term & Condition</a></li>
				</ul>
			</div>
		</div>
	</div>
</section>
<section>
	<div class="container">
		<div class="row">
			<div class="term-condition-div">

				<p>{!! $term_condition->value !!}</p>
			</div>
		</div>
	</div>
</section>

@endsection