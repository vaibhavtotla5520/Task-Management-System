<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Board $board)
    {
        // Ensure the board belongs to the authenticated user
        if ($board->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($board->tasks);
    }

    public function store(Request $request, Board $board)
    {
        return json_encode('Hi');
        // Ensure the board belongs to the authenticated user
        if ($board->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);


        $task = $board->tasks()->create($validated);

        return response()->json($task, 201);
    }

    public function show(Board $board, Task $task)
    {
        // Ensure the task belongs to the board and user
        if ($board->user_id !== auth()->id() || $task->board_id !== $board->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($task);
    }

    public function update(Request $request, Board $board, Task $task)
    {
        // Ensure the task belongs to the board and user
        if ($board->user_id !== auth()->id() || $task->board_id !== $board->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task->update($validated);

        return response()->json($task);
    }

    public function destroy(Board $board, Task $task)
    {
        // Ensure the task belongs to the board and user
        if ($board->user_id !== auth()->id() || $task->board_id !== $board->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $task->delete();

        return response()->json(null, 204);
    }
}
