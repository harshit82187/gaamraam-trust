@extends('institute.layout.app')
@section('content')
<style>
    .customTicketTextarea {
    width: 1378px !important;   
    height: 187px !important;  
    resize: none !important; 
}
</style>
<div class="page-content">
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="page-title-box d-sm-flex align-items-center justify-content-between">
				<h4 class="mb-sm-0">Add Ticket</h4>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-body">
			<form method="POST" id="upload-tickets" action="{{ route('institute.tickets.add')  }}" enctype="multipart/form-data" >
				@csrf
				<div class="row">
					
					<div class="col-md-6" style="margin-top: 18px;" >
						<label>Ticket Name <span class="text-danger">* </span></label>
						<input type="text" class="form-control" placeholder="Enter Ticket Name" required name="subject" >
						@error('name')
						<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="col-md-6" style="margin-top: 18px;" >
						<label>Priority <span class="text-danger">* </span></label>
						<select class="form-control select" name="priority" id="" required >
                            <option selected disabled >--Select Priority--</option>
                            <option value="1" >Urgent</option>
                            <option value="2" >High</option>
                            <option value="3" >Medium</option>
                            <option value="4" >Low</option>
                        </select>
						@error('priority')
						<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="col-md-12" style="margin-top: 18px;" >
						<label>Description  <span class="text-danger">* </span></label>
						 <textarea name="description" required class="form-control customTicketTextarea" ></textarea>
						@error('description')
						<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					
					
					<div class="col-md-12" style="margin-top: 18px;" >
						<label>Attachment (You can upload multiple images) </label>
                        <input type="file" name="attachments[]" id="attachmentInput"  class="form-control" accept=".jpeg,.jpg,.png,.webp,image/jpeg,image/jpg,image/png,image/webp" multiple  >
						@error('attachments')
						<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
                     <div class="ticket-image d-flex flex-wrap mt-2"></div>
					<div class="col-md-2" style="margin-top: 18px;" >
						<button type="submit" class="btn btn-primary">Submit Ticket</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	
</div>
@endsection
@push('js')
<script>
	$(document).on('submit', '#upload-tickets', function() {
        let btn = $('button[type="submit"]');
        btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...')
           .prop('disabled', true);
    });
    $('#attachmentInput').on('change', function(e) {
        const preview = $('.ticket-image').empty();
        [...e.target.files].forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = e => {
                const isImage = file.type.startsWith('image/');
                const html = `
                    <div class="file-preview position-relative d-inline-block m-1">
                        ${isImage ?
                            `<img src="${e.target.result}" class="img-thumbnail" style="width:100px;height:100px;">` :
                            `<div class="border p-2" style="width:100px;height:100px;overflow:hidden;">${file.name}</div>`
                        }
                        <button class="remove-btn btn btn-danger btn-sm position-absolute d-flex justify-content-start align-items-center" style="top:0;right:0;height:34% !important; width: 34px;">&times;</button>
                    </div>`;
                preview.append(html);
            };
            reader.readAsDataURL(file);
        });
    });
    $(document).on('click', '.remove-btn', function() {
        const confirmed = confirm('Are you sure you want to remove this file?');
        if (confirmed) {
            $(this).closest('.file-preview').remove();
        }
    });
</script>
@endpush