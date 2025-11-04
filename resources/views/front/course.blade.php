@extends('front.layout.app')
@section('content')
<section class="page-title-section bg-img cover-background top-position1 left-overlay-dark" data-overlay-dark="9"
	data-background="img/bg/bg-04.jpg">
	<div class="container">
		<div class="row text-center">
			<div class="col-md-12">
				<h1>Courses Grid</h1>
			</div>
			<div class="col-md-12">
				<ul>
					<li><a href="{{ url('/') }}">Home</a></li>
					<li><a href="{{ url('course-detail') }}">Courses Grid</a></li>
				</ul>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="container">
		<div class="section-heading">
			<span class="sub-title">discover new</span>
			<h2 class="h1 mb-0">Our Online Courses</h2>
		</div>
		<div class="row g-xxl-5 mt-n2-6 justify-content-center">
			<div class="col-md-6 col-xl-4 mt-2-6">
				<div class="card card-style1 p-0 h-100">
					<div class="card-img rounded-0">
						<div class="image-hover">
							<img class="rounded-top" src="{{ asset('front/images/courses-01.jpg') }}" alt="...">
						</div>
						<a href="{{ url('course-detail') }}" class="course-tag">Learning</a>
						<a href="#!"><i class="far fa-heart"></i></a>
					</div>
					<div class="card-body position-relative pt-0 px-1-9 pb-1-9">
						<div class="card-author d-flex">
							<div class="avatar">
								<img class="rounded-circle" src="{{ asset('front/images/avatar-01.jpg') }}"
									alt="...">
							</div>
							<!-- <h4 class="mb-0 h6">Elijah Lions</h4> -->
						</div>
						<div class="pt-6">
							<h3 class="h4 mb-4"><a href="{{ url('course-detail') }}">UPSC(Union Public Service
								Commision)</a>
							</h3>
							<div class="d-flex justify-content-between align-items-center">
								<div class="display-30"><i class="ti-agenda me-2"></i>10 Lessons</div>
								<div class="display-30"><i class="ti-user me-2"></i>23</div>
								<div class="display-30"><i class="fas fa-star me-1 display-32 text-warning"></i>5.00(1)
								</div>
							</div>
							<div class="dotted-seprator pt-4 mt-4 d-flex justify-content-between align-items-center">
								<span class="badge-soft">all levels</span>
								<!-- <h5 class="text-primary mb-0">$55.00</h5> -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-xl-4 mt-2-6">
				<div class="card card-style1 p-0 h-100">
					<div class="card-img rounded-0 border-color-secondary">
						<div class="image-hover">
							<img class="rounded-top" src="{{ asset('front/images/courses-02.jpg') }}" alt="...">
						</div>
						<a href="{{ url('course-detail') }}" class="course-tag secondary">Learning</a>
						<a href="#!"><i class="far fa-heart"></i></a>
					</div>
					<div class="card-body position-relative pt-0 px-1-9 pb-1-9">
						<div class="card-author d-flex">
							<div class="avatar">
								<img class="rounded-circle" src="{{ asset('front/images/avatar-02.jpg') }}"
									alt="...">
							</div>
							<!-- <h4 class="mb-0 h6">Georgia Train</h4> -->
						</div>
						<div class="pt-6">
							<h3 class="h4 mb-4"><a href="{{ url('course-detail') }}">SSC(Service Selection
								Commision)</a>
							</h3>
							<div class="d-flex justify-content-between align-items-center">
								<div class="display-30"><i class="ti-agenda me-2"></i>09 Lessons</div>
								<div class="display-30"><i class="ti-user me-2"></i>15</div>
								<div class="display-30"><i class="fas fa-star me-1 display-32 text-warning"></i>4.00(2)
								</div>
							</div>
							<div class="dotted-seprator pt-4 mt-4 d-flex justify-content-between align-items-center">
								<span class="badge-soft secondary">beginner</span>
								<!-- <h5 class="text-secondary mb-0">$35.00</h5> -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<!-- start pager  -->
				<div class="text-center mt-6 mt-lg-7">
					<div class="pagination text-extra-dark-gray">
						<ul>
							<li><a href="#!" class="me-3"><i class="fas fa-long-arrow-alt-left"></i></a></li>
							<li class="active"><a href="#!" class="me-2">1</a></li>
							<li><a href="#!" class="me-2">2</a></li>
							<li><a href="#!" class="me-3">3</a></li>
							<li><a href="#!"><i class="fas fa-long-arrow-alt-right"></i></a></li>
						</ul>
					</div>
				</div>
				<!-- end pager -->
			</div>
		</div>
	</div>
</section>
@endsection