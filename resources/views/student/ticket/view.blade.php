@extends('student.layout.app')
@section('content')
@push('css')
<style>
.student_ticket_header {
    justify-content: space-between;
    padding: 20px 30px 0;
}
.student_ticket_header h5 {
    font-size: 20px;
    color: #111;
    font-weight: 600;
}
.student_ticket_header a {
    font-size: 22px;
    color: #111;
}
 .rating_icon .fa-star {
    font-size: 24px;
    color: #ccc;
    cursor: pointer;
    transition: color 0.2s;
  }
  .rating_icon .fa-star.active {
    color: gold;
  }
</style>
@endpush
<div class="page-content support_ticket_view">
    <div class="card">
        <div class="main-content demo support_ticket_view m-0">
            <section class="">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="student_ticket_header d-flex">
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ url('student/tickets') }}"><i class="fa-solid fa-arrow-left"></i></a>
                                    <h5>Ticket Number</h5>
                                </div>
                                @if($ticket->feedback == null && $ticket->rating == null && $ticket->status == 2)
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#FeedbackFormModal">Add Feedback</button>
                                @endif
                            </div> 
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                <span class="badge {{ $ticket->status == 1 ? 'badge-soft-success' : 'badge-soft-danger' }}">
                                                    {{ $ticket->status == 1 ? 'Open' : 'Closed' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Priority</th>
                                            <td>
                                                @php
                                                $priorities = [
                                                1 => ['label' => 'Low', 'class' => 'badge-soft-primary'],
                                                2 => ['label' => 'Medium', 'class' => 'badge-soft-warning'],
                                                3 => ['label' => 'High', 'class' => 'badge-soft-info'],
                                                4 => ['label' => 'Urgent', 'class' => 'badge-soft-danger']
                                                ];
                                                @endphp
                                                <span class="badge {{ $priorities[$ticket->priority]['class'] ?? 'badge-soft-secondary' }}">
                                                    {{ $priorities[$ticket->priority]['label'] ?? 'N/A' }}
                                                </span>
                                            </td>
                                        </tr>
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
                                            <th>Created At</th>
                                            <td>{{ $ticket->created_at->format('d M Y, h:i A') }}</td>
                                        </tr>
                                        @if($ticket->status == 2)
                                        <tr>
                                            <th>Ticket Closed Date</th>
                                            <td>{{ $ticket->updated_at->format('d M Y, h:i A') }}</td>
                                        </tr>
                                        @endif
                                        @if($ticket->feedback != null && $ticket->rating != null)
                                        <tr>
                                            <th>Your Feedback</th>
                                            <td>@for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $ticket->rating)
                                                        <i class="fa-solid fa-star text-warning"></i>
                                                    @else
                                                        <i class="fa-regular fa-star text-secondary"></i>
                                                    @endif
                                                @endfor
                                                {{ $ticket->feedback }}
                                            </td>
                                        </tr>
                                        @endif
                                        @if (!empty($ticket->attachments) && count(json_decode($ticket->attachments, true)) > 0)
                                            <tr>
                                                <th>Attachments</th>
                                                <td>
                                                    <div class="ticket-attachment d-flex flex-wrap gap-2">
                                                        @foreach(json_decode($ticket->attachments, true) as $file)
                                                            @php $extension = pathinfo($file, PATHINFO_EXTENSION); @endphp
                                                            @if(in_array($extension, ['jpg', 'jpeg', 'png', 'webp']))
                                                                <a href="{{ asset($file) }}" target="_blank">
                                                                    <img src="{{ asset($file) }}" alt="attachment"
                                                                        style="width: 80px; height: auto; border: 1px solid #ccc; border-radius: 4px;">
                                                                </a>
                                                            @elseif($extension === 'pdf')
                                                                <a href="{{ asset($file) }}" target="_blank" class="btn btn-sm btn-outline-dark">
                                                                    View PDF
                                                                </a>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <th>Attachments</th>
                                                <td>No Attachment Found!</td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>

                            <div class="card mt-3">
                                <div class="card-body">
                                    @if($ticket->replies->count())
                                    <hr>
                                    <h5><strong>Replies:</strong></h5>
                                    @foreach($ticket->replies as $reply)
                                    <div class="ticket_chat_card d-flex mb-3 {{ $reply->type == 2 ? 'justify-content-end' : 'justify-content-start' }}">
                                        <img src="{{ $reply->image ? asset($reply->image) : ($reply->type == 2 ? ($reply->studentDetail && $reply->studentDetail->image ? asset($reply->studentDetail->image) : asset('student/backend/images/users/avatar-1.jpg')) 
                                                : ($reply->adminDetail && $reply->adminDetail->image ? asset($reply->adminDetail->image) : asset('admin/assets/img/employee.png'))
                                            ) }}" alt="User Image" width="35" />


                                        <div class="chat_card {{ $reply->type == 2 ? 'user' : 'admin' }}">
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
                                    <form class="ticket_reply" id="ticket-reply" action="{{ route('student.tickets.ticket-reply', encrypt($ticket->id)) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="reply">Your Reply</label>
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
          <form id="tickets-feedback" action="{{ route('student.tickets.feedback') }}" method="post">
             @csrf
            <input type="hidden" name="id" value="{{ encrypt($ticket->id) }}" >  
            <input type="hidden" name="rating" id="rating">          
            <ul class="rating_icon" style="list-style: none; padding: 0; display: flex; gap: 5px;">
                @for ($i = 1; $i <= 5; $i++)
                    <li>
                        <a href="#" class="rating_star" data-value="{{ $i }}">
                            <i class="fa-solid fa-star"></i>
                        </a>
                    </li>
                @endfor
            </ul>

            <textarea class="form-control my-3" name="feedback" id="feedback" cols="30" rows="10" placeholder="Write Your Feedback"></textarea>
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
  document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('.rating_star');
    const ratingInput = document.getElementById('rating');

    stars.forEach((star, index) => {
      star.addEventListener('click', function (e) {
        e.preventDefault();
        const value = this.getAttribute('data-value');
        ratingInput.value = value;

        // Clear all stars
        stars.forEach(s => s.querySelector('i').classList.remove('text-warning'));

        // Highlight selected stars
        for (let i = 0; i < value; i++) {
          stars[i].querySelector('i').classList.add('text-warning');
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
    $(document).on('submit', '#tickets-feedback', function() {
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