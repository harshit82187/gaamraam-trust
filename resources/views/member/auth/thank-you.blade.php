@extends('front.layout.app')
@section('content')
<style>
    .card {
        border-radius: 10px;
    }
    .table th {
        background-color: #f8f9fa;
    }
</style>
<div class="container my-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white text-center">
            <h4>🎉 Thank You for Your Subscription!</h4>
        </div>
        <div class="card-body">
            <p class="text-center text-success" style="font-size: 18px;">
                Your payment was successful. Below are your subscription details:
            </p>

            <table class="table table-bordered">
                <tr>
                    <th>Plan Name</th>
                    <td>{{ $subscription->plan_name }}</td>
                </tr>
                <tr>
                    <th>Plan Amount</th>
                    <td>{{ $subscription->plan_amount }}</td>
                </tr>
                <tr>
                    <th>Interval</th>
                    <td>{{ ucfirst($subscription->interval) }}</td>
                </tr>
                <tr>
                    <th>Subscription ID</th>
                    <td>{{ $subscription->subscription_id }}</td>
                </tr>
                <tr>
                    <th>Razorpay Payment ID</th>
                    <td>{{ $subscription->razorpay_payment_id }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $subscription->customer_email }}</td>
                </tr>
                <tr>
                    <th>Contact</th>
                    <td>{{ $subscription->customer_contact }}</td>
                </tr>
                <tr>
                    <th>Subscription Link</th>
                    <td><a href="{{ $subscription->subscription_link }}" target="_blank">View Subscription</a></td>
                </tr>
                <tr>
                    <th>Member Login</th>
                    <td><a href="{{ url('member-register?form=login') }}" target="_blank">Click Here</a></td>
                </tr>
            </table>
        </div>
    </div>
</div>

@endsection 

@push('js')

@endpush