<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index()
    {
        return response()->json(Course::all(), 200);
    }

    public function assign(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,user_id',
            'course_id' => 'required|exists:course,course_id',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $userId = $request->user_id;
        $courseId = $request->course_id;

        // Use DB transaction to avoid duplicate entries
        DB::beginTransaction();

        try {
            $user = User::findOrFail($userId);
            $course = Course::findOrFail($courseId);

            // Attach the course to the user (enroll)
            $user->courses()->attach($courseId);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User successfully enrolled in the course.',
                'data' => [
                    'user_id' => $userId,
                    'course_id' => $courseId,
                ],
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to enroll user in the course.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $course = Course::create($validated);
        return response()->json($course, 201);
    }

    public function show($id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        return response()->json($course);
    }

    public function updateCourseProgress(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users',
            'course_id' => 'required|exists:course',
        ]);

        $course = Course::find($validated['course_id']);
        // Count completed lessons for the course
        $completedLessons = $course->lessons()
            ->where('progress', 100)
            ->count();

        // Get total lessons for the course
        $totalLessons = $course->lessons()->count();

        // Calculate progress percentage
        $progress = $totalLessons > 0
            ? round(($completedLessons / $totalLessons) * 100, 2)
            : 0;

        // Update course progress
        $user = User::find($validated['user_id']);
        $user->courses()->updateExistingPivot($validated['course_id'], [
            'progress' => $progress,
            'updated_at' => now() // Update the timestamp
        ]);

        return response()->json([
            'message' => 'Course progress updated',
            'course' => $course
        ]);
    }

    public function getCourseRanking($courseId)
    {
        $rankings = DB::table('usercourse')
            ->select([
                'users.user_id',
                'users.name',
                'usercourse.totalscore',
                DB::raw('DENSE_RANK() OVER (ORDER BY usercourse.totalscore DESC) as rank')
            ])
            ->join('users', 'usercourse.user_id', '=', 'users.user_id')
            ->where('course_id', $courseId)
            ->where('users.role', 'student')
            ->orderBy('rank')
            ->get();

        return response()->json($rankings);
    }

    public function showAll($id)
    {
        // Retrieve the course with its lessons and lessonsPages
        $course = Course::with(['lessons.lessonpage'])->findOrFail($id);

        // Optionally, if you want to order lessons and lessonsPages
        $course->setRelation(
            'lessons',
            $course->lessons()
            ->with('lessonpage')
            ->orderBy('lessons_id', 'desc')
            ->get()
        );

        // Load the count of lessons if needed
        $course->loadCount('lessons');

        return response()->json($course);
    }

    public function update(Request $request, $id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
        ]);

        $course->update($validated);
        return response()->json($course);
    }

    public function destroy($id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $course->delete();
        return response()->json(['message' => 'Course deleted successfully']);
    }
}
