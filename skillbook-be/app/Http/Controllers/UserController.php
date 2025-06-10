<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    public function rankStudentsWithTies()
    {
        $user = DB::table('users')
            ->select([
                'users.user_id',
                'users.name',
                'users.role',
                DB::raw('SUM(usercourse.total_score) as totalscore'),
                DB::raw('DENSE_RANK() OVER (ORDER BY SUM(usercourse.totalscore) DESC) as rank')
            ])
            ->join('usercourse', 'users.user_id', '=', 'usercourse.user_id')
            ->where('users.role', 'student')
            ->groupBy('users.user_id', 'users.name')
            ->orderBy('rank', 'ASC')
            ->get();

        return $user;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        return response()->json($user, 201);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        $user->loadCount('courses');

        $user->setRelation('courses', $user->courses()->where('progress', '<', 100)->limit(2)->get());

        return response()->json($user);
    }

    public function showAll($id)
    {
        $user = User::findOrFail($id);

        $user->loadCount('courses');

        $user->setRelation('courses', $user->courses()->where('progress', '<', 100)->get());

        return response()->json($user);
    }

    public function updateUserCourseScore(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users',
            'course_id' => 'required|exists:course',
            'total_score' => 'required'
        ]);

        // Get the current score from the pivot table
        $currentScore = DB::table('usercourse')
            ->where('user_id', $validated['user_id'])
            ->where('course_id', $validated['course_id'])
            ->value('totalscore') ?? 0; // Default to 0 if no score exists

        // Calculate the new total score
        $newTotalScore = $currentScore + $validated['total_score'];

        // Update the pivot table with the new total
        $user = User::find($validated['user_id']);
        $user->courses()->updateExistingPivot($validated['course_id'], [
            'totalscore' => $newTotalScore,
            'updated_at' => now() // Update the timestamp
        ]);

        return response()->json([
            'message' => 'Score updated successfully',
            'previous_score' => $currentScore,
            'new_total_score' => $newTotalScore
        ]);
    }


    public function showAllCompleted($id)
    {
        $user = User::findOrFail($id);

        // Count only completed courses
        $user->loadCount(['courses' => function ($query) {
            $query->where('progress', 100);
        }]);

        // Get only 2 most recent completed courses
        $user->setRelation('courses', $user->courses()
            ->where('progress', 100)
            ->get());

        return response()->json($user);
    }

    public function showCompleted($id)
    {
        $user = User::findOrFail($id);

        // Count only completed courses
        $user->loadCount(['courses' => function ($query) {
            $query->where('progress', 100);
        }]);

        // Get only 2 most recent completed courses
        $user->setRelation('courses', $user->courses()
            ->where('progress', 100)
            ->limit(2)
            ->get());

        return response()->json($user);
    }


    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $id . ',user_id',
            'role' => 'sometimes|required|string',
            'password' => 'sometimes|required|string|min:6',
            'score' => 'nullable|integer',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $user->update($validated);

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
