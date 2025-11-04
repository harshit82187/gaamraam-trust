@extends('front.layout.app')
@section('content')
<section class="page-title-section bg-img cover-background top-position1 left-overlay-dark" data-overlay-dark="9" data-background="{{asset('front/img/bg/bg-04.jpg')}}">
	<div class="container">
		<div class="row text-center">
			<div class="col-md-12">
				<h1>Donate Amount Details</h1>
			</div>
			<div class="col-md-12">
				<ul>
					<li><a href="{{ url('/') }}">Home</a></li>
					<li><a href="{{ url()->current() }}">Donate Amount Details</a></li>
				</ul>
			</div>
		</div>
	</div>
</section>



<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>S No</th>
                    <th>Doner Name</th>
                    <th>Doner Amount</th>
                    <th>Transaction ID</th>
                    <th>Donate Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($details as $detail)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $detail->user_name ?? 'Doner' }}</td>
                    <td>{{ $detail->amount ?? 'Doner' }}</td>
                    <td>{{ $detail->r_payment_id ?? 'Doner' }}</td>
                    <td>{{ \Carbon\Carbon::parse($detail->booking_date)->format('d-M-Y') }} </td>
                </tr>
                @endforeach						
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-3">
            {{ $details->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection