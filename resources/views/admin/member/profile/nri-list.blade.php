@extends('admin.layout.app')
@section('content')
<div class="page-content">
	<div class="container-fluid">
        @include('admin.member.profile.menu')
        <div class="card">
			<div class="card-body">
				<div class="table-responsive table-card mt-3 mb-1">
					<table class="table align-middle table-nowrap ">
						<thead class="table-light">
							<tr>
								<th>SL</th>
								<th>Member Name</th>
								<th>Contact info</th>
								<th>Total Donation</th>
								<th>Active Status</th>
								<th>Action </th>
							</tr>
						</thead>
						<tbody>
							@if($nriMembers->count() > 0)
							@foreach($nriMembers as $nriMember)	
							@php $totalDonations = \App\Models\Payment::where('user_id',$nriMember->id)->sum('amount'); @endphp						
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td> 
									<a href="" class="title-color hover-c1 d-flex align-items-center gap-10">
									@if($nriMember->profile_image != null)
									<img src="{{ asset($nriMember->profile_image) }}" class="avatar rounded-circle " >
									@else
									<img src="{{ asset('front/images/no-image.jpg') }}" class="avatar rounded-circle " >
									@endif
									</a>  {{ $nriMember->name ?? 'N/A' }}
								</td>
								<td>
									<div class="mb-1">
										<strong>
										<a href="mailto:{{ $nriMember->email ?? N/A }}" class="title-color hover-c1">{{ $nriMember->email ?? N/A }}</a>
										</strong>
									</div>
									<a class="title-color hover-c1" href="tel:{{ $nriMember->mobile }}">{{ $nriMember->mobile ?? N/A }}</a>
								</td>
								<td>
									<label class="btn text-info bg-soft-info font-weight-bold px-3 py-1 mb-0 fz-12" ></label>{{ $totalDonations ?? '0' }} 
								</td>
								<td>
									<label class="switch">
									<input type="checkbox" class="status-toggle" data-id="{{ $nriMember->id }}" {{ $nriMember->status ? 'checked' : '' }}>
									<span class="slider round"></span>
									</label> 
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
							{{ $nriMembers->links('pagination::bootstrap-4') }}
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
</script>
@endpush
