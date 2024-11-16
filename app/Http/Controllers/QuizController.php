<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Result;
use App\Models\User;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    // Step 1: Show the Name Form
    public function showNameForm()
    {
        return view('quiz.name');
    }

    // Step 2: Initialize Quiz Session
    public function startQuiz(Request $request)
    {
        $user = User::firstOrCreate(['name' => $request->name]);
        session(['user_id' => $user->id]);

        // Get randomized question IDs
        $questions = Question::pluck('id')->shuffle();
        session(['questions' => $questions, 'current_index' => 0]);

        return response()->json(['success' => true]);
    }

    // Step 3: Fetch Next Question
    public function getQuestion()
    {
        $questions = session('questions');
        $currentIndex = session('current_index');
        $userId = session('user_id');
        // Check if the quiz is over
        if ($currentIndex >= count($questions)) {
            return response()->json(['quiz_completed' => true, 'user_id' => $userId,]);
        }

        $questionId = $questions[$currentIndex];
        $question = Question::with('answers')->find($questionId);

        return response()->json(['quiz_completed' => false, 'question' => $question]);
    }

    // Step 4: Submit Answer
    public function submitAnswer(Request $request)
    {
        $userId = session('user_id');
        $questionId = $request->question_id;
        $answerId = $request->answer;
        
        $isCorrect = Answer::where('question_id', $questionId)
                   ->where('id', $answerId)
                   ->where('is_correct', 1) 
                   ->value('is_correct');

        if ($isCorrect === null) {
            $isCorrect = false;
        }
       
        Result::create([
            'user_id' => $userId,
            'question_id' => $questionId,
            'answer_id' => $answerId,
            'is_correct' => $isCorrect,
        ]);

        // Increment current index
        session(['current_index' => session('current_index') + 1]);

        return response()->json(['success' => true]);
    }

    // Step 5: Show Results
    public function results($userId)
    {
        $results = Result::where('user_id', $userId)
            ->selectRaw('SUM(is_correct) as correct, COUNT(*) - SUM(is_correct) as wrong')
            ->first();

        return view('quiz.results', compact('results'));
    }
}


