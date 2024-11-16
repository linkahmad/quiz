<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Answer;

class QuizSeeder extends Seeder
{
    public function run()
    {
        $questions = [
            [
                'text' => 'What is Laravel?',
                'category' => 'Laravel',
                'answers' => [
                    ['text' => 'A framework', 'correct' => true],
                    ['text' => 'A CMS', 'correct' => false],
                    ['text' => 'A database', 'correct' => false],
                    ['text' => 'A library', 'correct' => false],
                ],
            ],
            [
                'text' => 'What does HTML stand for?',
                'category' => 'HTML',
                'answers' => [
                    ['text' => 'HyperText Markup Language', 'correct' => true],
                    ['text' => 'Hyper Transfer Machine Language', 'correct' => false],
                    ['text' => 'Hyper Tool Machine Language', 'correct' => false],
                    ['text' => 'Home Text Markup Language', 'correct' => false],
                ],
            ],
            [
                'text' => 'What is PHP used for?',
                'category' => 'PHP',
                'answers' => [
                    ['text' => 'Web development', 'correct' => true],
                    ['text' => 'Data analysis', 'correct' => false],
                    ['text' => 'Machine learning', 'correct' => false],
                    ['text' => 'Mobile app development', 'correct' => false],
                ],
            ],
           
            [
                'text' => 'What is the default file extension for a PHP file?',
                'category' => 'PHP',
                'answers' => [
                    ['text' => '.php', 'correct' => true],
                    ['text' => '.html', 'correct' => false],
                    ['text' => '.js', 'correct' => false],
                    ['text' => '.css', 'correct' => false],
                ],
            ],
            [
                'text' => 'Which database does Laravel use by default?',
                'category' => 'Laravel',
                'answers' => [
                    ['text' => 'MySQL', 'correct' => true],
                    ['text' => 'PostgreSQL', 'correct' => false],
                    ['text' => 'SQLite', 'correct' => false],
                    ['text' => 'Oracle', 'correct' => false],
                ],
            ],
        ];

        foreach ($questions as $question) {
            $newQuestion = Question::create([
                'question_text' => $question['text'],
                'category' => $question['category'],
            ]);

            foreach ($question['answers'] as $answer) {
                Answer::create([
                    'question_id' => $newQuestion->id,
                    'answer_text' => $answer['text'],
                    'is_correct' => $answer['correct'],
                ]);
            }
        }
    }
}
