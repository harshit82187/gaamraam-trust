@extends('admin.layout.app')
@section('content')
    <div class="card">
        <div class="card-header" style="display: flex;justify-content: space-between;align-items: center;">
            <h3>{{ $course->name ?? '' }} Info</h3>
            <a href="{{ route('admin.courses') }}" class="btn btn-dark btn-sm">Back</a>
        </div>

        <div class="row">
            <div class="col-12">
                @if(session()->get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @elseif(session()->get('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session()->get('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li style="font-size:larger;">{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.update-course') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                <div class="row">
                    <div class="col-12">
                        <img src="{{ asset($course->image) }}" alt="image" width="120px" height="120px" style="margin-left: 42%;" >
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Upload Image <span class="text-danger">*</span></label> 
                        <input type="file" class="form-control" name="image" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label>Course Name (In English) <span class="text-danger">*</span></label> 
                        <input type="text" class="form-control" name="name" value="{{ $course->name }}" required
                            placeholder="Enter course name">
                    </div>
                    <div class="col-md-6 mt-2">
                        <label>पाठ्यक्रम का नाम (हिंदी में) <span class="text-danger">*</span></label> 
                        <input type="text" class="form-control" name="name_hi" required value="{{ $course->name_hi }}" 
                            placeholder="विवरण दर्ज करें">
                    </div>

                </div>
                    
                    <div class="col-12" style="margin-top: 2%;">
                        @if($course->id == 1)
                        <label>What Is  {{ $course->name }} (In English)  <span class="text-danger">*</span></label> 
                        @else 
                        <label>What is SSC & HSSC, and Why Are They Important? (In English)  <span class="text-danger">*</span></label> 
                        @endif
                        <textarea class="form-control editor" name="tab_one" rows="5" placeholder="Enter Details" required>{{ $course->tab_one }}</textarea>
                        
                    </div>

                    <div class="col-12" style="margin-top: 2%;">
                        @if($course->id == 1)
                        <label>{{ $course->name_hi }} क्या है (हिंदी में) <span class="text-danger">*</span></label> 
                         @else 
                             <label>एसएससी और एचएसएससी क्या है, और वे महत्वपूर्ण क्यों हैं? (हिंदी में)  <span class="text-danger">*</span></label> 
                        @endif
                        <textarea class="form-control editor" name="tab_one_hi" rows="5" placeholder="विवरण दर्ज करें" required>{{ $course->tab_one_hi }}</textarea>
                        
                    </div>

                    <div class="col-12" style="margin-top: 2%;">
                        @if($course->id == 1)
                        <label>Who Can Apply For  {{ $course->name }} (In English) <span class="text-danger">*</span></label> 
                        @else
                        <label>Eligibility Criteria for SSC & HSSC Exams (In English) <span class="text-danger">*</span> </label> 
                        @endif
                        <textarea class="form-control editor" name="tab_two" rows="5" placeholder="Enter Details" required>{{ $course->tab_two }}</textarea>
                    </div>

                    <div class="col-12" style="margin-top: 2%;">
                        @if($course->id == 1)
                        <label>{{ $course->name_hi }} के लिए कौन आवेदन कर सकता है (हिंदी में) <span class="text-danger">*</span></label> 
                        @else
                        <label>एसएससी और एचएसएससी परीक्षाओं के लिए पात्रता मानदंड (हिंदी में)<span class="text-danger">*</span> </label> 
                        @endif
                        <textarea class="form-control editor" name="tab_two_hi" rows="5" placeholder="विवरण दर्ज करें" required>{{ $course->tab_two_hi }}</textarea>
                    </div>

                    <div class="col-12" style="margin-top: 2%;">
                        @if($course->id == 1)
                        <label>Exam Structure (In English) <span class="text-danger">*</span></label> 
                        @else 
                        <label>SSC & HSSC Exam Stages & Pattern (In English)<span class="text-danger">*</span></label> 
                        @endif
                        <textarea class="form-control editor" name="tab_three" rows="5" placeholder="Enter Details" required>{{ $course->tab_three }}</textarea>
                    </div>

                    <div class="col-12" style="margin-top: 2%;">
                        @if($course->id == 1)
                        <label>परीक्षा संरचना (हिंदी में)<span class="text-danger">*</span></label> 
                        @else 
                        <label>एसएससी और एचएसएससी परीक्षा चरण और पैटर्न (हिंदी में)<span class="text-danger">*</span></label> 
                        @endif
                        <textarea class="form-control editor" name="tab_three_hi" rows="5" placeholder="विवरण दर्ज करें" required>{{ $course->tab_three_hi }}</textarea>
                    </div>



                    <div class="col-12" style="margin-top: 2%;">
                        @if($course->id == 1)
                        <label>Course Plan & Schedule (In English)<span class="text-danger">*</span></label> 
                        @else 
                        <label>SSC CGL 2026 & HSSC Target Course & Schedule 🌟 (In English)<span class="text-danger">*</span></label> 
                        @endif
                        <textarea class="form-control editor" name="tab_four" rows="5" placeholder="Enter Details" required>{{ $course->tab_four }}</textarea>
                    </div>

                    <div class="col-12" style="margin-top: 2%;">
                        @if($course->id == 1)
                        <label>पाठ्यक्रम योजना एवं अनुसूची (हिंदी में)<span class="text-danger">*</span></label> 
                        @else 
                        <label>SSC CGL 2026 और HSSC लक्ष्य पाठ्यक्रम और अनुसूची 🌟 (हिंदी में)<span class="text-danger">*</span></label> 
                        @endif
                        <textarea class="form-control editor" name="tab_four_hi" rows="5" placeholder="विवरण दर्ज करें" required >{{ $course->tab_four_hi }}</textarea>
                    </div>

                    <div class="col-12" style="margin-top: 2%;">
                        <label>Why Join Us <span class="text-danger">*</span></label> 
                        <div id="join_us_Fields">
                            @if (!empty($whyJoinUs))
                                @foreach ($whyJoinUs as $index => $whyJoinU)
                                    <div class="row mb-2">
                                        <div class="col-sm-5 my-1 my-sm-0">
                                            <input type="text" class="form-control" name="why_join_us[{{ $index }}][en]" 
                                                value="{{ $whyJoinU['en'] ?? '' }}" 
                                                required placeholder="Enter Tag (English)">
                                        </div>
                                        <div class="col-sm-5 my-1 my-sm-0">
                                            <input type="text" class="form-control" name="why_join_us[{{ $index }}][hi]" 
                                                value="{{ $whyJoinU['hi'] ?? '' }}" 
                                                required placeholder="Enter Tag (Hindi)">
                                        </div>
                                        <div class="col-sm-2 my-1 my-sm-0">
                                            @if ($index == 0)
                                                <button type="button" class="btn btn-success add-join">+</button>
                                            @else 
                                                <button type="button" class="btn btn-danger remove-join">-</button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row mb-2">
                                    <div class="col-sm-5 my-1 my-sm-0">
                                        <input type="text" class="form-control" name="why_join_us[0][en]" required placeholder="Enter Tag (English)">
                                    </div>
                                    <div class="col-sm-5 my-1 my-sm-0">
                                        <input type="text" class="form-control" name="why_join_us[0][hi]" required placeholder="Enter Tag (Hindi)">
                                    </div>
                                    <div class="col-sm-2 my-1 my-sm-0">
                                        <button type="button" class="btn btn-success add-join">+</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>



                    <div class="col-12" style="margin-top: 2%;">
                        <label>Program Includes <span class="text-danger">*</span></label> 
                        <div id="program_Fields">
                            @if (!empty($programs))
                                @foreach ($programs as $index => $program)
                                    <div class="row mb-2">
                                        <div class="col-sm-5 my-1 my-sm-0">
                                            <input type="text" class="form-control" 
                                                name="programs[{{ $index }}][en]" 
                                                value="{{ $program['en'] ?? '' }}" 
                                                required placeholder="Enter Tag (English)">
                                        </div>
                                        <div class="col-sm-5 my-1 my-sm-0">
                                            <input type="text" class="form-control" 
                                                name="programs[{{ $index }}][hi]" 
                                                value="{{ $program['hi'] ?? '' }}" 
                                                required placeholder="टैग दर्ज करें (हिंदी)">
                                        </div>
                                        <div class="col-sm-2 my-1 my-sm-0">
                                            @if ($index == 0)
                                                <button type="button" class="btn btn-success add-program">+</button>
                                            @else 
                                                <button type="button" class="btn btn-danger remove-program">-</button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row mb-2">
                                    <div class="col-sm-5 my-1 my-sm-0">
                                        <input type="text" class="form-control" name="programs[0][en]" required placeholder="Enter Tag (English)">
                                    </div>
                                    <div class="col-sm-5 my-1 my-sm-0">
                                        <input type="text" class="form-control" name="programs[0][hi]" required placeholder="Enter Tag (Hindi)">
                                    </div>
                                    <div class="col-sm-2 my-1 my-sm-0">
                                        <button type="button" class="btn btn-success add-program">+</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>



                    <div class="col-12" style="margin-top: 2%;">
                        @if($course->id == 1)
                        <label>Prelims Preparation Plan (In English)  <span class="text-danger">*</span></label>
                        @else 
                        <label>SSC & HSSC Exam Preparation Plan (In English)  <span class="text-danger">*</span></label> 
                        @endif
                        <textarea class="form-control editor" name="preparation_plans" rows="5" placeholder="Enter Details" required>{{ $course->preparation_plans }}</textarea>
                    </div>

                    <div class="col-12" style="margin-top: 2%;">
                        @if($course->id == 1)
                        <label>Prelims Preparation Plan (In Hindi)  <span class="text-danger">*</span></label>
                        @else 
                        <label>SSC & HSSC Exam Preparation Plan (In Hindi)  <span class="text-danger">*</span></label> 
                        @endif
                        <textarea class="form-control editor" name="preparation_plans_hi" rows="5" placeholder="विवरण दर्ज करें"  required>{{ $course->preparation_plans_hi }}</textarea>
                    </div>

                    {{-- <div class="col-12"  style="margin-top: 2%;">
                        <label>Prelims Preparation Plan</label> <span class="text-danger">*</span>
                        <div id="preparation_plans_Fields">
                            @if (!empty($preparation_plans))
                                    @foreach ($preparation_plans as $index => $preparation_plan)
                                        <div class="row mb-2">
                                            <div class="col-10">
                                                <input type="text" class="form-control" name="preparation_plans[]" value="{{ $preparation_plan }}" required placeholder="Enter Tag">
                                            </div>
                                            <div class="col-sm-2 my-1 my-sm-0">
                                                @if ($index == 0)
                                                    <button type="button" class="btn btn-success add-preparation">+</button>
                                                    @else 
                                                    <button type="button" class="btn btn-danger remove-preparation">-</button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else 
                                <div class="row mb-2">
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="preparation_plans[]" required placeholder="Enter Preparation Plans Detail">
                                    </div>
                                    <div class="col-sm-2 my-1 my-sm-0">
                                        <button type="button" class="btn btn-success add-preparation">+</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div> --}}

                    <div class="col-12" style="margin-top: 2%;">
                        <label>Mains Answer Writing & Test Series <span class="text-danger">*</span></label> 
                        <div id="test_series_Fields">
                            @if (!empty($test_series))
                                @foreach ($test_series as $index => $test_serie)
                                    <div class="row mb-2">
                                        <div class="col-sm-5 my-1 my-sm-0">
                                            <input type="text" class="form-control" name="test_series[{{ $index }}][en]" value="{{ $test_serie['en'] ?? 'N/A' }}" required placeholder="Enter Test Series Detail">
                                        </div>
                                        <div class="col-sm-5 my-1 my-sm-0">
                                            <input type="text" class="form-control" name="test_series[{{ $index }}][hi]" value="{{ $test_serie['hi'] ?? 'N/A' }}" required placeholder="टेस्ट सीरीज विवरण दर्ज करें">
                                        </div>
                                        <div class="col-sm-2 my-1 my-sm-0">
                                            @if ($index == 0)
                                                <button type="button" class="btn btn-success add-test_series">+</button>
                                            @else 
                                                <button type="button" class="btn btn-danger remove-test_series">-</button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row mb-2">
                                    <div class="col-sm-5 my-1 my-sm-0">
                                        <input type="text" class="form-control" name="test_series[0][en]" required placeholder="Enter Test Series Detail">
                                    </div>
                                    <div class="col-sm-5 my-1 my-sm-0">
                                        <input type="text" class="form-control" name="test_series[0][hi]" required placeholder="टेस्ट सीरीज विवरण दर्ज करें">
                                    </div>
                                    <div class="col-sm-2 my-1 my-sm-0">
                                        <button type="button" class="btn btn-success add-test_series">+</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-12" style="margin-top: 2%;">
                        <label>Eligibility Criteria for Admission <span class="text-danger">*</span></label> 
                        <div id="criteria_Fields">
                            @if (!empty($criterias))
                                @foreach ($criterias as $index => $criteria)
                                    <div class="row mb-2">
                                        <div class="col-sm-5 my-1 my-sm-0">
                                            <input type="text" class="form-control" name="criteria[{{ $index }}][en]" value="{{ $criteria['en'] }}" required placeholder="Enter Eligibility Criteria for Admission">
                                        </div>
                                        <div class="col-sm-5 my-1 my-sm-0">
                                            <input type="text" class="form-control" name="criteria[{{ $index }}][hi]" value="{{ $criteria['hi'] }}" required placeholder="प्रवेश के लिए पात्रता मानदंड दर्ज करें">
                                        </div>
                                        <div class="col-sm-2 my-1 my-sm-0">
                                            @if ($index == 0)
                                                <button type="button" class="btn btn-success add-criteria">+</button>
                                            @else 
                                                <button type="button" class="btn btn-danger remove-criteria">-</button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row mb-2">
                                    <div class="col-sm-5 my-1 my-sm-0">
                                        <input type="text" class="form-control" name="criteria[0][en]" required placeholder="Enter Eligibility Criteria for Admission">
                                    </div>
                                    <div class="col-sm-5 my-1 my-sm-0">
                                        <input type="text" class="form-control" name="criteria[0][hi]" required placeholder="प्रवेश के लिए पात्रता मानदंड दर्ज करें">
                                    </div>
                                    <div class="col-sm-2 my-1 my-sm-0">
                                        <button type="button" class="btn btn-success add-criteria">+</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

    
                    <div class="col-sm-2 my-1 my-sm-0" style="margin-top: 2%;">
                        <input type="submit" class="btn btn-primary " value="Update">
                    </div>
                

                {{-- <div class="col-12" style="margin-top: 2%;">
                    <label>Why Choose Us <span class="text-danger">*</span></label> 
                    <div id="courseDetails">
                        @if (!empty($whyJoinUs))
                            @foreach ($whyJoinUs as $index => $whyJoinU)
                                <div class="row mb-2">
                                    <div class="col-sm-5 my-1 my-sm-0">
                                        <input type="text" class="form-control" name="key[]" placeholder="Enter Key"
                                            value="{{ $whyJoinU['key'] }}">
                                    </div>
                                    <div class="col-sm-5 my-1 my-sm-0">
                                        <input type="text" class="form-control" name="value[]" placeholder="Enter Value"
                                            value="{{ $whyJoinU['value'] }}">
                                    </div>
                                    <div class="col-sm-2 my-1 my-sm-0">
                                        @if ($index == 0)
                                            <button type="button" class="btn btn-success add-row">+</button>
                                        @else
                                            <button type="button" class="btn btn-danger remove-row">-</button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row mb-2">
                                <div class="col-sm-5 my-1 my-sm-0">
                                    <input type="text" class="form-control" name="key[]" placeholder="Enter Key">
                                </div>
                                <div class="col-sm-5 my-1 my-sm-0">
                                    <input type="text" class="form-control" name="value[]" placeholder="Enter Value">
                                </div>
                                <div class="col-sm-2 my-1 my-sm-0">
                                    <button type="button" class="btn btn-success add-row">+</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div> --}}

             


            </form>

        </div>
        <br>

    </div>

@endsection
@push('js')
<script>
    $(document).ready(function() {
        $('.editor').each(function() {
            new Jodit(this, {
                height: 300, // Adjust the editor height
                toolbarSticky: false, // Toolbar will not stick on scroll
                defaultMode: "1", // Start in WYSIWYG mode
                uploader: {
                    insertImageAsBase64URI: true // Allows direct image uploads
                }
            });
        });
    });
</script>




	<script>
		$(document).ready(function () {
			$(document).on("click", ".add-tag", function () {
				let tagField = `<div class="row mb-2">
					<div class="col-10">
						<input type="text" class="form-control" name="programs[]" required placeholder="Enter Program Detail">
					</div>
					<div class="col-2">
						<button type="button" class="btn btn-danger remove-tag">-</button>
					</div>
				</div>`;
				$("#tagFields").append(tagField);
			});
			$(document).on("click", ".remove-tag", function () {
				$(this).closest(".row").remove();
			});

            // Why Join Us Script Start
            $(document).on("click", ".add-join", function () {
                let index = $("#join_us_Fields .row").length;  // Get current row count
                let tagField = `<div class="row mb-2">
                    <div class="col-5">
                        <input type="text" class="form-control" name="why_join_us[${index}][en]" required placeholder="Enter Join Us Detail (In English)">
                    </div>
                    <div class="col-5">
                        <input type="text" class="form-control" name="why_join_us[${index}][hi]" required placeholder="हमसे जुड़ें विवरण दर्ज करें (हिंदी में)">
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-danger remove-join">-</button>
                    </div>
                </div>`;
                $("#join_us_Fields").append(tagField);
            });
            $(document).on("click", ".remove-join", function () {
                $(this).closest(".row").remove();
            });
            // Why Join Us Script End

             // Program Includes  Script Start
            $(document).on("click", ".add-program", function () {
                let index = $("#program_Fields .row").length;  
                let tagField = `<div class="row mb-2">
                    <div class="col-5">
                        <input type="text" class="form-control" name="programs[${index}][en]" required placeholder="Enter Program (In English)">
                    </div>
                    <div class="col-5">
                        <input type="text" class="form-control" name="programs[${index}][hi]" required placeholder="प्रोग्राम दर्ज करें(हिंदी में)">
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-danger remove-program">-</button>
                    </div>
                </div>`;
                $("#program_Fields").append(tagField);
            });
            $(document).on("click", ".remove-program", function () {
                $(this).closest(".row").remove();
            });
             // Program Includes  Script End



            $(document).on("click", ".add-preparation", function () {
				let tagField = `<div class="row mb-2">
					<div class="col-10">
                        <input type="text" class="form-control" name="preparation_plans[]" required placeholder="Enter Preparation Plans Detail">
					</div>
					<div class="col-2">
						<button type="button" class="btn btn-danger remove-preparation">-</button>
					</div>
				</div>`;
				$("#preparation_plans_Fields").append(tagField);
			});
			$(document).on("click", ".remove-preparation", function () {
				$(this).closest(".row").remove();
			});


            // Mains Answer Writing & Test Series  Script Start
            $(document).on("click", ".add-test_series", function () {
                let index = $("#test_series_Fields .row").length; 
                let tagField = `<div class="row mb-2">
                    <div class="col-5">
                        <input type="text" class="form-control" name="test_series[${index}][en]" required placeholder="Enter Test Series Detail">
                    </div>
                    <div class="col-5">
                        <input type="text" class="form-control" name="test_series[${index}][hi]" required placeholder="टेस्ट सीरीज विवरण दर्ज करें">
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-danger remove-test_series">-</button>
                    </div>
                </div>`;
                $("#test_series_Fields").append(tagField);
            });
            $(document).on("click", ".remove-test_series", function () {
                $(this).closest(".row").remove();
            });
            // Mains Answer Writing & Test Series  Script End

            // Eligibility Criteria for Admission Script Start
            $(document).on("click", ".add-criteria", function () {
                let index = $("#criteria_Fields .row").length; 
                let tagField = `<div class="row mb-2">
                    <div class="col-5">
                        <input type="text" class="form-control" name="criteria[${index}][en]" required placeholder="Enter Eligibility Criteria for Admission">
                    </div>
                    <div class="col-5">
                        <input type="text" class="form-control" name="criteria[${index}][hi]" required placeholder="प्रवेश के लिए पात्रता मानदंड दर्ज करें">
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-danger remove-criteria">-</button>
                    </div>
                </div>`;
                $("#criteria_Fields").append(tagField);
            });
            $(document).on("click", ".remove-criteria", function () {
                $(this).closest(".row").remove();
            });
             // Eligibility Criteria for Admission  Script End
		});
	</script>
@endpush
