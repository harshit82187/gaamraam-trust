@extends('admin.layout.app')
@section('content')

<div class="card">
	<div class="card-header d-block d-md-flex justify-content-between align-items-center">
		<div class="gap-2  d-flex align-items-center">
			<h3 class="mb-0">College Staff Listing</h3>
			<span class="count-circle" style="position:unset;" >{{ count($staffs) }}</span>
		</div>
		<div class="d-flex align-items-center justify-content-between gap-3">
			<form action="{{ url()->current() }}" method="get" class="gap-2 d-block d-sm-flex ">
				<input type="text" class="form-control mt-2 mt-sm-0" value="{{ request()->query('name', '') }}" name="name" required placeholder="Search College Name">
				<button class="btn btn-primary mt-2 mt-sm-0">Search</button>
				<a class="btn btn-dark text-nowrap" data-bs-target="#add-staff" data-bs-toggle="modal" >Add Staff</a>
				<a class="btn btn-info mt-2 mt-sm-0" href="{{ route('admin.college-list') }}">Reset</a>

			</form>
		</div>
	</div>
	<br>
	<div class="card-body">
		<div class="table-responsive table-card mt-3 mb-1">
			<table class="table align-middle table-nowrap table-hover table-striped">
				<thead class="table-light table-dark">
					<tr>
						<th>S No.</th>
                        <th>Image</th>
						<th>College Detail</th>
						<th>Staff Details</th>
						<th>Status</th>
						{{-- <th>Action</th> --}}
					</tr>
				</thead>
				<tbody>
					@if(count($staffs) > 0)
						@foreach($staffs as $staff) 
							<tr>
								<td>{{ $loop->iteration }}</td>
                                <td>
									@if($staff->logo == null)
									<img src="{{ asset('front/images/no-image.jpg') }}" height="50px" width="50px" >
									@else
									<a href="{{ asset($staff->logo) }}" target="_blank">
									<img src="{{ asset($staff->logo)  }}" height="50px" width="50px" >
									</a>
									@endif
								</td>
								<td>{{ $staff->college->name ?? '' }}</td>								
                                <td>
                                    <b>Name :- </b> {{ $staff->name ?? 'N/A' }}<br>
									<b>Mobile No :- </b> {{ $staff->mobile_no ?? 'N/A' }}<br>
                                    <b>Email :</b> {{ $staff->email }}<br>
                                    <b>Joined At :</b> {{ \Carbon\Carbon::parse($staff->created_at)->format('d-M-Y') }} <br>

                                </td>								
								<td>
									<label class="switch">
										<input type="checkbox" class="status-toggle" data-id="{{ $staff->id }}" {{ $staff->status ? 'checked' : '' }}>
									   <span class="slider round"></span>
								   </label>
							   </td>
							   {{-- <td>
								<a href="{{ route('admin.college-edit',$college->id) }}" class="btn btn-warning btn-sm" >Edit</a>
							   </td> --}}
								
							</tr>
						@endforeach  
					@else
					<tr>
						<td colspan="5" class="text-center">Course's Not Found</td>
					</tr>
					@endif                      
				</tbody>
			</table>
			<div class="d-flex justify-content-center mt-3">
				{{ $staffs->links() }}
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="add-staff" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" >
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Staff  Enrollment</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="college-staff-add-form" action="{{ route('admin.college-staff-add') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
                    <div class="mb-3">
						<label for="college" class="form-label">College Name <span class="text-danger">*</span></label>
                        <select class="form-control select" name="college_id"  required>
                            @php $colleges = \App\Models\College::where('status','1')->get(); @endphp
                            <option disabled value="" selected >--Choose College Name --</option>
                            @isset($colleges)
                            @foreach($colleges as $college)
                            <option value="{{ $college->id }}" >{{ $college->name ?? 'N/A' }}</option>
                            @endforeach
                            @endisset
                        </select>
    				</div>

					<div class="mb-3">
						<label for="name" class="form-label">Staff Name <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="name" placeholder="Enter Staff Name" required>
					</div>

						<div class="mb-3">
						<label for="text" class="form-label">Staff Mobile No <span class="text-danger">*</span></label>
						<input type="text" class="form-control number"  name="mobile_no" placeholder="Enter Staff Mobile No" autocomplete="one-time-code" required>
					</div>
					
					<div class="mb-3">
						<label for="email" class="form-label">Staff Email <span class="text-danger">*</span></label>
						<input type="email" class="form-control"  name="email" placeholder="Enter Staff Email Address" autocomplete="one-time-code" required>
					</div>
					
					<div class="mb-3">
						<label for="password" class="form-label">Staff Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control"  name="password" placeholder="Create Staff Password " autocomplete="one-time-code" required>				
				    </div>


                    
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
@push('js')
<script>
    $(document).on('submit', '#college-staff-add-form', function() {
        let btn = $('button[type="submit"]');
        btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
    });
	$("input[type='number'], .number").on("input", function () {
        this.value = this.value.replace(/[^0-9]/g, '');
         if (this.value.length > 10) {
          this.value = this.value.slice(0, 10); 
      }
    });
   
</script>
<script>
	$(document).ready(function() {
		$('.status-toggle').change(function() {
			var status = $(this).prop('checked') == true ? 1 : 0;
			var staff_id = $(this).data('id');

			$.ajax({
				url: '{{ route('admin.college-staff-status') }}',
				type: 'POST',
				data: {
					'_token': $('meta[name="csrf-token"]').attr('content'),
					'staff_id': staff_id,
					'status': status
				},
				success: function(response) {
					iziToast.info({
						title: 'Info',
						message: 'Statff member status updated successfully!',
						position: 'topRight',
						timeout: 3000,
					});
				},
				error: function(xhr, status, error) {
					iziToast.error({
						title: 'Error',
						message: 'Error updating status!',
						position: 'topRight',
						timeout: 3000
					});
				}
			});
		});
	});
</script>

@endpush