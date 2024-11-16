<!DOCTYPE html>
<html>
<head>
    <title>Quiz</title>
</head>
<body>
    <h1>Quiz</h1>
    <form action="/submit" method="POST">
        @csrf
        <label for="name">Your Name:</label>
        <input type="text" name="name" required>

        @foreach ($questions as $question)
            <div>
                <h3>{{ $question->question_text }}</h3>
                @foreach ($question->answers as $answer)
                    <div>
                        <input type="radio" name="question_{{ $question->id }}" value="{{ $answer->id }}">
                        <label>{{ $answer->answer_text }}</label>
                    </div>
                @endforeach
            </div>
        @endforeach

        <button type="submit">Submit</button>
    </form>
</body>
</html>
