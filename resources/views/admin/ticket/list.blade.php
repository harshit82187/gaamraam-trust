@extends('admin.layout.app')
@section('content')
@push('css')
@endpush
@php
	$lastSegment = Request::segment(3); 
    if ($lastSegment === 'student') {
        $titleName = 'Student Ticket';
    } elseif ($lastSegment === 'member') {
        $titleName = 'NGO Member';
    } elseif ($lastSegment === 'college-member') {
        $titleName = 'College Member';
    } else {
        $titleName = 'Support Tickets';
    }
@endphp


<div class="card">
	<div class="card-header d-block d-sm-flex justify-content-between align-items-center">
		<div class="d-block d-sm-flex gap-2 align-items-center justify-content-between">
		<img src="{{ asset('admin/assets/img/support-ticket.png') }}" width="40px" width="40px">
		<h3 class="mt-3">{{ $titleName ?? ''}} <span class="count-circle " @if($typeSlug == 'student') style="top:5%;" @else style="top:8%;" @endif>{{ count($tickets ) }}</span></h3>
		</div>
		<div class="d-block d-sm-flex gap-2 align-items-center justify-content-between">
			<form action="{{ url()->current() }}" method="get" class="d-block d-sm-flex gap-2">
				<input type="text" class="form-control filter-name" value="{{ request()->query('ticket_id', '') }}" name="ticket_id" placeholder="Search Ticket No">
				<select name="status"  class="form-control filter-select">
                    <option value="null" selected>All Ticket</option>
                    <option	value="1" >Open</option>
                    <option	value="2" >Closed</option>
                </select>
                <button class="btn btn-primary mt-2 mt-sm-0">Search</button>
				<button type="button" class="btn btn-info mt-2 mt-sm-0 " onclick="window.location.href='{{ route(Route::currentRouteName(), ['typeSlug' => $typeSlug]) }}';">Reset</button>
			</form>
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive table-card mt-3 mb-1">
			<table class="table align-middle table-nowrap table-striped table-hover">
				<thead class="table-light table-dark">
					<tr>
						<th>SL</th>
						<th>Ticket No</th>
						<th>Student Details</th>
                        <th>Submission Date	</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@if(isset($tickets) && $tickets->count())
					@foreach($tickets as $key => $ticket)
					<tr>
						<td>{{ $loop->iteration }}</td>
                        <td>{{ $ticket->ticket_id  ?? 'N/A' }}</td>
                        @php 
						  if($typeSlug == "student" && $ticket->student){
						  	$imageUrl = $ticket->student->image ? asset($ticket->student->image) : asset('admin/assets/img/user-1.png'); 
							$name = $ticket->student->name;
							$profileUrl = route('admin.enrool-student-info', $ticket->student->id);
						  }elseif($typeSlug == "member" && $ticket->member){
							$imageUrl = $ticket->member->image ? asset($ticket->member->image) : asset('admin/assets/img/user-1.png');
							$name = $ticket->member->name; 
							$profileUrl = "";
						  }elseif($typeSlug == "college-member" && $ticket->collegeMember){
							$imageUrl = $ticket->collegeMember->image ? asset($ticket->collegeMember->image) : asset('admin/assets/img/user-1.png');
							$name = $ticket->collegeMember->name; 
							$profileUrl = "";
						  }
						@endphp
						<td class="text-capitalize">
                            <a href="{{ $profileUrl ?? 'javascript:void(0)' }}" style="text-decoration: none; color: inherit;">
                                <div class="media align-items-center d-flex gap-3"> 
                                    <img class="rounded-circle avatar avatar-lg" alt="{{ $imageUrl }}" src="{{ $imageUrl  }}"  >
                                    <div class="media-body ">{{ $name?? 'N/A' }}</div>
                                </div>
                            </a>                            
                        </td>
						<td>{{ \Carbon\Carbon::parse($ticket->created_at)->format('d-M-Y') }} </td>
						<td>
                            @if($ticket->status == 1)
                                <span class="badge __badge rounded-full badge-info m-auto px-3">Open</span>
                                @else 
                                <span class="badge __badge rounded-full badge-danger m-auto px-3">Closed</span>
                            @endif
						</td>
						<td>
							<a href="{{ route('admin.tickets.info',encrypt($ticket->id)) }}" class="btn btn-dark btn-sm" >View</a>
						</td>
					</tr>
					@endforeach
					@else 
					<tr>
						<td colspan="6" class="text-danger text-center" >No Ticket Found!</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
		<div class="d-flex justify-content-center mt-4">
			{{ $tickets->links('pagination::bootstrap-4') }}
		</div>
	</div>
</div>
@endsection
@push('js')



@endpush