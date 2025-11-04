@extends('front.layout.app')
@section('content')
@push('css')
<link rel="stylesheet" href="{{ asset('admin/assets/css/404.css') }}">
@endpush
<section class="page_404">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 ">
				<div class="col-sm-10 col-sm-offset-1  text-center">
					<div class="four_zero_four_bg">
						<h1 class="text-center text-danger">404 - Page Not Found</h1>
					</div>
					<div class="contant_box_404">
						<h3 class="h2">
							Oops, looks like the page is lost.
						</h3>
						<p>This is not a fault, just an accident that was not intentional.</p>
						<a href="{{ url('/') }}" class="link_404">Go to Home</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection