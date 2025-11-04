@extends('admin.layout.app')
@section('content')
<div class="card">
	<div class="card-header d-block d-sm-flex justify-content-between align-items-center">
		<div class="d-flex gap-2 align-items-center">
			<h3 class="mb-0">Student Documents</h3>
			<span class="count-circle " style="position:unset;">{{ count($documents ) }}</span>
		</div>

		<div class="d-flex align-items-center  gap-3">
			<form action="{{ url()->current() }}" method="get" class=" gap-2 d-block d-sm-flex ">
				<input type="text" class="form-control w-100" value="{{ request()->query('name', '') }}" name="name" required placeholder="Search Student Name">
				<button class="btn btn-primary mt-2 mt-sm-0">Search</button>
				<a class="btn btn-info mt-2 mt-sm-0" onclick="window.location.href='{{ route(Route::currentRouteName()) }}';">Reset</a>
			</form>
		</div>
	</div>
	<br>

	<div class="card-body">
		<div class="table-responsive table-card mt-3 mb-1">
			<table class="table align-middle table-nowrap table-striped table-hover table-responsive">
				<thead class="table-light table-dark">
					<tr>
						<th>S No.</th>
						<th>Student Name</th>
						<th>Image</th>
						<th>Marksheet Name</th>
						<th>Status</th>
						<th>Approved</th>
					</tr>
				</thead>
				<tbody>
					@if(count($documents) > 0)
					@foreach($documents as $document)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>
							{{ $document->student->name ?? '' }}
						</td>
						<td>
							@if($document->marksheet == null)
							<img src="{{ asset('front/images/no-image.jpg') }}" height="50px" width="50px">
							@else
							<a href="{{ asset($document->marksheet) }}" target="_blank">
								<img src="{{ asset('front/images/pdf.png')  }}" height="50px" width="50px">
							</a>
							@endif
						</td>
						<td>
							@if($document->name == 1)
							10th Marksheet
							@elseif($document->name == 2)
							12th Marksheet
							@elseif($document->name == 3)
							Graduation 1 Year Marksheet
							@elseif($document->name == 4)
							Graduation 2 Year Marksheet
							@elseif($document->name == 5)
							Graduation 3 Year Marksheet
							@elseif($document->name == 6)
							Character Certificate
							@elseif($document->name == 7)
							Domicile Certificate
							@endif
						</td>
						<td>
							@if($document->status == 1)
							Passed
							@else
							Appeared
							@endif
						</td>
						<td>

							<!-- @if($document->approved == 0)
                            <span class="badge bg-warning">Pending</span>
                        @elseif($document->approved == 1)
                            <span class="badge bg-danger">Re-upload</span>
                        @elseif($document->approved == 2)
                            <span class="badge bg-success">Approved</span>
                        @endif -->


							<form action="{{ route('admin.student.document.update.approved', $document->id) }}" method="POST" style="display:inline;">
								@csrf
								@method('PATCH')
								<select name="approved" onchange="this.form.submit()" class="form-select form-select-sm">
									<option value="0" {{ $document->approved == 0 ? 'selected' : '' }}>Pending</option>
									<option value="1" {{ $document->approved == 1 ? 'selected' : '' }}>Re-upload</option>
									<option value="2" {{ $document->approved == 2 ? 'selected' : '' }}>Approved</option>
								</select>
							</form>

						</td>
					</tr>
					@endforeach
					@else
					<tr>
						<td colspan="5" class="text-center text-danger">Documents's Not Found</td>
					</tr>
					@endif
				</tbody>
			</table>
			<div class="d-flex justify-content-center mt-3">
				{{ $documents->links('pagination::bootstrap-4') }}
			</div>
		</div>
	</div>
</div>
@endsection
@push('js')
@endpush