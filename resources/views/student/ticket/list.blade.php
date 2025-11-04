@extends('student.layout.app')
@section('content')
<div class="page-content">
	
	<div class="card">
		<div class="card-header d-block d-sm-flex justify-content-between align-items-center">
			<div class="d-block d-sm-flex gap-2 align-items-center justify-content-between">
			<img src="{{ asset('admin/assets/img/support-ticket.png') }}" width="40px" width="40px">
			<h3 class="mt-3">Tickets <span class="count-circle mt-2" >{{ count($tickets ) }}</span></h3>
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
					<a href="{{ url('student/tickets/add') }}" class="btn btn-dark mt-2 mt-sm-0">Add Ticket</a>
					<button type="button" class="btn btn-info mt-2 mt-sm-0 " onclick="window.location.href='{{ route(Route::currentRouteName()) }}';">Reset</button>
				</form>
			</div>
		</div>
		<br>
		<div class="card-body">
			<div class="table-responsive table-card mt-3 mb-1">
				<table class="table align-middle table-nowrap table-striped">
					<thead class="table-light">
						<tr>
							<th>SL</th>
							<th>Ticket No</th>
							<th>Ticket Name</th>
							<th>Submission date	</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if(count($tickets) > 0)
						@foreach($tickets as $ticket)
						<tr>
                            <td>{{ $loop->iteration  }}</td>
							<td>{{ $ticket->ticket_id ?? 'N/A' }}</td>
                            <td>{{ $ticket->subject ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($ticket->created_at)->format('d-M-Y') }} </td>
                            <td>
                                @if($ticket->status === 1)
                                    <span class="badge __badge rounded-full badge-warning">Open</span>
                                @elseif($ticket->status === 2)
                                    <span class="badge __badge rounded-full badge-danger2">Closed</span>
                                @else
                                    <span class="badge bg-secondary">Unknown</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('student.tickets.info',encrypt($ticket->id)) }}" class="btn btn-sm btn-primary">View</a>
                            </td>
                        </tr>
						@endforeach
						@else
						<tr>
							<td colspan="5" class="text-center">Ticket's Not Found</td>
						</tr>
						@endif
					</tbody>
				</table>
				<div class="d-flex justify-content-center mt-3">
					{{ $tickets->links() }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('js')




@endpush