@extends('admin.layout.app')
@section('content')
@push('css')
<style>
   .verified-badge {
   display: inline-block;
   background-color: #28a745;
   color: #fff;
   font-size: 12px;
   font-weight: bold;
   padding: 10px 20px;
   border-radius: 30px;
   box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
   text-align: center;
   text-transform: uppercase;
   }
</style>
@endpush
<div class="page-content member_info">
   <div class="container-fluid">
      @include('admin.member.profile.other-info.menu-bar')
      <div class="card">
         <div class="card-header" style="padding:0px !important;">
            <div style="display: flex; align-items: center; justify-content: space-between; cursor: pointer;width: 100%;">
               <div style="display: flex; align-items: center; gap: 10px;">
                  <img src="{{ asset('admin/assets/img/zakat.png') }}" style="width: 30px;" alt="{{ asset('admin/assets/img/zakat.png') }}">
                  <h1>Donation Info</h1>
               </div>
               <h1>Member Name : {{ $member->name }}</h1>
            </div>
         </div>
      </div>
      <div class="card">
         <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
            {{-- Left Side: Member Tabs --}}
            <div class="mail-menu" style="display: flex; gap: 20px;">
               <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                  <img src="{{ asset('admin/assets/img/payment-method.png') }}">
                  <a href="{{ route('admin.member.member-donation-online', encrypt($member->id)) }}" 
                     style="color: {{ Request::routeIs('admin.member.member-donation-online', encrypt($member->id)) ? 'gray' : '#d56337' }};
                     text-decoration: none;
                     font-weight: {{ Request::routeIs('admin.member.member-donation-online', encrypt($member->id)) ? 'bold' : 'normal' }};
                     display: inline-block;
                     border-bottom: {{ Request::routeIs('admin.member.member-donation-online', encrypt($member->id)) ? '2px solid #6c757d' : 'none' }};">
                  Razorpay Donation
                  </a>
               </div>
               <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                  <img src="{{ asset('admin/assets/img/cash-payment.png') }}" >
                  <a href="{{ route('admin.member.member-donation-offline', encrypt($member->id)) }}" 
                     style="color: {{ Request::routeIs('admin.member.member-donation-offline', encrypt($member->id)) ? 'gray' : '#d56337' }};
                     text-decoration: none;
                     font-weight: {{ Request::routeIs('admin.member.member-donation-offline', encrypt($member->id)) ? 'bold' : 'normal' }};
                     display: inline-block;
                     border-bottom: {{ Request::routeIs('admin.member.member-donation-offline', encrypt($member->id)) ? '2px solid #6c757d' : 'none' }};">
                  Offline Donation
                  </a>
               </div>
            </div>
            {{-- Right Side: Search Form --}}
            <div>
               <form action="{{ url()->current() }}" method="get" style="display: flex; gap: 10px; align-items: center;">
                  <input type="text" class="form-control" value="{{ request()->query('invoice_no', '') }}" name="invoice_no" required placeholder="Search Invoice No">
                  <button class="btn btn-primary">Search</button>
                  <button type="button" class="btn btn-info" onclick="window.location.href='{{ route(Route::currentRouteName(), encrypt($member->id)) }}';">Reset</button>
               </form>
            </div>
         </div>
         <div class="card-body mt-2">
            <div class="table-responsive table-card mt-3 mb-1">
               <table class="table align-middle table-nowrap table-striped">
                  <thead class="table-light">
                     <tr>
                        <th>SL</th>
                        <th>Invoice No</th>
                        @if (Request::routeIs('admin.member.member-donation-online'))
                        <th>Razorpay Id</th>
                        @endif
                        <th>Payment Mode</th>
                        <th>Amount</th>
                        <th class="text-nowrap">Payment Date</th>
                        <th>Attachment</th>
                        @if (Request::routeIs('admin.member.member-donation-offline'))
                        <th>Verification</th>
                        @endif
                     </tr>
                  </thead>
                  <tbody>
                     @if($donations->count() > 0)
                     @foreach($donations as $key => $donation)
                     <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $donation->invoice_no ?? 'N/A' }}</td>
                        @if (Request::routeIs('admin.member.member-donation-online'))
                        <td>{{ $donation->r_payment_id ?? 'N/A' }}</td>
                        @endif
                        <td>
                           @php
                           $modeText = match($donation->mode) {
                           '1' => 'Online Payment Via Member Registration Page',
                           '2' => 'Donate Page Payment',
                           '3' => 'Offline Payment Via Member Registration Page',
                           '4' => 'Donate With His Pannel',
                           default => 'N/A'
                           };
                           @endphp
                           {{ $modeText }}
                        </td>
                        <td>{{ $donation->amount ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($donation->created_at)->format('d-M-Y') }} </td>
                        <td class="text-center">
                            @if ($donation && (!empty($donation->donation_pdf) || !empty($donation->attachment)))
                                <ul class="list-unstyled mb-0 d-flex justify-content-center gap-3">
                                    @if (!empty($donation->donation_pdf))
                                    <li>
                                        <a href="{{ asset($donation->donation_pdf) }}" target="_blank" title="Download Invoice" class="text-decoration-none">
                                            <i class="fa-solid fa-file-pdf text-danger fs-5"></i>
                                        </a>
                                    </li>
                                    @endif
                                    @if (!empty($donation->attachment))
                                    <li>
                                        <a href="{{ asset($donation->attachment) }}" target="_blank" id="Other Attachment" class="text-decoration-none">
                                            <i class="fa-solid fa-paperclip text-primary fs-5"></i> 
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            @else
                                <span class="text-muted">No Attachments Available</span>
                            @endif
                        </td>
                        @if (Request::routeIs('admin.member.member-donation-offline'))
                        <td class="text-center"> 
                           @if($donation->mode == 3) {{-- Offline Only --}}
                           @if($donation->is_verified)
                           <span class="verified-badge">Verified</span>
                           @else
                           <form method="POST" action="{{ route('admin.member.donation-verify', $donation->id) }}" class="verify-form d-inline" data-invoice="{{ $donation->invoice_no }}">
                              @csrf
                              @method('PATCH')
                              <input type="hidden" name="verify" value="1">
                              <button type="button" class="btn btn-sm btn-danger verify-btn text-nowrap">Mark as Verified</button>
                           </form>
                           @endif
                           @else
                           <span class="text-muted">N/A</span>
                           @endif
                        </td>
                        @endif                                           
                     </tr>
                     @endforeach
                     @else
                     <tr>
                        <td colspan="6" class="text-center text-danger">Donation's Not Found</td>
                     </tr>
                     @endif
                  </tbody>
               </table>
               <div class="d-flex justify-content-center mt-3">
                  {{ $donations->links('pagination::bootstrap-4') }}
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@push('js')
<script>
   document.addEventListener('DOMContentLoaded', function () {
       const verifyButtons = document.querySelectorAll('.verify-btn');
       verifyButtons.forEach(button => {
           button.addEventListener('click', function (e) {
               const form = this.closest('form');
               const invoiceNo = form.getAttribute('data-invoice') || 'N/A';
               Swal.fire({
                   title: 'Are you sure?',
                   text: `You are about to verify donation with Invoice No: ${invoiceNo}`,
                   icon: 'warning',
                   showCancelButton: true,
                   confirmButtonColor: '#3085d6',
                   cancelButtonColor: '#d33',
                   confirmButtonText: 'Yes, verify it!'
               }).then((result) => {
                   if (result.isConfirmed) {
                       form.submit();
                   }
               });
           });
       });
   });
</script>
@endpush