@extends('institute.layout.app')
@section('content')
<style>
    .rating_icon .fa-star {
        font-size: 24px;
        color: #ccc;
        cursor: pointer;
        transition: color 0.2s;
    }

    .rating_icon .fa-star.active {
        color: gold;
    }

    th,
    td {
        border: 1px solid #e9e9e9;
        padding: 8px;
        text-align: left;
    }
</style>
<div class="page-content">
    <div class="container-fluid support_ticket_view">
        <div class="card">
            <div class="main-content demo support_ticket_view">
                <section class="section">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card">
                                <div class="student_ticket_header d-flex">
                                <div class="d-flex align-items-center gap-2">
                                    <a href="#"><i class="fa-solid fa-arrow-left"></i></a>
                                    <h5>Ticket Number</h5>
                                </div>
                                @if($ticket->feedback == null && $ticket->rating == null && $ticket->status == 2)
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#FeedbackFormModal">Add Feedback</button>
                                @endif
                            </div>
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <table style="width: 100%; font-family: sans-serif; font-size: 14px; border-collapse: collapse;">
                                        <tr>
                                            <td style="padding: 12px; font-weight: bold;">Status</td>
                                            <td style="padding: 12px;">
                                                <span style="background-color: #ffebeb; color: red; border: 1px solid red; padding: 4px 10px; border-radius: 4px;">
                                                    {{ $ticket->status == 1 ? 'Open' : 'Closed' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 12px; font-weight: bold;">Priority</td>
                                            <td style="padding: 12px;">
                                                @php
                                                $priorities = [
                                                1 => ['label' => 'Low', 'color' => '#007bff'],
                                                2 => ['label' => 'Medium', 'color' => '#ffc107'],
                                                3 => ['label' => 'High', 'color' => '#17a2b8'],
                                                4 => ['label' => 'Urgent', 'color' => '#dc3545'],
                                                ];
                                                $priority = $priorities[$ticket->priority] ?? ['label' => 'N/A', 'color' => '#6c757d'];
                                                @endphp
                                                <span style="background-color: {{ $priority['color'] }}1A; color: {{ $priority['color'] }}; padding: 4px 10px; border-radius: 4px;">
                                                    {{ $priority['label'] }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 12px; font-weight: bold;">Subject</td>
                                            <td style="padding: 12px;">{{ $ticket->subject }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 12px; font-weight: bold;">Description</td>
                                            <td style="padding: 12px;">{!! nl2br(e($ticket->description)) !!}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 12px; font-weight: bold;">Created At</td>
                                            <td style="padding: 12px;">{{ $ticket->created_at->format('d M Y, h:i A') }}</td>
                                        </tr>
                                        @if($ticket->status == 2)
                                        <tr>
                                            <td style="padding: 12px; font-weight: bold;">Ticket Closed Date</td>
                                            <td style="padding: 12px;">{{ $ticket->updated_at->format('d M Y, h:i A') }}</td>
                                        </tr>
                                        @endif
                                        @if(!empty($ticket->attachments))
                                        <tr>
                                            <td style="padding: 12px; font-weight: bold; vertical-align: top;">Attachments</td>
                                            <td style="padding: 12px;">
                                                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                                                    @foreach(json_decode($ticket->attachments, true) as $file)
                                                    @php $ext = pathinfo($file, PATHINFO_EXTENSION); @endphp
                                                    @if(in_array($ext, ['jpg', 'jpeg', 'png']))
                                                    <a href="{{ asset($file) }}" target="_blank" style="display: inline-block;">
                                                        <img src="{{ asset($file) }}" alt="attachment" style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px;">
                                                    </a>
                                                    @elseif($ext == 'pdf')
                                                    <a href="{{ asset($file) }}" target="_blank" style="text-decoration: none;">
                                                        <img src="https://cdn-icons-png.flaticon.com/128/337/337946.png" alt="PDF" style="width: 70px; height: 70px;">
                                                    </a>
                                                    @endif
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                    </table>

                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-body">
                                    @if($ticket->replies->count())
                                    <hr>
                                    <h5><strong>Replies:</strong></h5>
                                    @foreach($ticket->replies as $reply)
                                    <div class="ticket_chat_card d-flex mb-3 {{ $reply->type == 4 ? 'justify-content-end' : 'justify-content-start' }}">
                                        <img src="{{ $reply->image ? asset($reply->image) : ($reply->type == 4 ? ($reply->collegeDetail && $reply->collegeDetail->image ? asset($reply->collegeDetail->image) : asset('front/images/avatar-01.jpg')) 
                                                : ($reply->adminDetail && $reply->adminDetail->image ? asset($reply->adminDetail->image) : asset('admin/assets/img/employee.png'))
                                            ) }}" alt="User Image" width="35" />


                                        <div class="chat_card {{ $reply->type == 4 ? 'user' : 'admin' }}">
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
                                                <strong>{{ $reply->type == 1 ? $reply->adminDetail->name : 'You' }}</strong> | <span>{{ $reply->created_at->format('d M Y, h:i A') }}</span>
                                            </small>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif

                                    @if($ticket->status == 1)
                                    <hr>
                                    <form class="ticket_reply" id="ticket-reply" action="{{ route('institute.tickets.ticket-reply', encrypt($ticket->id)) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="reply">Your Reply <span class="text-danger">*</span></label>
                                            <textarea name="reply" class="form-control" rows="5" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Attachment (optional)</label>
                                            <input type="file" name="attachment" id="attachmentInput" class="form-control" accept=".jpeg,.jpg,.png,.webp">
                                        </div>
                                        <div class="ticket-reply-image d-flex flex-wrap "></div>
                                        <button type="submit" class="btn btn-primary mt-2">Send Reply</button>
                                    </form>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="FeedbackFormModal" tabindex="-1" aria-labelledby="FeedbackFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="FeedbackFormModalLabel">Add Feedback</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="custom_card">
                    <form action="#">
                        <ul class="rating_icon" style="list-style: none; padding: 0; display: flex; gap: 5px;">
                            <li><a href="#" class="rating_star" data-value="1"><i class="fa-solid fa-star"></i></a></li>
                            <li><a href="#" class="rating_star" data-value="2"><i class="fa-solid fa-star"></i></a></li>
                            <li><a href="#" class="rating_star" data-value="3"><i class="fa-solid fa-star"></i></a></li>
                            <li><a href="#" class="rating_star" data-value="4"><i class="fa-solid fa-star"></i></a></li>
                            <li><a href="#" class="rating_star" data-value="5"><i class="fa-solid fa-star"></i></a></li>
                        </ul>

                        <textarea class="form-control my-3" name="feedback" id="feedback" cols="30" rows="10">Write Your Feedback</textarea>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')

<script>
    document.querySelectorAll('.rating_star').forEach(star => {
        star.addEventListener('click', function(e) {
            e.preventDefault();
            const value = parseInt(this.getAttribute('data-value'));

            document.querySelectorAll('.rating_star').forEach(s => {
                const starVal = parseInt(s.getAttribute('data-value'));
                if (starVal <= value) {
                    s.querySelector('i').classList.add('active');
                } else {
                    s.querySelector('i').classList.remove('active');
                }
            });
        });
    });
</script>

<script>
    $(document).on('submit', '#ticket-reply', function() {
        let btn = $('button[type="submit"]');
        btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
    });
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