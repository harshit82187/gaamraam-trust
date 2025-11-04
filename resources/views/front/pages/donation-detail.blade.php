@extends('front.layout.app')
@section('content')
<h1 class="text-center p-3">Donation Details!</h1>
<div class="container">
    <div class="table-responsive">
        <table class="table table-striped member_donation_table">
            <thead class="thead-dark">
                <tr>                   
                    <th>Member Name</th>
                    {{-- <th>Member ID</th> --}}
                    <th>Donation Amount</th>
                </tr>
            </thead>
            <tbody>
				<tr>
					<td>Details will be updated shortly, Amount to be revealed soon</td>
					<td>₹101317</td>
				</tr>
                @forelse($donations as $index => $donation)
                    <tr>
                        <td>
                            <img src="{{ $donation->member && $donation->member->profile_image ? asset($donation->member->profile_image) : asset('front/images/user.png') }}" alt="member_profile">
                            {{ $donation->user_name ?? 'N/A' }}
                        </td>
                        {{-- <td>{{ $donation->user_id ?? 'N/A' }}</td> --}}
						<td>
							@if($donation->currency == 'INR')
								₹{{ number_format($donation->amount) }}
							@elseif($donation->currency == 'USD')
								${{ number_format($donation->amount) }}
							@else
								{{ number_format($donation->amount) }} 
							@endif
						</td>
						
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No donation records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-3">
            {{ $donations->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>



@endsection