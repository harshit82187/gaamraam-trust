@extends('admin.layout.app')
@section('content')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
@endpush
<div class="card">
	<div class="card-header student-enrolls-div">
		<h3>Follow Up</h3>
		<div class="student-enroll-form-div">
			<form action="{{ url()->current() }}" method="get">
				<select class="form-control select2" name="district_name">
					<option value="null" selected>--Select District--</option>
					@isset($districts)
					@foreach($districts as $district)
					<option value="{{ $district }}" {{ request('district_name') == $district ? 'selected' : '' }}>{{ $district ?? 'N/A' }}</option>
					@endforeach
					@endisset
				</select>
				<div class="enroll-form-btttn">
					<input type="text" class="" value="{{ request()->query('name', '') }}" name="name" placeholder="Search Sarpanch Name">
					<input type="date" class="" value="{{ request()->query('next_date', '') }}" name="next_date" >
					<button class="btn btn-primary">Search</button>
					<a class="btn btn-info" href="javascript:void(0)" onclick="window.location.href='{{ route(Route::currentRouteName()) }}';">Reset</a>
				</div>
			</form>
		</div>
	</div>
	<br>
	<div class="card-body">
		<div class="table-responsive table-card mt-3 mb-1">
			<table class="table align-middle table-nowrap table-hover table-striped" id="meta-table-container">
				<thead class="table-light table-dark">
					<tr>
						<th>Name</th>
						<th>Type</th>
						<th>District & Village </th>
						<th>Follow Up</th>				
					</tr>
				</thead>
				<tbody>
					@if($metas->count() > 0)
					@foreach($metas as $meta)
					<tr>
						<td>
							<div style="font-weight: bold;">
								{{ $loop->iteration }}. {{ $meta->sarpanch->name }}
									@if(\Carbon\Carbon::parse($meta->created_at)->isToday())
										<button style="background-color: #87cefa; color: #fff; border: none; border-radius: 5px; padding: 2px 8px; font-size: 10px; margin-left: 6px; cursor: pointer;">New</button>
									@endif
							</div>
							<div>{{ $meta->sarpanch->mobile_no }}</div>
							<div style="font-size: 14px;">Added Date : {{ \Carbon\Carbon::parse($meta->created_at)->format('d-M-Y h:i A') }}</div>
						</td>
						<td>
							{{ $meta->type == 1 ? 'Member' : ($meta->type == 2 ? 'Student' : 'Other') }}
							@if(in_array($meta->type, [1, 2]))
								<i class="fa fa-info-circle" data-toggle="tooltip" style="cursor: pointer;" title="Uploaded By :- {{ $meta->adminInfo->name }}"></i>
							@endif
						</td>
						<td>
							@if ($meta->sarpanch->district_name || $meta->sarpanch->village_name)
								<div><strong>{{ $meta->sarpanch->district_name }}</strong></div>
								<div>{{ $meta->sarpanch->village_name }}</div>
							@else
								<div>{{ $meta->sarpanch->address }}</div>
							@endif
						</td>
						<td>
							@php 
							$followUpCount = $meta->followUps->count();
							$lastFollowUp = $meta->followUps->sortByDesc('created_at')->first();
							$lastFollowUpDate = $lastFollowUp ? date('d-m-Y', strtotime($lastFollowUp->created_at)) : 'N/A';
							$remark = $lastFollowUp ? $lastFollowUp->remark : 'No remark available';
							$delaydays = $lastFollowUp ? now()->diffInDays($lastFollowUp->created_at) : 0;
							$delaydaysMessage = $delaydays > 0;
							$delay = $meta->followUps->where('is_delay','!=',0)->count();
						
							@endphp
							<div>
								<button class="follow-up-btn" style="background-color: #ffc107; color: #ffffff; border: none; padding: 5px 10px; border-radius: 4px; font-weight: bold;"
									data-id="{{  $meta->sarpanch->id }}" data-name="{{  $meta->sarpanch->name }}" data-type="member">Follow Up ({{ $followUpCount ?? '0' }})</button>
							</div>
							<div style="font-size: 13px; margin-top: 4px;">
								Last Follow Up: {{ $lastFollowUpDate }}
								<i class="fa fa-info-circle" style="cursor:pointer;" data-toggle="tooltip" title="{{ $remark }}"></i>
							</div>
							<div style="margin-top: 6px;">
								<span style="background-color: #f44336; color: white; padding: 2px 8px; border-radius: 4px; font-size: 13px; display: inline-block;">Delay: {{ $delay }}</span>
							</div>
							<div style="margin-top: 4px;">
								<span style="background-color: #f44336; color: white; padding: 4px 8px; border-radius: 4px; font-size: 13px; display: inline-block;">Last Followup date expired : {{ $delaydays }} days ago</span>
							</div>
						</td>
						<!-- <td>
							<div style="display: flex; align-items: center; gap: 8px;">                        
								<a href="#" title="Send via WhatsApp" style="display: inline-block;">
								<img src="{{ asset('admin/assets/img/whatsapp.png') }}" alt="WhatsApp" width="35" height="35" >
								</a>
								<a href="#" title="Send via Gmail" style="display: inline-block;">
								<img src="{{ asset('admin/assets/img/gmail.png') }}" alt="Gmail" width="35" height="35">
								</a>
							</div>
						</td> -->
					</tr>
					@endforeach
					@else
					<tr>
						<td colspan="7" class="text-danger text-center">No followup Found Yet.</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
		<div class="d-flex justify-content-center mt-4">
			{{ $metas->links('pagination::bootstrap-4') }}
		</div>
	</div>
</div>
<div class="modal fade" id="add-follow-up" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title fw-bold follow-up-modal-title"></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<!-- Left Side -->
					<div class="col-md-5 border-end pe-4">
						<form id="followUpForm">
							@csrf
							<input type="hidden" name="sarpanch_id" id="sarpanchId">                            
							<div class="mb-3" id="statusContainer">
								<label class="form-label fw-semibold">Follow-Up Status <span class="text-danger">*</span></label>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="status" id="callBackLater" value="Call Back Later">
									<label class="form-check-label" for="callBackLater">Call Back Later</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="status" id="notInterested" value="Not Interested">
									<label class="form-check-label" for="notInterested">Not Interested</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="status" id="notPickedUp" value="Not Picked Up">
									<label class="form-check-label" for="notPickedUp">Not Picked Up</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="status" id="Others" value="Other">
									<label class="form-check-label" for="Others">Other</label>
								</div>
							</div>
							@error('status')
							<div class="alert alert-danger">
								{{ $message }}
							</div>
							@enderror
							<div class="mb-3">
								<label for="followUpMessage" class="form-label fw-semibold">Remarks <span class="text-danger">*</span> <span class="text-danger">(Maximum 50 Words)</span></label>
								<textarea class="form-control" id="followUpMessage" name="remark" rows="3" maxlength="300" required></textarea>
								<small id="charCount" class="text-muted">50 characters remaining</small>
							</div>
							@error('remark')
							<div class="alert alert-danger">
								{{ $message }}
							</div>
							@enderror
							<div class="row mb-3">
								<div class="col-6">
									<label for="follow-up-date" class="form-label fw-semibold">Next Follow Up Date <span class="text-danger">*</span></label>
									<input type="date" id="follow-up-date" class="form-control" name="next_date" required>
								</div>
								@error('next_date')
								<div class="alert alert-danger">
									{{ $message }}
								</div>
								@enderror
								<div class="col-6">
									<label for="follow-up-time" class="form-label fw-semibold">Next Follow Up Time <span class="text-danger">*</span></label>
									<input type="time" id="follow-up-time" class="form-control" name="time" required>
								</div>
								@error('time')
								<div class="alert alert-danger">
									{{ $message }}
								</div>
								@enderror
							</div>
							<input type="hidden" id="collegeId">
							<input type="hidden" id="studentId">
					</div>
					<!-- Right Side -->
					<div class="col-md-7 ps-4">
					<div id="followupList" style="max-height: 440px; overflow-y: auto; font-weight: bold;"></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary" >Submit</button>
			</div>
			</form>
		</div>
	</div>
</div>
@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
<script>
	$(document).ready(function () {
	       let ts = new TomSelect('.select2', {
	           create: false,
	           sortField: {field: "text", direction: "asc"},
	           onFocus() {
	               this.removeOption("null");
	           },
	           onDelete() {
	               if (!this.items.length) {
	                   this.addOption({value: "null", text: "--Select District--"});
	                   this.setTextboxValue('');
	               }
	               return true;
	           }
	       });
	
	       $('#follow-up-date').attr('min', new Date().toISOString().split('T')[0]);
	   });
</script>
<script>
	function formatDate(dateString) {
	    var date = new Date(dateString);
	    var day = String(date.getDate()).padStart(2, '0');
	    var month = String(date.getMonth() + 1).padStart(2, '0');
	    var year = date.getFullYear();
	    return day + '-' + month + '-' + year;
	}
	
	function formatTime(time24) {
	    if (!time24) return 'N/A';
	    const [hourStr, minute] = time24.split(':');
	    let hour = parseInt(hourStr);
	    const ampm = hour >= 12 ? 'PM' : 'AM';
	    hour = hour % 12 || 12; 
	    return `${String(hour).padStart(2, '0')}:${minute} ${ampm}`;
	}
	
	
	$(document).on('click', '.follow-up-btn', function() {
	    var sarpanchId = $(this).data('id');
	    var sarpanchName = $(this).data('name');
		var type = $(this).data('type');
	    console.log("Id And Name :",sarpanchId, sarpanchName, type);
	    $('#sarpanchId').val(sarpanchId);
	    var modalTitle = "Follow Up For :  " + sarpanchName;
	    $('.follow-up-modal-title').text(modalTitle);
	    $('#studentName').text(sarpanchName);
	    $('#add-follow-up').modal('show');      
	
	
	    $('#followupList').html('Loading...!');
	    $.ajax({
	        url: 'follow-up/show/' + sarpanchId + '?type=' + type,
	        method: "GET",
	        success:function(response){
	            if(response.success){
	                console.log('Staff Users:', response.followups);
	                $("#followupList").empty();
	
	                if(response.followups && response.followups.length > 0 ){
	                    var table = '<table class="table table-striped">';
	                    table += '<thead><tr>' +
	                        '<th style="white-space:nowrap">Status</th>' +
	                        '<th style="white-space:nowrap">Remark</th>' +
	                        '<th style="white-space:nowrap">Follow Date</th>' +
	                        '<th style="white-space:nowrap">Next Follow Date & Time</th>' +
	                        '</tr></thead><tbody>';
	
	                    $.each(response.followups, function(index, followup) {
	                        var formattedDate = formatDate(followup.next_date);
	                        var formattedCreatedAt = formatDate(followup.created_at);
	
	                        var delayButton = followup.delay_in_day > 0
	                        ? '<button class="btn btn-sm btn-danger ms-2">' + followup.delay_in_day + ' Day Delay' + '</button>'
	                        : '';
	
	                        table +=
	                            '<tr>' +
	                                '<td style="white-space:nowrap">' + followup.status + ' ' + delayButton + '</td>' +
	                                '<td style="white-space:nowrap">' + followup.remark + '</td>' +
	                                '<td style="white-space:nowrap">' + (formattedCreatedAt || 'N/A') + '</td>' +
	                                '<td style="white-space:nowrap">' + (formattedDate || 'N/A') + ' ' + formatTime(followup.time) + '</td>'
	                            '</tr>';
	                    });
	
	                    table += '</tbody></table>';
	                    $('#followupList').append(table);
	                }else{
	                    $('#followupList').html('No Follow up found!');
	                }
	            }else{
	                $('#followupList').html('Error: ' + response.message);
	            }
	            $('#followUpModal').modal('show');
	        },
	        error:function(error, xhr, status){
	            console.error(error);
	            $('#followupList').html('No followup found.');            }
	    })
	});
	
	$('#followUpMessage').on('input', function() {
	    let input = $(this).val();
	    let sanitizedInput = input.toLowerCase().replace(/(^\s*|\.\s*)([a-z])/g, function(match) {
	        return match.toUpperCase();
	    });
	    $(this).val(sanitizedInput);
	    let maxLength = 50;
	    let currentLength = sanitizedInput.length;
	    if (currentLength > maxLength) {
	        $(this).val(sanitizedInput.substring(0, maxLength));
	        currentLength = maxLength;
	    }
	    $('#charCount').text((maxLength - currentLength) + ' characters remaining');
	});
	
	$(document).on('submit', '#followUpForm', function(e) {
	    e.preventDefault();
	    console.log("Form submitted");
	
	    var formData = $(this).serialize();
	    let btn = $('button[type="submit"]');
	    btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...')
	    .prop('disabled', true).css('cursor', 'not-allowed');
	
	    $.ajax({
	            url: 'follow-up/save',
	            type: 'POST',
	            data: formData,
	            headers: {
	                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            },
	            success: function(response) {
	                console.log(response);
	                $('#add-follow-up').modal('hide');
	                location.reload();
	                iziToast.info({
						title: 'Info',
						message: response.message,
						position: 'topRight',
						timeout: 3000,
					});
	            },
	            error: function(xhr, status, error) {
	                console.error(xhr.responseText);
	                $('.text-danger.ajax-error').remove();
	                if (xhr.status === 422) {
	                    let errors = xhr.responseJSON.errors;
	                    $.each(errors, function(field, messages) {
	                        if (field === 'status') {
	                            $('#statusContainer').append('<div class="text-danger ajax-error">' + messages[0] + '</div>');
	                        } else {
	                            let input = $('[name="' + field + '"]');
	                            input.after('<div class="text-danger ajax-error">' + messages[0] + '</div>');
	                        }
	                    });
	                } else {
	                    alert('An error occurred while adding the follow up.');
	                }
	            },
	            complete: function() {
	                btn.html('Submit').prop('disabled', false).css('cursor', 'pointer');
	            }
	        });
	});
	
</script>
@endpush