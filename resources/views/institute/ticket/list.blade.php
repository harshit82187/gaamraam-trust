@extends('institute.layout.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">      
        <br>
        <div class="card">
            <div class="card-header" style="display: flex;justify-content: space-between;align-items: center;">
                <h3>Ticket</h3>
                <span class="count-circle" style="margin-left:6%;top:20px;" >{{ count($tickets ) }}</span>
                <div style="display: flex; gap: 10px; align-items: center;justify-content: space-between;">
                    <form action="{{ url()->current() }}" method="get" style="display: flex;gap:15px;">
                        <input type="text" class="form-control" value="{{ request()->query('name', '') }}" name="name" required placeholder="Search Ticket No">
                        <button class="btn btn-primary">Search</button>
                        <a href="{{ route('institute.tickets.add') }}" class="btn btn-dark" style="width:58%;">Add Ticket</a>
                        <button class="btn btn-info"  onclick="window.location.href='{{ route(Route::currentRouteName()) }}';">Reset</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive table-card mt-3 mb-1">
                    <table class="table align-middle table-nowrap ">
                        <thead class="table-light">
                            <tr>
                                <th>SL</th>
                                <th>Ticket No</th>
                                <th>Ticket Name	</th>
                                <th>Submission date	 </th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($tickets->count() > 0)
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
                                 <a href="{{ route('institute.tickets.info',encrypt($ticket->id)) }}" class="btn btn-sm btn-primary">View</a>
                                </td>
                            </tr>
                            @endforeach        
                            @else 
                            <tr>
                                <td colspan="7" class="text-danger text-center">No Ticket Found Yet.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>             
    </div>
</div>

@endsection
@push('js')

@endpush