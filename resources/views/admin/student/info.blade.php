@extends('admin.layout.app')
@section('content')
<div class="card">
	<div class="card-header" >
		<h3>{{ $student->name ?? '' }} Info</h3>		
		<a href="{{ url()->previous() }}" class="btn btn-dark btn-sm" >Back</a>
	</div>

	<div class="card-body">
		<form>
			<div class="row">
				<div class="col-md-2 d-flex justify-content-center">
					@if($student->image != null)
						<img src="{{ asset($student->image) }}" class="rounded-circle admin-view-student">
						@else 
						<img src="{{ asset('front/images/no-image.jpg') }}" class=" rounded-circle admin-view-student" >
					@endif
				</div>
				<div class="col-md-5">
					<div class="student_info">
						<form action="#">
							<div class="col-12">
								<div class="form-group">
								<label class="form-label">Name</label>
								<input type="text" readonly class="form-control"  value="{{ $student->name ?? '' }}">
								</div>
							</div>
							<div class="col-12">
							<div class="form-group">
								<label class="form-label">Mobile No</label>
								<input type="text" readonly class="form-control"  value="{{ $student->mobile ?? '' }}">
							</div>
							</div>
							<div class="col-12">
							<div class="form-group">
								<label class="form-label">Email</label>
								<input type="email" readonly class="form-control"  value="{{ $student->email ?? '' }}">
							</div>
							</div>
							<div class="col-12">
							<div class="form-group">
								<label class="form-label">Course</label>
								<input type="text" readonly class="form-control" value="@if($student->course == 1) UPSC   @elseif($student->course == 2) SSC   @else N/A   @endif">							</div>
							</div>
						</form>
					</div>
				</div>
				<div class="col-md-5">
					<div class="student_info">
						<form action="#">
							<div class="col-12">
								<div class="form-group">
								<label class="form-label">State</label>
								<input type="text" readonly class="form-control"  value="{{ App\Models\State::where('id', $student->state)->first()->name ?? 'N/A' }}">
								</div>
							</div>
							<div class="col-12">
							<div class="form-group">
								<label class="form-label">City</label>
								<input type="text" readonly class="form-control"  value="{{ App\Models\City::where('id', $student->city)->first()->name ?? 'N/A' }}">
							</div>
							</div>
							<div class="col-12">
							<div class="form-group">
								<label class="form-label">Block</label>
								<input type="email" readonly class="form-control"  value="{{ App\Models\Block::where('id', $student->block)->first()->name ?? 'N/A' }}">
							</div>
							</div>
							<div class="col-12">
							<div class="form-group">
								<label class="form-label">Address</label>
								<input type="email" readonly class="form-control"  value="{{ $student->address ?? 'N/A' }}">
							</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</form>
		
	</div>
	<br>
	<div class="card-header">
		<h3>All Documents</h3>
	</div>
	<div class="card-body">
		<div class="table-responsive table-card mt-3 mb-1">
			<table class="table align-middle table-nowrap ">
				<thead class="table-light">
					<tr>
						<th>S No.</th>
						<th>Marksheet Name</th>
						<th>Marksheet</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					@if(count($documents) > 0)
						@foreach($documents as $document) 
						<tr>							
							<td>{{ $loop->iteration }}</td>
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
								@if($document->marksheet == null)
								<img src="{{ asset('front/images/no-image.jpg') }}" height="50px" width="50px" >
								@else
								<a href="{{ asset($document->marksheet) }}" target="_blank">
								<img src="{{ asset('front/images/pdf.png')  }}" height="50px" width="50px" >
								</a>
								@endif
							</td>
							<td>
								@if($document->status == 1)
								Passed
								@else 
								Appeared 
								@endif
							</td>
						</tr>

						@endforeach
						@else
						<tr>
							<td colspan="4" class="text-center">Documents's Not Found</td>
						</tr>
					@endif
				                    
				</tbody>
			</table>
			<div class="d-flex justify-content-center mt-3">
				{{ $documents->links() }}
			</div>
		</div>
	</div>
</div>

@endsection
@push('js')

@endpush