@extends('student.layout.app')
@section('content')
@push('css')
<style>
    .customTicketTextarea {
    width: 1025px !important;   
    height: 187px !important;  
    resize: none !important; 
}
</style>
@endpush
<div class="page-content">	
	<div class="card">
		<div class="card-header" style="display: flex;justify-content: space-between;align-items: center;">
			<h3>Add Ticket</h3>
            <a href="{{ route('student.tickets.view') }}" class="btn btn-dark " >Back</a>  
		</div>
		<br>
		<div class="card-body">
			<div class="card-body">
                <form action="{{ route('student.tickets.add') }}" id="upload-tickets" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                       
                        <div class="col-md-12 mb-3">
                            <label>Ticket Name <span class="text-danger" >*</span></label>
                            <input type="text" name="subject" placeholder="Enter Ticket Name" required class="form-control" >
                        </div>
                         <div class="col-md-12 mb-3">
                            <label>Priority</label><span class="text-danger" >*</span>
                            <select class="form-control select" name="priority" id="" required >
                                <option selected disabled >--Select Priority--</option>
                                <option value="1" >Urgent</option>
                                <option value="2" >High</option>
                                <option value="3" >Medium</option>
                                <option value="4" >Low</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3 " id="status" style="margin-top:1%;">
                            <label>Description</label><span class="text-danger" >*</span>
                            <textarea name="description" required class="form-control customTicketTextarea" ></textarea>
                        </div>
                        <div class="col-md-12 mb-3 " style="margin-top:1%;">
                            <label>Attachment (You can upload multiple images)</label>
                            <input type="file" name="attachments[]" id="attachmentInput"  class="form-control" accept=".jpeg,.jpg,.png,.webp,image/jpeg,image/jpg,image/png,image/webp" multiple  >
                        </div>                         
                        <div class="ticket-image d-flex flex-wrap attachements"></div>
                        <div class="row m-0 p-0">
                            <div class="col-12" style="margin-top:20px;">
                                <button type="submit" class="btn btn-primary btn-sm" style="">Submit Ticket</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
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
        const preview = $('.attachements').empty();
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