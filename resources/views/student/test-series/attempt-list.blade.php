@extends('student.layout.app')
@section('content')
<div class="page-content">
	<div class="card">
		<div class="card-header" style="display: flex;justify-content: space-between;align-items: center;">
			<h3>Attempt Series List<span class="count-circle" style="top:12px;">{{ count($testSeries) ?? '0' }}</span></h3>
			
		</div>
		<br>
		<div class="card-body">
			<div class="table-responsive table-card mt-3 mb-1">
				<table class="table align-middle table-nowrap table-striped">
					<thead class="table-light">
						<tr>
							<th>S No.</th>
							<th>Test Series Name</th>
							<th>Status</th>
							<th>Action </th>
						</tr>
					</thead>
					<tbody>
						@if(count($testSeries) > 0)
							@foreach($testSeries as $testSerie) 
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $testSerie->name ?? 'N/A'  }} </td>								
								<td> 
								</td>
								<td>
									<a href="{{ route('student.test-result-download-pdf', $testSerie->id) }}" class="btn btn-dark btn-sm" >Result</a>
								</td>
							</tr>
							@endforeach  
						@else
						<tr>
							<td colspan="5" class="text-center">Attempt Test Serie's Not Found</td>
						</tr>
						@endif                   
					</tbody>
				</table>
				<div class="d-flex justify-content-center mt-3">
					{{ $testSeries->links() }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('js')

@endpush