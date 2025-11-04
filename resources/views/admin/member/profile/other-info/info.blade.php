@extends('admin.layout.app')
@section('content')
@push('css')
<style>
    .owner-img {
        width: 130px;
        height: 130px;
        object-fit: cover;
        border-radius: 10px;
    }
</style>
@endpush
<div class="page-content member_info">
    <div class="container-fluid">

        <!-- Tabs -->
        @include('admin.member.profile.other-info.menu-bar')

        <!-- Owner Info Card -->
        <div class="card p-4 shadow-sm mb-4">
            <div class="d-flex justify-content-between align-items-start">
                <div class="d-flex">
                    <img src="{{ asset($member->profile_image ?? 'admin/assets//img/employee.png') }}" class="owner-img rounded" alt="Member Image">
                    <div class="ms-4">
                        <h5 class="mb-1">Member Info</h5>
                        <p class="mb-2">Total Donation: <strong> {{ $donation }}</strong></p>
                        <p>Total Points: <strong> {{ $member->points }}</strong></p>
                    </div>
                    @if($employee != null)
                    <div class="ms-4">
                        <h5 class="mb-1">Reffered By :</h5>
                        <p class="mb-2">Employee Name: <strong> {{ $employee->EmployeeInfo->name ?? 'N/A' }}</strong></p>
                         <p class="mb-2">Employee Designation: <strong> {{ $employee->EmployeeInfo->role->name ?? 'N/A' }}</strong></p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Owner Details -->
        <div class="card p-4 shadow-sm mb-4">
            <h4 class="text-center my-3 fw-bold">Member Information</h4>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <td>{{ $member->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $member->email ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $member->mobile ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Blood Group</th>
                            <td>{{ $member->blood_group ?? 'N/A' }}</td>
                        </tr>

                        @if($member->country != null)
                        <tr>
                            <th>Country</th>
                            <td>{{ $member->countryInfo->name ?? 'N/A' }}</td>
                        </tr>
                        @endif
                        @if($member->passport != null)
                        <tr>
                            <th>Passport No</th>
                            <td>{{ $member->passport ?? 'N/A' }}</td>
                        </tr>
                        @endif

                        <tr>
                            <th>District</th>
                            <td>{{ $member->cityName->name  ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Block</th>
                            <td>{{ $member->blockName->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $member->address ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>{{ $member->gender ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Date Of Birth</th>
                            <td> {{ $member->dob ? \Carbon\Carbon::parse($member->dob)->format('d-M-Y') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Joined Date</th>
                            <td> {{ $member->created_at ? \Carbon\Carbon::parse($member->created_at)->format('d-M-Y') : 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>
        </div>
    </div>
</div>
@endsection


