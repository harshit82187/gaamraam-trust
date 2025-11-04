@extends('student.layout.app')
@section('content')
<div class="page-content">
	<div class="card">
		<div class="card-header" style="display: flex;justify-content: space-between;align-items: center;">
			<h3>Notifications<span class="count-circle" style="top:12px;">{{ count($notifications) ?? '0' }}</span></h3>
			
		</div>
		<br>
		<div class="card-body">
			<div class="table-responsive table-card mt-3 mb-1">
				<table class="table align-middle table-nowrap table-striped">
					<thead class="table-light">
						<tr>
							<th>S No.</th>
							<th>Image</th>
							<th>Subject</th>
							<th>Description </th>
							<th>Action </th>
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
							<td colspan="5" class="text-center">Notification's Not Found</td>
						</tr>
						@endif                   
					</tbody>
				</table>
				<div class="d-flex justify-content-center mt-3">
					{{ $notifications->links() }}
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="notification-modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">View Notification</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="mb-3">
					<label for="subject" class="form-label">Subject</label>
					<input type="text" class="form-control" id="subject" name="subject" readonly>
				</div>
				<div class="mb-3">
					<label for="description" class="form-label">Description</label>
					<textarea class="form-control" id="description" name="description" rows="4" readonly></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
@endsection

@push('js')
<script>
	$('.view-button').on('click',function(){
	    // alert(121);
	    var id = $(this).data('id');
	    var subject = $(this).data('subject');
	    var description = $(this).data('description');
	    console.log("Subject : "+subject);
	    console.log("Description : "+description);
	
	    
	    $('#notification-modal').modal('show');
	    $('#subject').val(subject);
	    $('#description').val(description);
	
	
	});
</script>
@endpush