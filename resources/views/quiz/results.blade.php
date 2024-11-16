<!DOCTYPE html>
<html>
<head>
    <title>Quiz Results</title>
</head>
<body>
    <h1>Quiz Results</h1>
    <p>Correct Answers: {{ $results->correct }}</p>
    <p>Wrong Answers: {{ $results->wrong }}</p>
    <p>Skipped Answers: {{ $results->skipped }}</p>
</body>
</html>
