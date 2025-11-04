@extends('member.layouts.app')
@section('content')
<style>
    .mail-menu a {
        font-size: 20px;
        padding: 0 20px 5px 15px;
    }
    .mail-menu img {
     width: 40px;
    }
</style>
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0">Payment Listing <span class="count-circle" style="margin-left: 1%;">{{ count($donations) }}</span> </h4>
            </div>
         </div>
      </div>
      <div class="card">
         <div class="card-body">
            <form id="donate-online" method="POST" action="{{ route('member.donate') }}"  >
               @csrf
               <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
               <input type="hidden" name="transaction_via" value="razorpay">
               <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
               <input type="hidden" name="merchant_order_id" value="<?= rand(11111, 99999) . time() ?>">
               <div class="row">
                  <div class="col-md-6" style="margin-top: 18px;" >
                     <label>Amount <span class="text-danger">* </span></label>
                     <input type="text" class="form-control amount" id="amount" name="amount" >                           
                  </div>
                  <div class="col-md-2" style="margin-top: 44px;" >
                     <input type="submit" class="btn btn-primary pay-online" value="Pay Online"  >
                  </div>
               </div>
            </form>
         </div>
      </div>
        <div class="card shadow">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                {{-- Left Side: Member Tabs --}}
                <div class="mail-menu" style="display: flex; gap: 20px;">
                <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <img src="{{ asset('admin/assets/img/payment-method.png') }}">
                    <a href="{{ route('member.payment') }}" style="color: {{ Request::routeIs('member.payment') ? 'gray' : '#d56337' }};text-decoration: none;font-weight: {{ Request::routeIs('member.payment') ? 'bold' : 'normal' }};display: inline-block;border-bottom: {{ Request::routeIs('member.payment') ? '2px solid #6c757d' : 'none' }};">Razorpay Donation</a>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <img src="{{ asset('admin/assets/img/cash-payment.png') }}" >
                    <a href="{{ route('member.payment-offline') }}" style="color: {{ Request::routeIs('member.payment-offline') ? 'gray' : '#d56337' }};text-decoration: none;font-weight: {{ Request::routeIs('member.payment-offline') ? 'bold' : 'normal' }};display: inline-block;border-bottom: {{ Request::routeIs('member.payment-offline') ? '2px solid #6c757d' : 'none' }};">Offline Donation</a>
                </div>
                </div>
                {{-- Right Side: Search Form --}}
                <div>
                <form action="{{ url()->current() }}" method="get" style="display: flex; gap: 10px; align-items: center;">
                    <input type="text" class="form-control" value="{{ request()->query('invoice_no', '') }}" name="invoice_no" required placeholder="Search Invoice No">
                    <button class="btn btn-primary">Search</button>
                    <button type="button" class="btn btn-info" onclick="window.location.href='{{ route(Route::currentRouteName()) }}';">Reset</button>
                </form>
                </div>
            </div>
            <div class="card-body">
                <table class="table align-middle table-nowrap table-striped" id="">
                    <thead class="table-dark">
                        <tr>
                            <th>SL</th>
                            <th>Invoice No	</th>
                            @if (Request::routeIs('member.payment'))
                            <th>Razorpay Id</th>
                            @endif
                            <th>Payment Mode</th>
                            <th>Amount</th>
                             <th class="text-nowrap">Payment Date</th>
                            <th>Attachment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($donations))
                        @foreach($donations as $donation)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $donation->invoice_no ?? 'N/A' }}</td>
                             @if (Request::routeIs('member.payment'))
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
                            <td>{{ $donation->amount ?? '0' }}</td>                          
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


                        </tr>
                        @endforeach
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
<script>
   var RAZORPAY_KEY = "{{ env('RAZORPAY_KEY') }}";
   var razorpay_logo = "{{ asset('front/images/Gaam_Raam_logo.png') }}";
   const razorpayInitiateUrl = "{{ route('member.razorpay-initiate-payment') }}";
   const razorpayUser = {
       name: "{{ Auth::user()->name }}",
       email: "{{ Auth::user()->email }}",
       mobile: "{{ Auth::user()->mobile }}"
   };
</script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="{{ asset('member/backend/js/razorpay.js') }}"></script>
@endpush