@extends('student.layout.app')
@section('content')

<div class="page-content">
    @php $student = Auth::guard('student')->user();  @endphp
    @if($student->state == null || $student->city == null || $student->address == null)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header doc_uplader">
                    <h3 class="flex-wrap gap-3">Please First Complete Your Profile <a href="{{ route('student.profile') }}" ><i class="fas fa-hand-point-right"></i>Click Here...</a> </h3>
                </div>
            </div>
        </div>
    </div>
    @endif

    @php
    $fields = [
        'name',
        'email',
        'password',
        'mobile',
        'course',
        'image',
        'state',
        'city',
        'gender',
        'block',
        'dob',
        'address',
        'status'
    ];

    $filledFields = 0;
    foreach ($fields as $field) {

        if (!empty($student->$field) || $student->$field !== null) {
            $filledFields++;
        }
    }


    $totalFields = count($fields);
    $progress = ($filledFields / $totalFields) * 100;

    $progressColor = '';
$progressText = '';

if ($progress == 100) {
    $progressColor = 'green';
    $progressText = ''; // Empty text for 100%
} elseif ($progress >= 50 && $progress <= 99) {
    $progressColor = 'yellow';
    $progressText = round($progress) . '%';
} else {
    $progressColor = 'red';
    $progressText = round($progress) . '%';
}


    $documentCount = DB::table('documents')
        ->where('student_id', $student->id)
        ->count();


    $totalDocuments = 7;


    $documentprogress = ($documentCount / $totalDocuments) * 100;


    $documentprogress = min($documentprogress, 100);

    $documentProgressColor = '';
$documentProgressText = '';

if ($documentprogress == 100) {
    $documentProgressColor = 'green';
    $documentProgressText = ''; // Empty text for 100%
} elseif ($documentprogress >= 50 && $documentprogress <= 99) {
    $documentProgressColor = 'yellow';
    $documentProgressText = round($documentprogress) . '%';
} else {
    $documentProgressColor = 'red';
    $documentProgressText = round($documentprogress) . '%';
}



    @endphp


    <div class="row">
        <div class="documnetss-process-detail">
        <div class="progress-bar-divv">
            <span class="fw-bold">Profile</span>
    <div class="progress-profile">
        <div class="progress-value-profile" style="width: {{ $progress }}%; background-color: {{ $progressColor }};"></div>
        @if ($progress != 100)
            <span style="color: black;">{{ $progressText }}</span>
        @endif
    </div>
    @if ($progress == 100)
        <div class="profile-complete">
            <p>Profile completed</p>
        </div>
    @endif
</div>

<div class="progress-bar-divv">
<span class="fw-bold">Documnent</span>

    <div class="progress-doc">
        <div class="progress-value-doc" style="width: {{ $documentprogress }}%; background-color: {{ $documentProgressColor }};"></div>
        @if ($documentprogress != 100)
            <span style="color: black;">{{ $documentProgressText }}</span>
        @endif
    </div>
    @if ($documentprogress == 100)
        <div class="profile-complete">
            <p>Document completed</p>
        </div>
    @endif
</div>

                <div class="progress-bar-divv">
                <span class="fw-bold">Test</span>

                    <div class="progress-test-test">
                        <div class="progress-value-test" style="width:0%;"></div>
                            <span>0%</span>

                    </div>
                    <div class="profile-complete">
                            <!-- <p>
                        Test complete rate
                            </p> -->
                        </div>
                </div>

        </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card l-bg-purple-dark hover">
                <a style="font-weight:bold;color:white;text-decoration:none;" href="{{ route('student.notification') }}">
                    <div class="card-statistic-3">
                        <div class="card-icon card-icon-large"><i class="fa fa-globe"></i></div>
                        <div class="card-content">
                            <h4 class="card-title" style="font-size: 18px; font-weight:700; color:#fff;">Notification</h4>
                            <div class="d-flex justify-content-between">
                                <span class="d-block" style="font-size: 20px;">{{ $notifications ?? '0' }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card l-bg-green-dark hover">
                <a style="font-weight:bold;color:white;text-decoration:none;" href="{{ route('student.document-list') }}">
                    <div class="card-statistic-3">
                        <div class="card-icon card-icon-large"><i class="fa fa-award"></i></div>
                        <div class="card-content">
                            <h4 class="card-title" style="font-size: 18px; font-weight:700; color:#fff;">Document </h4>
                            <div class="d-flex justify-content-between">
                                <span class="d-block" style="font-size: 20px;">{{ $documents ?? '0' }} </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection