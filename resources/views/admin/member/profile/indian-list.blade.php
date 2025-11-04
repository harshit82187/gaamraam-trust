@extends('admin.layout.app')
@section('content')
<div class="page-content">
	<div class="container-fluid">
		@include('admin.member.profile.menu')
		<div class="card">
			<div class="card-header d-block d-sm-flex justify-content-between align-items-center">
				<span></span>
				<div class="d-block d-sm-flex gap-2 align-items-center justify-content-between">
					<form action="{{ url()->current() }}" method="get" class="d-block d-sm-flex gap-2">
						<input type="text" class="form-control filter-name" value="{{ request()->query('name', '') }}" name="name" placeholder="Search Member Name">
						<button class="btn btn-primary mt-2 mt-sm-0">Search</button>
						<button type="button" class="btn btn-info mt-2 mt-sm-0 " onclick="window.location.href='{{ route(Route::currentRouteName()) }}';">Reset</button>
					</form>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive table-card mt-3 mb-1">
					<table class="table align-middle table-nowrap table-striped table-hover table-responsive">
						<thead class="table-light table-dark">
							<tr>
								<th>SL</th>
								<th style="white-space: nowrap;">Member Name</th>
								<th style="white-space: nowrap;"> Contact info</th>
								<th style="white-space: nowrap;">Total Donation</th>
								<th style="white-space: nowrap;">Active Status</th>
								<th style="white-space: nowrap;">Email Verify</th>
								<th>Action </th>
							</tr>
						</thead>
						<tbody>
							@if($indianMembers->count() > 0)
							@foreach($indianMembers as $indianMember)	
							@php $totalDonations = \App\Models\Payment::where('user_id',$indianMember->id)->sum('amount'); @endphp						
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td class="d-flex align-items-center gap-10 w-max-content" style="gap:10px"> 									
									@if($indianMember->profile_image != null)
									<img src="{{ asset($indianMember->profile_image) }}" class="avatar rounded-circle " width="50" >
									@else
									<img src="{{ asset('front/images/no-image.jpg') }}" class="avatar rounded-circle " width="50" >
									@endif
									<a href="{{ route('admin.member.member-info',encrypt($indianMember->id)) }}" class="text-nowrap" style="color: black;">  {{ $indianMember->name ?? 'N/A' }} </a>
								</td>
								<td>
									<div class="mb-1">
										<strong>
										<a href="mailto:{{ $indianMember->email ?? 'N/A' }}" class="title-color hover-c1">{{ $indianMember->email ?? 'N/A' }}</a>
										</strong>
									</div>
									<a class="title-color hover-c1" href="tel:{{ $indianMember->mobile }}">{{ $indianMember->mobile ?? 'N/A' }}</a>
								</td>
								<td>
									<label class="btn text-info bg-soft-info font-weight-bold px-3 py-1 mb-0 fz-12" ></label>{{ $totalDonations ?? '0' }} 
								</td>
								<td>
									<label class="switch">
									<input type="checkbox" class="status-toggle" data-id="{{ $indianMember->id }}" {{ $indianMember->status ? 'checked' : '' }}>
									<span class="slider round"></span>
									</label> 
								</td>
								<td>
									<label class="switch">
									<input type="checkbox" class="email-verify-status-toggle" data-id="{{ $indianMember->id }}" {{ $indianMember->email_verified_at ? 'checked' : '' }}>
									<span class="slider round"></span>
									</label> 
								</td>
								<td>
									<a href="{{ route('admin.member.member-info',encrypt($indianMember->id)) }}" class="btn btn-dark btn-sm" >View</a>
								</td>
							</tr>
							@endforeach
							@else
							<tr>
								<td colspan="6" class="text-danger text-center">No Member Register Yet.</td>
							</tr>
							@endif
						</tbody>
					</table>
					<div class="d-flex justify-content-center mt-4">
							{{ $indianMembers->links('pagination::bootstrap-4') }}
					</div>
				</div>
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
			var ferry_id = $(this).data('id');
	
			$.ajax({
				url: '{{ url('admin/member/member-update-status') }}',
				type: 'POST',
				data: {
					'_token': $('meta[name="csrf-token"]').attr('content'),
					'member_id': member_id,
					'status': status
				},
				success: function(response) {
					iziToast.info({
						title: 'Info',
						message: 'Member status updated successfully!',
						position: 'topRight',
						timeout: 3000,
					});
				},
				error: function(xhr, status, error) {
					  iziToast.error({
						title: 'Error',
						message: 'Error updating status!',
						position: 'topRight',
						timeout: 4000,
						backgroundColor: '#F0D5B6',
						titleColor: '#000', 
						messageColor: '#000', 
						titleSize: '16px',
						messageSize: '16px',
						titleLineHeight: '20px',
						messageLineHeight: '16px',
						titleFontWeight: '700', 
						messageFontWeight: '700'
					    });
				}
			});
		});
	});

	$(document).ready(function() {
		$('.email-verify-status-toggle').change(function() {
			var email_verified_at = $(this).prop('checked') == true ? 1 : 0;
			var member_id = $(this).data('id');
	
			$.ajax({
				url: '{{ url('admin/member/email-verify-update-status') }}',
				type: 'POST',
				data: {
					'_token': $('meta[name="csrf-token"]').attr('content'),
					'member_id': member_id,
					'email_verified_at': email_verified_at
				},
				success: function(response) {
					iziToast.info({
						title: 'Info',
						message: response.message,
						position: 'topRight',
						timeout: 3000,
					});
				},
				error: function(xhr, status, error) {
					  iziToast.error({
						title: 'Error',
						message: 'Error updating status!',
						position: 'topRight',
						timeout: 4000,
						backgroundColor: '#F0D5B6',
						titleColor: '#000', 
						messageColor: '#000', 
						titleSize: '16px',
						messageSize: '16px',
						titleLineHeight: '20px',
						messageLineHeight: '16px',
						titleFontWeight: '700', 
						messageFontWeight: '700'
					    });
				}
			});
		});
	});
</script>
@endpush