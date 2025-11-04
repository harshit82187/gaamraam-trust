@extends('admin.layout.app')
@section('content')
<div class="page-content member_info">
    <div class="container-fluid">
        @include('admin.member.profile.other-info.menu-bar')
        <div class="card">
            <div class="card-header">
                <div style="display: flex; align-items: center; justify-content: space-between; cursor: pointer;width: 100%;"> 
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <img src="{{ asset('admin/assets/img/refer.png') }}" height="50px" width="50px" alt="Refer Info">
                        <h1>Referral Info</h1>
                    </div>
                    <h1>Member Name : {{ $member->name }}</h1>
                </div>
            </div>
        </div>

        <div class="card">
            
            <div class="card-body">
                <div class="table-responsive table-card mt-3 mb-1">
                    <table class="table align-middle table-nowrap table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>SL</th>
                                <th>Referral Name</th>                               
                                <th class="text-center">Type</th>
                                <th class="text-center">Point</th>
                                <th>Referral Date	</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($referrals as $referral)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        @switch($referral->type)
                                            @case('2')                                           
                                                <a href="{{ route('admin.enrool-student-info', $referral->referredStudent->id ?? 0) }}"
                                                style="text-decoration: none; color: black;">
                                                    {{ $referral->referredStudent->name ?? 'N/A' }}
                                                </a>
                                                @break

                                            @case('1')
                                            @case('4')
                                                <a href="javascript:void(0)" style="text-decoration: none; color: black;cursor:none;">
                                                    {{ $referral->referrer->name ?? 'N/A' }}
                                                </a>
                                                @break
                                           
                                        @endswitch
                                    </td>

                                    <td class="text-center">
                                        @switch($referral->type)
                                            @case('2')
                                                Student Registered via Member Panel
                                                @break

                                            @case('1')
                                                Registered Himself
                                                @break

                                            @case('4')
                                                Donation From His Panel
                                                @break
                                        @endswitch
                                    </td>

                                    <td class="text-center">{{ $referral->points ?? 0 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($referral->created_at)->format('d-M-Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-danger">Referrals Not Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $referrals->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
        
      
    </div>
</div>
@endsection


