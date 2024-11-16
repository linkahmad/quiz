<!DOCTYPE html>
<html>
<head>
    <title>Start Quiz</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Welcome to the Quiz</h1>
    <form id="nameForm">
        <label for="name">Enter Your Name:</label>
        <input type="text" id="name" name="name" required>
        <button type="submit">Start Quiz</button>
    </form>

    <div id="quizContainer" style="display: none;">
        <div id="questionContainer"></div>
        <button id="nextButton" style="display: none;">Next Question</button>
    </div>

    <script>
        $(document).ready(function () {
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Step 1: Start Quiz
            $('#nameForm').on('submit', function (e) {
                e.preventDefault();
                const name = $('#name').val();

                $.ajax({
                    url: '/start-quiz',
                    type: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    data: { name },
                    success: function () {
                        $('#nameForm').hide();
                        $('#quizContainer').show();
                        loadQuestion();
                    },
                });
            });

            // Step 2: Load Question
            function loadQuestion() {
                $.ajax({
                    url: '/get-question',
                    type: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    success: function (response) {
                        if (response.quiz_completed) {
                            window.location.href = `/results/${response.user_id}`;
                            return;
                        }

                        const question = response.question;
                        $('#questionContainer').html(`
                            <h3>${question.question_text}</h3>
                            <form id="answerForm">
                                ${question.answers.map(answer => `
                                    <div>
                                        <input type="radio" name="answer" value="${answer.id}" required>
                                        <label>${answer.answer_text}</label>
                                    </div>
                                `).join('')}
                                <input type="hidden" name="question_id" value="${question.id}">
                                <button type="submit">Submit Answer</button>
                            </form>
                        `);
                    },
                });
            }

            // Step 3: Submit Answer
            $(document).on('submit', '#answerForm', function (e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    url: '/submit-answer',
                    type: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    data: formData,
                    success: function () {
                        loadQuestion();
                    },
                });
            });
        });
    </script>
</body>
</html>
