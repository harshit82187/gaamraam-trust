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
							<h4 class="mb-sm-0"><img src="{{ asset('admin/assets/img/school.png') }}" alt="school Icon" class="me-2" style="width: 35px; height: 35px;">Edit Teacher Details</h4>
							<a href="{{ url('admin/teacher') }}" class="btn btn-dark btn-sm" >Back</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<form id="admin-teacher-update" action="{{ route('admin.teacher.update',$teacher->id) }}" method="POST" enctype="multipart/form-data" >
					@csrf
                    @method('PUT')
                    <div class="row text-center">
                        <div class="col-12">
                            <img src="{{ $teacher->image ? asset($teacher->image) : asset('front/images/no-image.jpg') }}" style="height: 150px; width: 150px;" class="avatar-img ">
                        </div>
                    </div>
					<div class="row mt-3">
						<div class="col-md-6" style="margin-top: 18px;">
							<label>Teacher Profile Picture </label>
							<input type="file" class="form-control"  name="image" accept=".jpeg,.jpg,.png,.webp">
							@error('image')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<div class="col-md-6" style="margin-top: 18px;">
							<label>Teacher Name <span class="text-danger">* </span></label>
							<input type="text" class="form-control alphabet" required value="{{ $teacher->name }}" name="name" required>
							@error('name')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<div class="col-md-6" style="margin-top: 18px;" >
							<label>Teacher Education <span class="text-danger">* </span></label>
							<input type="text" class="form-control"  name="education" value="{{ $teacher->education }}" required>
							@error('education')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<div class="col-md-6" style="margin-top: 18px;">
							<label>Teacher Experience (In Year)<span class="text-danger">* </span></label>
							<input type="number" class="form-control" required name="experience" value="{{ $teacher->experience }}">
							@error('experience')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<div class="col-md-12" style="margin-top: 18px;" >
							<label> About Teacher<span class="text-danger">* </span></label>
							<textarea class="form-control summernote"  name="about"  required>{{  $teacher->about }} </textarea>
							@error('about')
							<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
						<div class="row">
							<div class="col-md-2" style="margin-top: 18px;" >
								<button type="submit" class="btn btn-primary"  >Update</button>
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
	$(document).on('submit', '#admin-teacher-update', function() {
	    let btn = $('button[type="submit"]');
	    btn.html('⏳ Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
	});
	
	
</script>
@endpush