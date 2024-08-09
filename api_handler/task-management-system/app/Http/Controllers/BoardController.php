<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Task;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function index()
    {
        // Get boards that belong to the authenticated user
        $boards = Board::where('user_id', auth()->id())->with('tasks')->get();
        
        return response()->json($boards);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $board = Board::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'user_id' => auth()->id(),
        ]);

        return response()->json($board, 201);
    }

    public function show(Board $board)
    {
        // Ensure the board belongs to the authenticated user
        if ($board->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($board->load('tasks'));
    }

    public function update(Request $request, Board $board)
    {
        // Ensure the board belongs to the authenticated user
        if ($board->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $board->update($validated);

        return response()->json($board);
    }

    public function destroy(Board $board)
    {
        // Ensure the board belongs to the authenticated user
        if ($board->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $board->delete();

        return response()->json(null, 204);
    }
}
