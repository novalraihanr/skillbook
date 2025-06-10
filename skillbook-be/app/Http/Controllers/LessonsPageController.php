<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LessonsPage;

class LessonsPageController extends Controller
{
    public function index()
    {
        return response()->json(Lessonspage::with('lesson')->get(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lessons_id' => 'required|exists:lessons,lessons_id',
            'content_1' => 'required|string',
            'code_1' => 'nullable|string',
            'content_2' => 'nullable|string',
            'code_2' => 'nullable|string',
        ]);

        $page = Lessonspage::create($validated);
        return response()->json($page, 201);
    }

    public function show($id)
    {
        $page = Lessonspage::with('lesson')->find($id);

        if (!$page) {
            return response()->json(['message' => 'Lessonspage not found'], 404);
        }

        return response()->json($page);
    }

    public function update(Request $request, $id)
    {
        $page = Lessonspage::find($id);

        if (!$page) {
            return response()->json(['message' => 'Lessonspage not found'], 404);
        }

        $validated = $request->validate([
            'lessons_id' => 'sometimes|required|exists:lessons,lessons_id',
            'content_1' => 'sometimes|required|string',
            'code_1' => 'nullable|string',
            'content_2' => 'nullable|string',
            'code_2' => 'nullable|string',
        ]);

        $page->update($validated);
        return response()->json($page);
    }

    public function destroy($id)
    {
        $page = Lessonspage::find($id);

        if (!$page) {
            return response()->json(['message' => 'Lessonspage not found'], 404);
        }

        $page->delete();
        return response()->json(['message' => 'Lessonspage deleted successfully']);
    }
}
