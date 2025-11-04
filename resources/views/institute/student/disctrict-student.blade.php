@extends('institute.layout.app')
@section('content')
@push('css')
<style>
	.my-district{
		background:#15e6e8;
		border-color:#15e6e8;
	}
</style>
@endpush
<div class="card">
	<div class="card-header" style="display: flex;justify-content: space-between;align-items: center;">
		<h3>My district Student's</h3>

	</div>
	<br>
	<div class="card-body">
		<div class="table-responsive table-card mt-3 mb-1">
			<table class="table align-middle table-nowrap ">
				<thead class="table-light">
					<tr>
						<th>S No.</th>
						<th>Name</th>
						<!-- <th>Mobile No</th>
						<th>Email </th> -->
						<th>Course</th>
						<!-- <th>Enrool Date</th> -->
						{{-- <th>Action</th> --}}
					</tr>
				</thead>
				<tbody>
					@foreach($students as $student) 
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $student->name }}</td>
						<!-- <td>{{ $student->mobile }}</td>
						<td>{{ $student->email }}</td> -->
						<td>
							@if($student->course == 1)
								UPSC
							@elseif($student->course == 2)
								SSC
							@else
								N/A
							@endif
						</td>
						<!-- <td>{{ \Carbon\Carbon::parse($student->created_at)->format('d-M-Y') }}</td> -->
						{{-- <td>
							<a href="{{ route('admin.enrool-student-info',$student->id) }}" class="btn btn-dark btn-sm" >View</a>
						</td> --}}
						
					</tr>
					@endforeach                     
				</tbody>
			</table>
		</div>
	</div>
</div>




@endsection
@push('js')
<script>
    $(document).on('submit', '#enrool-student-save-form', function() {
        let btn = $('button[type="submit"]');
        btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
    });
</script>
<script>
	$(document).ready(function(){
	    // alert(121);
	    $('.notification').on('click',function(){
	        var id = $(this).data('id');
	        var email = $(this).data('email');
	    
	        $('#send-notification').modal('show');
	        $('#modalLabel').html('Send Notification : '+email);
	        $('#send-notification').find('input[name="student_id"]').val(id);
	
	
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
@endpush