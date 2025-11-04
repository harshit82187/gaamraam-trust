@extends('admin.layout.app')
@section('content')

<div class="card">
	<div class="card-header d-block d-md-flex justify-content-between align-items-center">
		<div class="gap-2  d-flex align-items-center">
			<h3 class="mb-0">Contact Us Listing</h3>
			<span class="count-circle" style="position:unset;">{{ count($contacts) }}</span>
		</div>

	</div>
	<br>
	<div class="card-body">
		<div class="table-responsive table-card mt-3 mb-1">
			<table class="table align-middle table-nowrap ">
				<thead class="table-light">
					<tr>
						<th>S No.</th>
						<th>Name</th>
						<th>Email</th>
						<th>Mobile</th>
						<th>Subject</th>
						<th>Message</th>
					</tr>
				</thead>
				<tbody>
					@if(count($contacts) > 0)
					@foreach($contacts as $contact)
					<tr>
						<td class="text-nowrap">{{ $loop->iteration }}</td>
						<td>
							{{$contact->name}}
						</td>
						<td class="text-nowrap">{{ $contact->email ?? '' }}</td>
						<td>
							{{ $contact->mobile ?? '' }}
						</td>
						<td class="text-nowrap">
							{{ $contact->subject ?? '' }}
						</td>
						<td class="text-nowrap" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $contact->message }}">
							{{ Str::limit($contact->message ?? '', 50) }}
						</td>

					</tr>
					@endforeach
					@else
					<tr class="text-nowrap">
						<td colspan="5" class="text-center">Contacts's Not Found</td>
					</tr>
					@endif
				</tbody>
			</table>
			<div class="d-flex justify-content-center mt-4">
				{{ $contacts->links('pagination::bootstrap-4') }}
			</div>
		</div>
	</div>
</div>

@endsection
@push('js')
<script>
	document.addEventListener("DOMContentLoaded", function() {
		var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
		var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
			return new bootstrap.Tooltip(tooltipTriggerEl);
		});
	});
</script>
@endpush