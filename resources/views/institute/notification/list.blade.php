@extends('institute.layout.app')
@section('content')
@push('css')

@endpush
<div class="card">
	<div class="card-header d-flex  align-items-center" style="gap:10px;">
		<h3>Notification</h3>
		<span class="count-circle" style="position: unset;" >{{ count($notifications ) }}</span>
	
	</div>
	<br>
	<div class="card-body">
		<div class="table-responsive table-card mt-3 mb-1">
			<table class="table align-middle table-nowrap ">
				<thead class="table-light">
					<tr>
						<th>SL</th>
						<th>Image</th>
						<th>Subject</th>
						<th>Description</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@if(count($notifications) > 0)
						@foreach($notifications as $notification) 
						<tr>
								<td>{{ $loop->iteration }}</td>
								<td>
									@if($notification->image == null)
									<img src="{{ asset('front/images/no-image.jpg') }}" height="50px" width="50px" >
									@else
									<a href="{{ asset($notification->image) }}" target="_blank">
									<img src="{{ asset($notification->image) }}" height="50px" width="50px" >
									</a>
									@endif
								</td>
								<td>
									{{ Illuminate\Support\Str::limit($notification->subject, 25) }} 
									<i class="fa fa-info-circle" data-toggle="tooltip" title="{{ $notification->subject }}"></i>  
								</td>
								<td> 
									{{ Illuminate\Support\Str::limit(strip_tags($notification->description), 65) }} 
									<i class="fa fa-info-circle" data-toggle="tooltip" title="{{ strip_tags($notification->description) }}"></i>  
								</td>
								<td>
									<a href="javascript:void(0)" data-id="{{ $notification->id }}" data-subject="{{ $notification->subject }}" data-description="{{ strip_tags($notification->description) }}" class="btn btn-dark btn-sm view-button" >View</a>
								</td>
							</tr>
						@endforeach           
						@else 
						<tr>
							<td class="text-center" colspan="6" >No Notifications Found</td>
						</tr>
					@endif          
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