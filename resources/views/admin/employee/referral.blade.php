@extends('admin.layout.app')
@section('content')
@push('css')
<link rel="stylesheet" href="{{ asset('admin/assets/css/card.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}" />
<style>
	.no-radius-form input,
	.no-radius-form button,
	.no-radius-form .btn {
	border-radius: 0px !important;
	}
	
</style>
@endpush
<div class="card" style="padding: 0px !important;">
	<div class="card-header" style="display: flex; gap: 10px; align-items: center;">
		<img src="{{ asset('admin/assets/img/employee.png') }}" width="40px" width="40px">
		<h3 class="">View Employee Details</h3>
	</div>
</div>
<div class="card p-4 mt-2">
	<div class="row">
		<div class="col-md-6">
			<div class="employee_detail">
				<div class="employee_profile">
					@if($admin->image)
					<img src="{{ asset($admin->image) }}" class="sub-admin" alt="{{ asset($admin->image) }}">
					@else 
					<img src="https://cdn-icons-png.flaticon.com/128/2202/2202112.png" alt="https://cdn-icons-png.flaticon.com/128/2202/2202112.png">
					@endif
					<div class="employee_content">
						<h5>{{ $admin->name ?? 'N/A' }}</h5>
						<span>{{ $admin->role->name ?? 'N/A' }}</span>
						<div class="icon_with_text">
							<div class="icon_with_text-item">
								<i class="fa-solid fa-phone"></i>
								<span>{{ $admin->mobile_no ?? 'N/A' }}</span>
							</div>
							<div class="icon_with_text-item">
								<i class="fa-solid fa-envelope"></i>
								<span>{{ $admin->email ?? 'N/A' }}</span>
							</div>
							<div class="icon_with_text-item">
								<i class="fa-solid fa-credit-card"></i>
								<span>{{ $admin->identify_number ?? 'N/A' }}</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="employee_card">
				<div class="card">
					<i class="fa-solid fa-calendar-days"></i>
					<span><strong>JOIN:</strong>{{ \Carbon\Carbon::parse($admin->created_at)->format('d-M-Y h:i A') }}</span>
				</div>
				<div class="card flex-column">
					<div class="d-flex gap-3">
						<i class="fa-solid fa-address-card"></i>
						<span><strong></strong>Access Available</span>
					</div>
					<ul class="availibility_list">
						@isset($roles)
						@foreach($roles as $role)
						<li>{{ ucwords(str_replace('_', ' ', $role)) }}</li>
						@endforeach 
						@endisset
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@if($admin->admin_role_id  == 8)
<div class="member_info">
	@include('admin.employee.menu')
</div>
<div class="card">
	<div class="card-header d-block d-sm-flex justify-content-between align-items-center">
		<div class="d-flex gap-2 align-items-center">
			<div style="display: flex; align-items: center; gap: 10px;">
				<img src="{{ asset('admin/assets/img/refer.png') }}" height="50px" width="50px" alt="Refer Info">
				<h1>Referral Info</h1>
				<span class="count-circle " style="position:unset;">{{ count($referrals) }}</span>
			</div>
		</div>
		<div class="d-flex align-items-center  gap-3">
			<form action="{{ url()->current() }}" method="get" class="no-radius-form gap-2 d-block d-sm-flex ">
				<input type="date" name="start_date" class="form-control w-100" value="{{ request('start_date') }}" style="cursor:pointer;" title="Start Date">
				<input type="date" name="end_date" class="form-control w-100" value="{{ request('end_date') }}" style="cursor:pointer;" title="End Date">
				<button class="btn btn-primary mt-2 mt-sm-0">Search</button>
				<!-- <button type="submit" class="btn btn-dark mt-2 mt-sm-0"  name="export" value="1" >Export</button> -->
				<a class="btn btn-info mt-2 mt-sm-0" href="{{ route(Route::currentRouteName(), ['id' => encrypt($admin->id)]) }}">Reset</a>
			</form>
		</div>
	</div>
	<br>
	<div class="card-body">
		<div class="table-responsive table-card mt-3 mb-1">
			<table class="table align-middle table-nowrap table-striped table-hover">
				<thead class="table-light table-dark">
					<tr class="text-center table-striped table-responsive table-border">
						<th>Referral Name</th>
						<th>Type</th>
						<th class="text-nowrap">Point</th>
						<th class="text-nowrap">Referral Date</th>
					</tr>
				</thead>
				<tbody>
					@if($referrals->count() > 0)
					@foreach($referrals as $referral)	
					<tr>
						<td class="text-center">
							@switch($referral->type)
							@case('3')
								<a href="{{ route('admin.member.member-info', encrypt($referral->referred->id)) }}" target="_blank" title="View Member Information"
									style="text-decoration: none; color: black;" class="hover-link">
								{{ $referral->referred->name }}
								</a>
							@break
							@case('6')
								<a href="{{ route('admin.enrool-student-info', $referral->referredStudent->id ?? 0) }}" target="_blank" title="View Student Information"
									style="text-decoration: none; color: black;" class="hover-link">
								{{ $referral->referredStudent->name ?? 'N/A' }}
								</a>
							@break
							@case('7')
								<a href="javascript::void(0)" target="_blank" title=""
									style="text-decoration: none; color: black;" class="hover-link">
								Students
								</a>
							@break
							@endswitch
						</td>
						<td class="text-center">
							@switch($referral->type)
							@case('3')
								New Member Add
								@break 
							@case('6')
								New Student Add
								@break  
							@case('7')
								Upload Student Excel Sheet 
								@break                                   
							@endswitch
						</td>
						<td class="text-center">{{ $referral->points ?? 0 }}</td>
						<td class="text-center">{{ \Carbon\Carbon::parse($referral->created_at)->format('d-M-Y') }}</td>
					</tr>
					@endforeach
					@else
					<tr>
						<td colspan="4" class="text-center text-danger">Referrals Not Found</td>
					</tr>
					@endif
				</tbody>
			</table>
			<div class="d-flex justify-content-center mt-4">
				{{ $referrals->links('pagination::bootstrap-4') }}
			</div>
		</div>
	</div>
</div>
@endif
@endsection
@push('js')
@endpush