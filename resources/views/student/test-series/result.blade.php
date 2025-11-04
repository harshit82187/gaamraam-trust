@extends('student.layout.app')
@section('content')

<div class="page-content _all_responsive_panel">
    <div class="container">
        <div class="result-card">
            <h3>Test Result - {{ $testSeries->name ?? 'N/A' }}</h3>

            <div class="score">{{ $totalCorrect }}/{{ $totalQuestions }}</div>

            <div class="status {{ $totalCorrect >= ($totalQuestions * 0.5) ? 'pass' : 'fail' }}">
                {{ $totalCorrect >= ($totalQuestions * 0.5) ? 'Congratulations! You Passed 🎉' : 'Better Luck Next Time 😞' }}
            </div>

            <div class="result-details">
                <p><strong>Total Questions:</strong> {{ $totalQuestions }}</p>
                <p><strong>Correct Answers:</strong> {{ $totalCorrect }}</p>
                <p><strong>Wrong Answers:</strong> {{ $totalQuestions - $totalCorrect }}</p>
                <p><strong>Percentage:</strong> {{ round(($totalCorrect / $totalQuestions) * 100, 2) }}%</p>
            </div>

            <div class="btn-group">
                <a href="{{ route('student.dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')

@endpush