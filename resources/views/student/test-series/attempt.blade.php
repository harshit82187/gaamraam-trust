@extends('student.layout.app')
@section('content')

<div class="page-content _all_responsive_panel">
    <div class="quiz-header mb-4">Test Series Name : {{ $testSeries->name ?? 'N/A' }}</div>
    <div class="container">
        <div class="card w-100">
            <div class="row">
                <div class="col-md-4">
                    <div class="questions_timer">
                        <div class="icon-holder">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                    <g id="button-top">
                                        <path fill="none" stroke="#222" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" d="M128 8v29" />
                                        <path fill="none" stroke="#222" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" d="M112 8h32" />
                                    </g>
                                    <circle cx="128" cy="143" r="105" fill="#FFF" stroke="#222" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                    <path id="big-hand" fill="none" stroke="#222" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" d="M128 72v71" />
                                </svg>
                            </div>
                        </div>
                        <span id="timerDisplay"></span>
                    </div>
                    <div class="quiz-sidebar">
                        <div class="questions-nav">
                            @isset($questions)
                            @foreach($questions as $key => $question)
                            <button class="question-btn" data-q="{{ $key + 1 }}">{{ $key + 1 }}</button>
                            @endforeach
                            @endisset
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="question-area">
                        <div class="question-box">
                            <h3>Question No. <span id="question-number">1</span></h3>
                            <p><strong id="question-text"></strong></p>
                            <div class="quiz-option" id="options-container">
                                {{-- option's show here dynamic --}}
                            </div>
                        </div>
                        <div class="buttons">
                            <button class="btn btn-primary qus_save_btn" id="saveNext">Save & Next</button>
                            <button class="btn btn-success qus_submit_btn" id="submitQuiz" style="display: none;">Submit Test</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection

@push('js')
<script>
    var testSeriesQuestions = @json($questions);
    var testSeriesId = @json($testSeries->id);
    var saveAnswerRoute = "{{ route('student.save-answer') }}";
    var csrfToken = "{{ csrf_token() }}";
    var submitTestRoute = "{{ route('student.test-result', ['testSeriesId' => $testSeries->id]) }}";
    var testDuration = "{{ $testSeries->duration * 60  }}";
    var autoLogout = "{{ route('student.autoLogout') }}";
    var studentLogin = "{{ route('student.login') }}";
</script>
<script src="{{ asset('student/backend/css/test-series.js') }}"></script>
@endpush