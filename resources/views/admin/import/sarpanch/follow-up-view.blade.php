@extends('admin.layout.app')
@section('content')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endpush


<div class="row">
    <div class="col-12">        
        @if(session()->get('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
                {{ session()->get('success') }}
                <button type="button" class="close fs-1 text-dark" data-dismiss="alert" aria-label="Close">
                    <span class="text-dark" aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session()->get('warning'))
            <div class="alert alert-warning alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
                {{ session()->get('warning') }}
                <button type="button" class="close fs-1 text-dark" data-dismiss="alert" aria-label="Close">
                    <span class="text-dark" aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session()->get('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
                {{ session()->get('error') }}
                <button type="button" class="close fs-1 text-dark" data-dismiss="alert" aria-label="Close">
                    <span class="text-dark" aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="font-size:larger;">{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close fs-1 text-dark" data-dismiss="alert" aria-label="Close">
                    <span class="text-dark" aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
</div>



<div class="card">
	<div class="card-header student-enrolls-div">
		<h3>{{ $sarpanch->name ?? 'N/A' }} Follow Up Listing<span class="count-circle">{{ count($followups ) }}</span></h3>
	
	</div>
</div>

<div class="card">
    <div class="card-header">
	    <form action="{{ url()->current() }}" method="GET">
            <div class="row gy-3 align-items-end card-header">
              <div class="col-md-4">
                    <label for="status" class="title-color">Follow-Up Status</label>
                    <select name="status" class="form-control select2">
                        <option value="" selected disabled>Select Follow-Up Status</option>
                        <option value="Call Back Later" {{ request('status') == 'Call Back Later' ? 'selected' : '' }}>Call Back Later</option>
                        <option value="Not Interested" {{ request('status') == 'Not Interested' ? 'selected' : '' }}>Not Interested</option>
                        <option value="Not Picked Up" {{ request('status') == 'Not Picked Up' ? 'selected' : '' }}>Not Picked Up</option>
                        <option value="Other" {{ request('status') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>            

                <div class="col-md-2">
                    <label for="status" class="title-color">From</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>

                <div class="col-md-2">
                    <label for="status" class="title-color">To</label>
                    <input type="date" name="to" class="form-control"  value="{{ request('to') }}">
                </div>

                <div class="col-md-2">                           
                    <button type="submit" class="form-control btn btn-primary" style="white-space: nowrap;">Filter</button>
                </div>

                <div class="col-md-2">
                    <button type="submit" name="export" value="1" class="form-control btn btn-dark" style="white-space: nowrap;">Export Excel</button>

                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
		<div class=" table-card mt-3 mb-1">
			<table class="table align-middle table-nowrap table-striped table-responsive table-hover ">
				<thead class="table-light table-dark">
					<tr>
						<th>SL</th>
                        <th>Following Member</th>
                        <th>Status</th>
						<th>Follow Date	</th>
                        <th>Next Follow Date & Time</th>
					</tr>
				</thead>
				<tbody>
					@if($followups->count() > 0)
					@foreach($followups as $followup)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>
                            <div style="font-weight: bold;">{{ $followup->telleCaller->name }}</div>
							<div>{{ $followup->telleCaller->mobile_no }}</div>
                        </td>
						<td>
							<div style="font-weight: bold;">{{ $followup->status }}</div>
							<div>{{ $followup->remark }}</div>
						</td>
						<td  class="white-space: pre;" style="text-wrap-mode:nowrap;">
							{{ \Carbon\Carbon::parse($followup->created_at)->format('d-M-Y h:i A') }}
						</td>
						
						<td class="white-space: pre;" style="text-wrap-mode:nowrap;">{{ \Carbon\Carbon::parse($followup->next_date)->format('d-M-Y') }}  {{ \Carbon\Carbon::parse($followup->time)->format('h:i A') }}</td>
						
					</tr>
					@endforeach
					@else
					<tr>
						<td colspan="7" class="text-danger text-center">No Follow Up Details Found Yet.</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
		<div class="d-flex justify-content-center mt-4">
			{{ $followups->links('pagination::bootstrap-4') }}
		</div>
	</div>
</div>


<div class="modal fade" id="import-sarpanch" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Import Sarpanch</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="sarpanch-import" action="{{ route('admin.sarpanch.import') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<div class="mb-3">
                        <label for="name" class="form-label">Upload Excel File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="file" accept=".xlsx" required>
                        <div class="form-text mt-3">
                            <a href="{{ asset('app/admin/import-sample/sarpanch/sarpanch-import-format.xlsx') }}" target="_blank">📥 Download Sample Excel Format</a>
                        </div>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
	$(document).ready(function() {
		$('.select2').select2({
			allowClear: true,
		});
	});
</script>
<script>
	$(document).on('submit', '#sarpanch-import', function() {
		let btn = $('button[type="submit"]');
		btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
	});
</script>
@endpush