<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lessons;
use App\Models\Quiz;
use App\Models\LessonsPage;
use Illuminate\Support\Facades\DB;

class LessonsController extends Controller
{
    public function index()
    {
        return response()->json(Lessons::with('course')->get(), 200);
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'lesson.course_id' => 'required|exists:course,course_id',
            'lesson.title' => 'required|string|max:255',
            'lesson.progress' => 'nullable|integer|min:0|max:100',
            'lesson.lastaccessedpage' => 'nullable|integer|min:1',
            'lesson.lastaccessedquiz' => 'nullable|integer|min:1',

            'lesson_pages' => 'required|array|min:1',
            'lesson_pages.*.page' => 'required|integer|min:1',
            'lesson_pages.*.content_1' => 'required|string',
            'lesson_pages.*.code_1' => 'nullable|string',
            'lesson_pages.*.content_2' => 'nullable|string',
            'lesson_pages.*.code_2' => 'nullable|string',

            'quizzes' => 'required|array|min:1',
            'quizzes.*.page' => 'required|integer|min:1',
            'quizzes.*.question' => 'required|string',
            'quizzes.*.answer_a' => 'required|string',
            'quizzes.*.answer_b' => 'required|string',
            'quizzes.*.answer_c' => 'required|string',
            'quizzes.*.answer_d' => 'required|string',
            'quizzes.*.correct_ans' => 'required|string|max:255',
            'quizzes.*.score' => 'required|integer|min:1|max:100',
        ]);

        try {
            // Start database transaction
            DB::beginTransaction();

            // Create the lesson
            $lesson = Lessons::create([
                'course_id' => $validated['lesson']['course_id'],
                'title' => $validated['lesson']['title'],
                'progress' => $validated['lesson']['progress'] ?? 0,
                'lastaccessedpage' => $validated['lesson']['lastaccessedpage'] ?? 1,
                'lastaccessedquiz' => $validated['lesson']['lastaccessedquiz'] ?? 1,
            ]);

            // Create lesson pages
            foreach ($validated['lesson_pages'] as $pageData) {
                LessonsPage::create([
                    'lessons_id' => $lesson->lessons_id,
                    'page' => $pageData['page'],
                    'content_1' => $pageData['content_1'],
                    'code_1' => $pageData['code_1'] ?? null,
                    'content_2' => $pageData['content_2'] ?? null,
                    'code_2' => $pageData['code_2'] ?? null,
                ]);
            }

            // Create quizzes
            foreach ($validated['quizzes'] as $quizData) {
                Quiz::create([
                    'lessons_id' => $lesson->lessons_id,
                    'page' => $quizData['page'],
                    'question' => $quizData['question'],
                    'answer_a' => $quizData['answer_a'],
                    'answer_b' => $quizData['answer_b'],
                    'answer_c' => $quizData['answer_c'],
                    'answer_d' => $quizData['answer_d'],
                    'correct_ans' => $quizData['correct_ans'],
                    'score' => $quizData['score'],
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Return success response with created lesson and its relationships
            return response()->json([
                'success' => true,
                'message' => 'Lesson created successfully',
                'data' => [
                    'lesson' => $lesson->load(['lessonpage', 'quiz', 'course'])
                ]
            ], 201);

        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create lesson. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    public function show($id)
    {
        $lesson = Lessons::with('course')->find($id);
        if (!$lesson) {
            return response()->json(['message' => 'Lessons not found'], 404);
        }

        return response()->json($lesson);
    }

    public function getPages($id)
    {

        $lesson = Lessons::with('lessonpage')->find($id);

        if (!$lesson) {
            return response()->json(['message' => 'Lessons not found'], 404);
        }

        $currentPage = $lesson->lessonpage
            ->where('page', $lesson->lastaccessedpage)
            ->first();

        return response()->json([
            'lesson' => $lesson,
            'current_page' => $currentPage,
            'total_pages' => $lesson->lessonpage->count()  // Add total pages count
        ]);
    }

    public function getQuiz($id)
    {

        $lesson = Lessons::with('quiz')->find($id);

        if (!$lesson) {
            return response()->json(['message' => 'Lessons not found'], 404);
        }

        $currentPage = $lesson->quiz
            ->where('page', $lesson->lastaccessedquiz)
            ->first();

        return response()->json([
            'lesson' => $lesson,
            'current_page' => $currentPage,
            'total_pages' => $lesson->quiz->count()  // Add total pages count
        ]);
    }

    public function updateQuizPage(Request $request, $id)
    {
        $lesson = Lessons::find($id);
        if (!$lesson) {
            return response()->json(['message' => 'Lessons not found'], 404);
        }


        $validated = $request->validate([
            'lastaccessedquiz' => 'required',
        ]);

        // Get total pages for this lesson
        $totalPages = $lesson->quiz()->count();

        if ($totalPages === 0) {
            return response()->json(['message' => 'No pages found for this lesson'], 404);
        }

        // Ensure lastaccessedpage doesn't exceed total pages
        $lastAccessedPage = min($validated['lastaccessedquiz'], $totalPages);

        // Update lesson with calculated progress and last accessed page
        $lesson->update([
            'lastaccessedquiz' => $lastAccessedPage,
        ]);

        return response()->json([
            'lesson' => $lesson,
            'total_pages' => $totalPages,
        ]);
    }

    public function update(Request $request, $id)
    {
        $lesson = Lessons::find($id);
        if (!$lesson) {
            return response()->json(['message' => 'Lessons not found'], 404);
        }

        $validated = $request->validate([
            'course_id' => 'required|exists:courses,course_id',
            'title' => 'required|string|max:255',
            'progress' => 'numeric|min:0|max:100',
            'lastaccessedpage' => 'integer|min:0',
        ]);

        $lesson->update($validated);
        return response()->json($lesson);
    }

    public function updateProgress(Request $request, $id)
    {
        $lesson = Lessons::find($id);
        if (!$lesson) {
            return response()->json(['message' => 'Lessons not found'], 404);
        }


        $validated = $request->validate([
            'lastaccessedpage' => 'required',
        ]);

        // Get total pages for this lesson
        $totalPages = $lesson->lessonpage()->count();

        if ($totalPages === 0) {
            return response()->json(['message' => 'No pages found for this lesson'], 404);
        }

        // Ensure lastaccessedpage doesn't exceed total pages
        $lastAccessedPage = min($validated['lastaccessedpage'], $totalPages);

        // Calculate progress percentage
        $progress = round(($lastAccessedPage / $totalPages) * 100, 2);

        // Update lesson with calculated progress and last accessed page
        $lesson->update([
            'lastaccessedpage' => $lastAccessedPage,
            'progress' => $progress
        ]);

        return response()->json([
            'lesson' => $lesson,
            'total_pages' => $totalPages,
            'calculated_progress' => $progress
        ]);
    }

    public function destroy($id)
    {
        try {
            $lesson = Lessons::findOrFail($id);

            // Delete will cascade to lesson pages and quizzes if foreign keys are set up properly
            $lesson->delete();

            return response()->json([
                'success' => true,
                'message' => 'Lesson deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete lesson'
            ], 500);
        }
    }
}
