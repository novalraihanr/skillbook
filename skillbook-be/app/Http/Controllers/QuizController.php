<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;

class QuizController extends Controller
{
    public function index()
    {
        return response()->json(Quiz::with('lesson')->get(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lessons_id' => 'required|exists:lessons,lessons_id',
            'question' => 'required|string',
            'answer_a' => 'required|string',
            'answer_b' => 'required|string',
            'answer_c' => 'required|string',
            'answer_d' => 'required|string',
            'score' => 'required|integer',
            'correct_ans' => 'required|string|in:A,B,C,D',
        ]);

        $quiz = Quiz::create($validated);
        return response()->json($quiz, 201);
    }

    public function show($id)
    {
        $quiz = Quiz::with('lesson')->find($id);

        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        return response()->json($quiz);
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::find($id);

        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        $validated = $request->validate([
            'lessons_id' => 'sometimes|required|exists:lessons,lessons_id',
            'question' => 'sometimes|required|string',
            'answer_a' => 'sometimes|required|string',
            'answer_b' => 'sometimes|required|string',
            'answer_c' => 'sometimes|required|string',
            'answer_d' => 'sometimes|required|string',
            'score' => 'sometimes|required|integer',
            'correct_ans' => 'sometimes|required|string|in:A,B,C,D',
        ]);

        $quiz->update($validated);
        return response()->json($quiz);
    }

    public function destroy($id)
    {
        $quiz = Quiz::find($id);

        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        $quiz->delete();
        return response()->json(['message' => 'Quiz deleted successfully']);
    }
}
