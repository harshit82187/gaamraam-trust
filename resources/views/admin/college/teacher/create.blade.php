@extends('admin.layout.app')
@section('content')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endpush
<div class="page-content">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-12">
						<div class="page-title-box d-sm-flex align-items-center justify-content-between">
							<h4 class="mb-sm-0"><img src="{{ asset('admin/assets/img/school.png') }}" alt="school Icon" class="me-2" style="width: 35px; height: 35px;">Add Teacher Details</h4>
							<a href="{{ url('admin/teacher') }}" class="btn btn-dark btn-sm" >Back</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<form id="admin-teacher-store" action="{{ route('admin.teacher.store') }}" method="POST" enctype="multipart/form-data" >
					@csrf
					<div class="row">
						<div class="col-md-6" style="margin-top: 18px;">
							<label>Teacher Profile Picture <span class="text-danger">* </span></label>
							<input type="file" class="form-control" required name="image" accept=".jpeg,.jpg,.png,.webp">
							@error('image')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<div class="col-md-6" style="margin-top: 18px;">
							<label>Teacher Name <span class="text-danger">* </span></label>
							<input type="text" class="form-control alphabet" required value="{{ old('name') }}" name="name" required>
							@error('name')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<div class="col-md-6" style="margin-top: 18px;" >
							<label>Teacher Education <span class="text-danger">* </span></label>
							<input type="text" class="form-control"  name="education" value="{{ old('education') }}" required>
							@error('education')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<div class="col-md-6" style="margin-top: 18px;">
							<label>Teacher Experience (In Year)<span class="text-danger">* </span></label>
							<input type="number" class="form-control" required name="experience" value="{{ old('experience') }}">
							@error('experience')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<div class="col-md-12" style="margin-top: 18px;" >
							<label> About Teacher<span class="text-danger">* </span></label>
							<textarea class="form-control summernote"  name="about" value="{{ old('about') }}" required> </textarea>
							@error('about')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<div class="row">
							<div class="col-md-2" style="margin-top: 18px;" >
								<button type="submit" class="btn btn-primary"  >Submit</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
	$(document).ready(function() {
	    $('.select2').select2({
	        allowClear: true,
	        width:'300px'
	    });
	});
</script>
<script>
	$(document).ready(function() {        
	    $('.summernote').summernote({
	    tabsize: 2,
	    height: 120,
	    toolbar: [
	      ['style', ['style']],
	      ['font', ['bold', 'underline', 'clear']],
	      ['color', ['color']],
	      ['para', ['ul', 'ol', 'paragraph']],
	      ['table', ['table']],
	      ['insert', ['link', 'picture', 'video']],
	      ['view', ['fullscreen', 'codeview', 'help']]
	    ]
	   });
	
	});
</script>
<script>
	$(".alphabet").on("input", function () {
	    this.value = this.value.replace(/[^a-zA-Z.\s]/g, ''); 
	});
	
	$("input[type='number'], .number").on("input", function () {
	    this.value = this.value.replace(/[^0-9.]/g, ''); 
	     if (this.value.length > 10) {
	      this.value = this.value.slice(0, 10); 
	  }
	});
	$(document).on('submit', '#admin-teacher-store', function() {
	    let btn = $('button[type="submit"]');
	    btn.html('⏳ Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
	});
	
	
</script>
@endpush