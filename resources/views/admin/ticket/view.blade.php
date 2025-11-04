@extends('admin.layout.app')
@section('content')
@push('css')

@endpush
<div class="support_ticket_view">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header" style="display: flex;justify-content: space-between;align-items: center;">
                    <h4>Status: 
                        <span class="badge {{ $ticket->status == 1 ? 'badge-soft-success' : 'badge-soft-danger' }} fs-6">
                        {{ $ticket->status == 1 ? 'Open' : 'Closed' }}
                        </span>
                    </h4>
                    <h4>Priority: 
                        @php
                        $priorities = [
                        1 => ['label' => 'Low', 'class' => 'badge-soft-primary'],
                        2 => ['label' => 'Medium', 'class' => 'badge-soft-warning'],
                        3 => ['label' => 'High', 'class' => 'badge-soft-info'],
                        4 => ['label' => 'Urgent', 'class' => 'badge-soft-danger']
                        ];
                        @endphp
                        <span class="badge {{ $priorities[$ticket->priority]['class'] ?? 'badge-soft-secondary' }} fs-6">
                        {{ $priorities[$ticket->priority]['label'] ?? 'N/A' }}
                        </span>
                    </h4>
                    @if($ticket->status == 1)
                    <button onclick="markClosed('{{ encrypt($ticket->id) }}')" class="btn btn-danger btn-sm">Mark As Closed</button>
                    @endif
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                             <tr>
                                <th>Ticket No</th>
                                <td>{{ $ticket->ticket_id }}</td>
                            </tr>
                            <tr>
                                <th>Subject</th>
                                <td>{{ $ticket->subject }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{!! nl2br(e($ticket->description)) !!}</td>
                            </tr>
                            <tr>
                                <th>Ticket Onboard Date</th>
                                <td>{{ $ticket->created_at->format('d M Y, h:i A') }}</td>
                            </tr>
                            @if($ticket->status == 2)
                            <tr>
                                <th>Ticket Closed Date</th>
                                <td>{{ $ticket->updated_at->format('d M Y, h:i A') }}</td>
                            </tr>
                            @endif
                            @if($ticket->rating != null && $ticket->feedback != null)
                            <tr>
                                <th>Feedback</th>
                                <td>
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $ticket->rating)
                                            <i class="fa-solid fa-star text-warning"></i>
                                        @else
                                            <i class="fa-regular fa-star text-secondary"></i>
                                        @endif
                                    @endfor
                                 <br>{{ $ticket->feedback }} </td>
                            </tr>
                            @endif
                            @if($ticket->replies->count())
                            <tr>
                                <th>Chat</th>
                                <td>
                                    <a href="{{ route('admin.tickets.chat-export',encrypt($ticket->id)) }}" class="btn btn-dark btn-sm">Export Chat</a>
                                </td>
                            </tr>
                            @endif
                            @if(!empty($ticket->attachments))
                            <tr>
                                <th>Attachments</th>
                                <td>
                                    <div class="ticket-attachment d-flex flex-wrap gap-2">
                                        @foreach(json_decode($ticket->attachments, true) as $file)
                                            @php
                                                $extension = pathinfo($file, PATHINFO_EXTENSION);
                                            @endphp
                                            @if(in_array($extension, ['jpg', 'jpeg', 'png']))
                                                <a href="{{ asset($file) }}" target="_blank">
                                                    <img src="{{ asset($file) }}" alt="attachment" style="max-width: 100px; max-height: 100px;">
                                                </a>
                                            @elseif($extension == 'pdf')
                                                <a href="{{ asset($file) }}" target="_blank" class="btn btn-sm btn-outline-dark">
                                                    View PDF
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card">
                <div class="card-body">
                    @if($ticket->replies->count())
                    <hr>
                    <h5><strong>Replies:</strong></h5>
                    @foreach($ticket->replies as $reply)
                    <div class="ticket_chat_card  d-flex mb-3 @if($reply->type == 2 || $reply->type == 4) justify-content-start @elseif($reply->type == 3) @else justify-content-end @endif">
                        @php
                        $image = asset('front/img/avatar/avatar-01.jpg');
                        if ($reply->image) {
                        $image = asset($reply->image);
                        } elseif ($reply->type == 2 && $reply->studentDetail && $reply->studentDetail->image) {
                        $image = asset($reply->studentDetail->image);
                        } elseif ($reply->type == 1 && $reply->adminDetail && $reply->adminDetail->image) {
                        $image = asset($reply->adminDetail->image);
                        } elseif ($reply->type == 3 && $reply->memberDetail && $reply->memberDetail->image) {
                        $image = asset($reply->memberDetail->image);
                        }
                        @endphp
                        <img src="{{ $image }}" alt="User Image" width="35" />
                        <div class="chat_card @if($reply->type == 1) admin @elseif($reply->type == 2) owner @elseif($reply->type == 3) user @elseif($reply->type == 4) user @endif">
                            <div class="arrow">
                                <div class="outer"></div>
                                <div class="inner"></div>
                            </div>
                            <p class="mb-1">{{ $reply->reply }}</p>
                            @if($reply->attachment)
                            <p class="mb-1">
                                <a href="{{ asset($reply->attachment) }}" target="_blank">📎 View Attachment</a>
                            </p>
                            @endif
                            <small class="text-muted chat_time">
                            <strong>
                            @if($reply->type == 1)
                            {{ $reply->adminDetail->name}}
                            @elseif($reply->type == 2)
                           {{ $reply->studentDetail->name}}
                            @elseif($reply->type == 3)
                            {{ $reply->memberDetail->name}}
                            @elseif($reply->type == 4)
                            {{ $reply->collegeDetail->name}}
                            @endif
                            </strong> | <span>{{ $reply->created_at->format('d M Y, h:i A') }}</span>
                            </small>
                        </div>
                    </div>
                    @endforeach
                    @endif
                    @if($ticket->status == 1) {{-- Only allow reply if ticket is open --}}
                    <hr>
                    <form class="ticket_reply" id="ticket-reply" action="{{ route('admin.tickets.reply', encrypt($ticket->id)) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="reply">Your Reply</label>
                            <textarea name="reply" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Attachment (optional)</label>
                            <input type="file" name="attachment" id="attachmentInput" accept=".jpeg,.jpg,.png,.webp" class="form-control">
                        </div>
                        <div class="ticket-reply-image d-flex flex-wrap "></div>
                        <button type="submit" class="btn btn-primary">Send Reply</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')

<script>
    $(document).on('submit', '#ticket-reply', function() {
	    let btn = $('button[type="submit"]');
	    btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
	});
	function markClosed(encryptedId) {
	    Swal.fire({
	        title: 'Are you sure?',
	        text: '',
	        icon: 'warning',
	        showCancelButton: true,
	        confirmButtonColor: '#d33',
	        cancelButtonColor: '#3085d6',
	        confirmButtonText: 'Close This Ticket',
	        customClass: {
	            popup: 'swal2-large',
	            content: 'swal2-large'
	        }
	    }).then((result) => {
	        if (result.isConfirmed) {
	            window.location.href = "{{ route('admin.tickets.closed', ':id') }}".replace(':id', encryptedId);
	        }
	    });
	}
    $('#attachmentInput').on('change', function(e) {
        const preview = $('.ticket-reply-image').empty();
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