@extends('student.layout.app')
@section('content')
@push('css')

@endpush
<div class="page-content _all_responsive_panel">
    <div class="row">
        @foreach($testSeries as $series)
            @php $questions = \App\Models\QuestionBank::where('test_series_id',$series->id)->get();
                $attemptDateTime = \Carbon\Carbon::parse($series->attempt_date_time);
                $now = \Carbon\Carbon::now();
                $isUpcoming = $attemptDateTime->gt($now);
            @endphp
            @if(count($questions) > 0)
                <div class="col-lg-4">
                        <div class="test-series-card">
                            <img src="{{ asset($series->image ?? 'front/images/no-image.jpg') }}" alt="Test Series Image">
                            <h5>{{ $series->name }}</h5>
                            <div class="countdown" data-time="{{ $series->attempt_date_time }}"></div>
                            <div class="btn_group_test">
                                <span class="test-series-badge">{{ count($questions) ?? '0' }} Questions</span>
                                @if($isUpcoming)
                                <button class="btn-view" disabled>Coming Soon</button>
                                @else
                                    <a href="{{ route('student.get-test-series', ['slug' => $series->slug]) }}">
                                        <button class="btn-view">Attempt Test</button>
                                    </a>
                                @endif
                            </div>
                        </div>
                </div>
            @endif
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $testSeries->links() }} <!-- Pagination -->
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function () {
    // Loop through each countdown element
    $('.countdown').each(function () {
        var countdownElement = $(this);
        var attemptDateTime = countdownElement.data('time'); // Get the test series attempt date-time
        var endTime = new Date(attemptDateTime).getTime(); // Convert to timestamp

        // Update the countdown every second
        var interval = setInterval(function () {
            var now = new Date().getTime(); // Current time
            var timeLeft = endTime - now; // Time remaining in milliseconds

            if (timeLeft <= 0) {
                clearInterval(interval); // Stop the countdown when time is up
                countdownElement.text("Test is live!"); // Update text when time is up
                countdownElement.closest('.test-series-card').find('.btn-secondary').prop('disabled', false); // Enable the "Attempt Test" button
                countdownElement.closest('.test-series-card').find('.btn-secondary').removeClass('disabled'); // Remove disabled class
            } else {
                var days = Math.floor(timeLeft / (1000 * 60 * 60 * 24)); // Calculate days
                var hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)); // Calculate hours
                var minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60)); // Calculate minutes
                var seconds = Math.floor((timeLeft % (1000 * 60)) / 1000); // Calculate seconds

                countdownElement.text(days + "d " + hours + "h " + minutes + "m " + seconds + "s "); // Update countdown display
            }
        }, 1000); // Run the countdown every second
    });
});

</script>

@endpush
