@extends('admin.layout.app')
@section('content')

<div class="card">
	<div class="card-header d-block d-md-flex justify-content-between align-items-center" >
		<div class="gap-2  d-flex align-items-center">
			<h3 class="mb-0">College Listing</h3>
			<span class="count-circle" style="position:unset;" >{{ count($colleges) }}</span>
		</div>
		<div class="d-flex align-items-center justify-content-between gap-3">
			<form action="{{ url()->current() }}" method="get" class="gap-2 d-block d-sm-flex ">
				<input type="text" class="form-control mt-2 mt-sm-0" value="{{ request()->query('name', '') }}" name="name" required placeholder="Search College Name">
				<button class="btn btn-primary mt-2 mt-sm-0">Search</button>
				<a class="btn btn-dark mt-2 mt-sm-0 text-nowrap" href="{{ route('admin.college-add') }}" >Add College</a>
				<a class="btn btn-info mt-2 mt-sm-0" href="{{ route('admin.college-list') }}">Reset</a>

			</form>
		</div>
	</div>
	<br>
	<div class="card-body">
		<div class="table-responsive table-card mt-3 mb-1">
			<table class="table align-middle table-nowrap table-hover table-striped table-responsive">
				<thead class="table-light table-dark">
					<tr>
						<th>S No.</th>
                        <th>Image</th>
						<th>College Name</th>
						<th>Contact Details</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@if(count($colleges) > 0)
						@foreach($colleges as $college) 
							<tr>
								<td>{{ $loop->iteration }}</td>
                                <td>
									@if($college->logo == null)
									<img src="{{ asset('front/images/no-image.jpg') }}" height="50px" width="50px" >
									@else
									<a href="{{ asset($college->logo) }}" target="_blank">
									<img src="{{ asset($college->logo)  }}" height="50px" width="50px" >
									</a>
									@endif
								</td>
								<td>{{ $college->name ?? '' }}</td>								
                                <td>
                                    <b>Mobile No :</b>{{ $college->mobile_no }}<br>
                                    <b>Email :</b>{{ $college->email }}<br>
                                </td>								
								<td>
									<label class="switch">
										<input type="checkbox" class="status-toggle" data-id="{{ $college->id }}" {{ $college->status ? 'checked' : '' }}>
									   <span class="slider round"></span>
								   </label>
							   </td>
							   <td>
								<a href="{{ route('admin.college-edit',$college->id) }}" class="btn btn-warning btn-sm" >Edit</a>
							   </td>
								
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
				{{ $colleges->links() }}
			</div>
		</div>
	</div>
</div>

@endsection
@push('js')

<script>
	$(document).ready(function() {
		$('.status-toggle').change(function() {
			var status = $(this).prop('checked') == true ? 1 : 0;
			var college_id = $(this).data('id');

			$.ajax({
				url: '{{ route('admin.college-update-status') }}',
				type: 'POST',
				data: {
					'_token': $('meta[name="csrf-token"]').attr('content'),
					'college_id': college_id,
					'status': status
				},
				success: function(response) {
					iziToast.info({
						title: 'Info',
						message: 'College status updated successfully!',
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