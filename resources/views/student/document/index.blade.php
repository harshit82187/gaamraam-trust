@extends('student.layout.app')
@section('content')
<div class="page-content">

	@if($documents->total() < 3)
    <div class="row">
        <div class="col-12">
            <marquee behavior="scroll" direction="left" style="color: red; font-weight: bold; font-size: 16px;">
                ⚠️ Please Upload Your 10th,12th,Graduation,Character And Domicile Document!
            </marquee>
        </div>
    </div>
    @endif
	<div class="card">
		<div class="card-body">
			<form action="{{ route('student.document-upload') }}" id="upload-document" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="row">
					<div class="col-md-6 mb-3">
						<label>Document Name</label><span class="text-danger" >*</span>
						<select class="form-control select" name="name" id="document-name" required >
							<option selected disabled >--Select Marksheet Name--</option>
							<option value="1" >10th Marksheet</option>
							<option value="2" >12th Marksheet</option>
							<option value="3" >Graduation 1 Year Marksheet</option>
							<option value="4" >Graduation 2 Year Marksheet</option>
							<option value="5" >Graduation 3 Year Marksheet</option>
							<option value="6" >Character Certificate</option>
							<option value="7" >Domicile Certificate</option>
						</select>
					</div>
					<div class="col-md-6 mb-3">
						<label>Upload Document (Document Should Be in PDF Format) <span class="text-danger" >*</span></label>
						<input type="file" name="marksheet" accept=".pdf" required class="form-control" >
					</div>
					<div class="col-md-6 mb-3 d-none" id="status" style="margin-top:1%;">
						<label>Status</label><span class="text-danger" >*</span>
						<select class="form-control select" name="status" required >
							<option selected disabled >--Select Status--</option>
							<option value="1" >Passed</option>
							<option value="2" >Appeared</option>
						</select>
					</div>
					<div class="row m-0 p-0">
						<div class="col-12" style="margin-top:20px;">
							<button type="submit" class="btn btn-primary" style="">Submit</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="card">
		<div class="card-header" style="display: flex;justify-content: space-between;align-items: center;">
			<h3>Documents<span class="count-circle" style="top:12px;">{{ count($documents) ?? '0' }}</span></h3>

		</div>
		<br>
		<div class="card-body">
			<div class="table-responsive table-card mt-3 mb-1">
				<table class="table align-middle table-nowrap table-striped">
					<thead class="table-light">
						<tr>
							<th>S No.</th>
							<th>Image</th>
							<th>Name</th>
							<th>Status </th>
							<th>Approved </th>
						</tr>
					</thead>
					<tbody>
						@if(count($documents) > 0)
						@foreach($documents as $document)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>
								@if($document->marksheet == null)
								<img src="{{ asset('front/images/no-image.jpg') }}" height="50px" width="50px" >
								@else
								<a href="{{ asset($document->marksheet) }}" target="_blank">
								<img src="{{asset('front/images/pdf.png') }}" height="50px" width="50px" >
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
							@if($document->approved == 0)
                            <span class="badge bg-warning">Pending</span>
                        @elseif($document->approved == 1)
                            <span class="badge bg-danger">Re-upload</span>
                        @elseif($document->approved == 2)
                            <span class="badge bg-success">Approved</span>
                        @endif
                    </td>
						</tr>
						@endforeach
						@else
						<tr>
							<td colspan="5" class="text-center">Document's Not Found</td>
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
</div>
@endsection
@push('js')
<script>
	$('#document-name').on('change',function(){
		var id = $(this).val();
		console.log(id);
		if(id == 2 || id == 3 || id == 4 || id == 5){
			$('#status').removeClass('d-none');
		}else{
			$('#status').addClass('d-none');
		}
	});
</script>
<script>
	$(document).on('submit', '#upload-document', function() {
        let btn = $('#upload-document button[type="submit"]');
        btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...')
           .prop('disabled', true);
    });
</script>

<script>
    $(document).ready(function() {

        $('.approved-switch').on('change', function() {
            var documentId = $(this).data('id');
            var approved = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: 'document-approved/' + documentId,
                type: 'POST',
                data: {
                    approved: approved,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {

                },
                error: function(xhr) {
                    alert('Error updating status.');
                }
            });
        });
    });
</script>
@endpush