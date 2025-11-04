let questions = [];
let currentQuestionIndex = 0;
let answeredQuestions = [];

// Get the current test_series_id dynamically (Assuming this is set in your Blade file)
let currentTestSeriesId = testSeriesId; // Ensure this is defined in your Blade template

// Retrieve last question index for this specific test_series_id
if (localStorage.getItem(`currentQuestionIndex_${currentTestSeriesId}`)) {
    currentQuestionIndex = parseInt(localStorage.getItem(`currentQuestionIndex_${currentTestSeriesId}`), 10);
    console.log(`Retrieved currentQuestionIndex for Test Series ${currentTestSeriesId}:`, currentQuestionIndex);
} else {
    console.log(`No previous question index found for Test Series ${currentTestSeriesId}, starting from 0.`);
}

// Retrieve answered questions for this specific test_series_id
if (localStorage.getItem(`answeredQuestions_${currentTestSeriesId}`)) {
    answeredQuestions = JSON.parse(localStorage.getItem(`answeredQuestions_${currentTestSeriesId}`));
    console.log(`Retrieved answeredQuestions for Test Series ${currentTestSeriesId}:`, answeredQuestions);
} else {
    answeredQuestions = [];
}

function loadQuestion(index) {
    if (index < questions.length) {
        console.log(`Loading Question ${index + 1} / ${questions.length} for Test Series ${currentTestSeriesId}`);

        $("#question-number").text(index + 1);
        $("#question-text").text(questions[index].name);
        console.log("Question Text:", questions[index].name);
        console.log("Test Series:", questions[index].test_series_id);

        // Render options
        let optionsHtml = "";
        if (questions[index].options) {
            let options = JSON.parse(questions[index].options);
            Object.entries(options).forEach(([key, option]) => {
                optionsHtml += `
                    <label class="label-option">
                        <input type="radio" name="answer" value="${key}"> ${option}
                    </label>
                `;
            });
        }
        $("#options-container").html(optionsHtml);

        // Save the current index for this specific test_series_id
        localStorage.setItem(`currentQuestionIndex_${currentTestSeriesId}`, index);
        console.log(`Updated currentQuestionIndex for Test Series ${currentTestSeriesId} in localStorage:`, index);

        // Highlight answered questions
        highlightAnsweredQuestions();

        // Show/Hide buttons
        $("#saveNext").show();
        $("#submitQuiz").hide();
        if (index === questions.length - 1) {
            $("#saveNext").hide();
            $("#submitQuiz").show();
        }
    } else {
        console.log("Invalid index. No question found.");
    }
}

function highlightAnsweredQuestions() {
    console.log("Answered Questions Array:", answeredQuestions); 
    $(".question-btn").removeClass("answered"); // Reset all
    answeredQuestions.forEach(qID => {
        console.log("Adding answered class on Question No:", qID);
        $(".question-btn[data-q='" + qID + "']").addClass("answered"); // Mark answered
    });
    console.log("highlightAnsweredQuestions function executed!");
}

$(document).ready(function () {
    if (typeof testSeriesQuestions !== "undefined") {
        questions = testSeriesQuestions;
        console.log(`Questions Loaded for Test Series ${currentTestSeriesId}:`, questions.length);
    } else {
        console.error("No test series questions found.");
    }

    loadQuestion(currentQuestionIndex);

    $("#saveNext").on("click", function () {
        let selectedAnswer = $("input[name='answer']:checked").val();    
        if (!selectedAnswer) {
            alert("Please select an option.");
            return;
        }
    
        // Call saveAnswer and move to next question only after saving
        saveAnswer(function () {
            let currentQuestionId = questions[currentQuestionIndex].id;
    
            // Push answered question index (1-based) if not already there
            if (!answeredQuestions.includes(currentQuestionIndex + 1)) {
                answeredQuestions.push(currentQuestionIndex + 1);
            }
    
            console.log("Answered Questions Array after Save & Next:", answeredQuestions);
    
            // Highlight answered questions
            highlightAnsweredQuestions();
    
            // Load next question
            currentQuestionIndex++;
            loadQuestion(currentQuestionIndex);
        });
    });
    

    $("#submitQuiz").click(function () {
        saveAnswer(function () {
            console.log("Quiz submitted. Clearing localStorage.");
            localStorage.removeItem(`currentQuestionIndex_${currentTestSeriesId}`);
            localStorage.removeItem(`answeredQuestions_${currentTestSeriesId}`);
            window.location.href = submitTestRoute;
        });
    });

    function saveAnswer(callback) {
        let selectedAnswer = $("input[name='answer']:checked").val();
        if (!selectedAnswer) {
            alert("Please select an answer before proceeding!");
            return;
        }

        let questionID = questions[currentQuestionIndex].id;
        let testSeriesID = questions[currentQuestionIndex].test_series_id;
        console.log("Saving Answer:", selectedAnswer, "for Question ID:", questionID, "Test Series ID:", testSeriesID);

        $.ajax({
            url: saveAnswerRoute,
            method: "POST",
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                question_id: questionID,
                test_series_id: testSeriesID,
                answer: selectedAnswer
            },
            success: function (response) {
                console.log("Answer saved successfully:", response.message);

                // Mark the question as answered
                if (!answeredQuestions.includes(questionID)) {
                    answeredQuestions.push(questionID);
                    localStorage.setItem(`answeredQuestions_${currentTestSeriesId}`, JSON.stringify(answeredQuestions));
                }

                highlightAnsweredQuestions();

                if (callback) {
                    callback();
                }
            },
            error: function (xhr, status, error) {
                console.error("Error saving answer:", error);
            }
        });
    }

    $(".question-btn").click(function () {
        let questionIndex = $(this).data("q") - 1;
        console.log(`Navigating to selected question for Test Series ${currentTestSeriesId}:`, questionIndex);
        currentQuestionIndex = questionIndex;
        loadQuestion(currentQuestionIndex);
    });

    highlightAnsweredQuestions();
});




$(document).ready(function () {
    let duration = testDuration; // Blade se duration le rahe hain
    let timerDisplay = document.getElementById("timerDisplay");
    let submitButton = document.getElementById("submitQuiz");

    // Get current test_series_id dynamically
    let currentTestSeriesId = testSeriesId; // Ensure this is defined in your Blade template

    let timerKey = `quizEndTime_${currentTestSeriesId}`;

    if (localStorage.getItem(timerKey)) {
        let endTime = parseInt(localStorage.getItem(timerKey));
        let currentTime = Math.floor(Date.now() / 1000);
        duration = Math.max(0, endTime - currentTime);
    } else {
        let endTime = Math.floor(Date.now() / 1000) + duration;
        localStorage.setItem(timerKey, endTime);
    }

    function updateTimer() {
        let minutes = Math.floor(duration / 60);
        let seconds = duration % 60;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        timerDisplay.textContent = minutes + ":" + seconds + " Minutes Left";

        if (duration < 120) {
            timerDisplay.style.color = "red";
            timerDisplay.classList.add("blink");
        } else {
            timerDisplay.style.color = "black";
            timerDisplay.classList.remove("blink");
        }

        if (duration <= 0) {
            clearInterval(timerInterval);
            localStorage.removeItem(timerKey);
            localStorage.removeItem(`currentQuestionIndex_${currentTestSeriesId}`);
            localStorage.removeItem(`answeredQuestions_${currentTestSeriesId}`);
            console.log("Storage Cleared. Logging out...");

            // Automatically logout when time is up
            $.ajax({
                url: autoLogout,
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content")
                },
                success: function () {
                    window.location.href = studentLogin;
                }
            });
        } else {
            duration--;
        }
    }

    let timerInterval = setInterval(updateTimer, 1000);
    updateTimer();

    // Stop timer & clear storage when clicking "Submit Test"
    $(submitButton).on("click", function () {
        clearInterval(timerInterval);
        localStorage.removeItem(timerKey);
    });
});





