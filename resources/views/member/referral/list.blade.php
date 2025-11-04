@extends('member.layouts.app')
@section('content')
<style>
   .radio-group {
    display: flex;
    position: relative;
    gap: 0;
    background: #f4f4f4;
    border-radius: 8px;
    width: fit-content;
    padding: 5px;
    overflow: hidden;
}
</style>
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Referral List <span class="count-circle" style="margin-left: 1%;" >{{ count($referrals) }}</span> </h4> 
                </div>
            </div>
        </div>

        @if(request()->routeIs('member.referral-list') )
        <div class="card" style="margin-left: -2%;">
            <!-- Member Type Toggle (Above the Card Body) -->
            <div class="label-div d-flex gap-2 radio-group">
                <div class="card-header text-center p-3">
                    <div class="form-check form-check-inline ms-3">
                        <input class="form-check-input" type="radio" name="member_type" id="indian" value="1" checked onclick="togglePassport(false)">
                        <label class="form-check-label" for="indian">Indian</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="member_type" id="nri" value="2" onclick="togglePassport(true)">
                        <label class="form-check-label" for="nri">NRI</label>
                    </div>
                </div>
            </div>
           
        
            <div class="card-body">
                <form method="POST" id="enroll-member" action="{{ route('member.enroll-member') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                    <input type="hidden" name="transaction_via" value="razorpay">
                    <input type="hidden" name="merchant_order_id" value="<?= rand(11111, 99999) . time() ?>">
                    <input type="hidden" name="currency"  id="razorpay_currency">
                    <div class="row">
                        <div class="col-md-6" style="margin-top: 18px;">
                            <label>Name <span class="text-danger">* </span></label>
                            <input type="text" class="form-control"  id="regName" name="name" placeholder="Enter Your Referral Member Name" autocomplete="one-time-code">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6" style="margin-top: 18px;">
                            <label>Email <span class="text-danger">* </span></label>
                            <input type="email" class="form-control" id="regEmail" name="email" placeholder="Enter Your Referral Member Email" autocomplete="one-time-code">
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6" style="margin-top: 18px;">
                            <label>Mobile Number <span class="text-danger">* </span></label>
                            <input type="number" class="form-control" id="regMobile" regName name="mobile" placeholder="Enter Your Referral Member Mobile No" autocomplete="one-time-code">
                            @error('mobile')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6" style="margin-top: 18px;">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Create Your Referral Member Password" autocomplete="one-time-code">
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
        
                        <!-- Passport No (Hidden by Default) -->
                        <div class="col-md-6" id="passportField" style="margin-top: 18px; display: none;">
                            <label>Passport No <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="password" name="passport" placeholder="Enter Passport Number">
                        </div>
        
                        <div class="col-md-6" style="margin-top: 18px;">
                            <label>Payment Mode <span class="text-danger">* </span></label>
                            <select class="form-select" name="mode" id="mode" required>
                                <option value="3" selected>Offline Mode (Bar Code Scan)</option>
                                <option value="1" >Razorpay</option>                               
                            </select>
                            @error('member_type')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6" style="margin-top: 18px;">
                            <label id="amount-label">Amount <span class="text-danger">*</span></label>
                            <input type="text" class="form-control amount" name="amount" id="amount" placeholder="Enter Donate Amount" autocomplete="one-time-code">
                            @error('amount')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12" >
                            <span id="qr-code-body" ></span>

                        </div>
        
                        <div class="row">
                            <div class="col-md-2" style="margin-top: 18px;">
                                <input type="submit" class="btn btn-primary submit-button"  value="Submit">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif

        <div class="card" style="margin-left: -2%;">
            <div class="card-body">
                <table class="table table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Referred Name</th>
                            <th>Contact Info</th>
                            <th>Donate Amount</th>
                            <th>Earned Points</th>
                            <th>Type</th>
                            <th>Joined On</th>
                            <th>Attachemnt</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($referrals->count() > 0)
                        @foreach($referrals as $referral)
                        <tr>
                            @php $user = $referral->type == '1' ? $referral->referred : $referral->referredStudent;
                                    $donation = ($referral->type == '1' && $user) ? \App\Models\Payment::where('user_id', $user->id)->first() : null; 
                                    
                            @endphp
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name ?? 'N/A' }}</td>
                            <td>{{ $user->email ?? 'N/A' }} <br> {{ $user->mobile ?? 'N/A' }}</td>
                            <td style="white-space: nowrap;">
                                <span style="display: inline-block; min-width: 80px; text-align: center;">
                                    {{ $donation->amount ?? 'N/A' }}
                                </span>
                                <strong>{{ $donation->currency ?? 'N/A' }}</strong>
                            </td>

                            <td>{{ $referral->points ?? 'N/A' }}</td>
                            <td>
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
                            <td>{{ \Carbon\Carbon::parse($referral->created_at)->format('d-M-Y') }} </td>
                            <td>
                                @if($donation)
                                    @if(!empty($donation->donation_pdf))
                                        <a href="{{ asset($donation->donation_pdf) }}" target="_blank">🔗</a><br>
                                    @endif

                                    @if(!empty($donation->attachment))
                                        <a href="{{ asset($donation->attachment) }}" target="_blank">🔗</a>
                                    @endif
                                @else
                                    <span class="text-muted">No Atttachment Available</span>
                                @endif
                            </td>

                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="6" class="text-danger text-center">No Referaal Exist Yet.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <div class="d-flex justify-content-center new-one-nav">
                    {{ $referrals->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    function togglePassport(show) {
        const passportField = document.getElementById("passportField");
        passportField.style.display = show ? "block" : "none";
    }
</script>
<script>
    $(document).ready(function () {
        function toggleQRCode() {
            var value = $('#mode').val();
            console.log("Selected Mode: " + value);
            var qrBody = `
                <div>
                    <label class="mt-3 fs-5">Please Scan This QR Code And Then Upload Transaction Screenshot<span class="text-danger">*</span></label>
                    <img src="{{ asset('front/images/GammRaamQrCode.PNG') }}" alt="QR Code" class="barcode_img">
                    <input type="file" name="attachment" id="attachment" class="form-control mt-2" required accept="image/*">
                </div>`;

            if (value == "3") {
                $('#qr-code-body').html(qrBody);
            } else {
                $('#qr-code-body').empty();
            }
        }
        toggleQRCode();
        $('#mode').on('change', function () {
            toggleQRCode();
        });
        $('input[name="amount"]').on('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
            var amount = parseInt(this.value, 10) || 0;
            console.log("Amount: " + amount);
        });
    });
</script>

<script>
    var RAZORPAY_KEY = "{{ env('RAZORPAY_KEY') }}";
    var razorpay_logo = "{{ asset('front/images/Gaam_Raam_logo.png') }}";
</script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="{{ asset('member/backend/js/member-enrooll-razorpay.js') }}"></script>
@endpush