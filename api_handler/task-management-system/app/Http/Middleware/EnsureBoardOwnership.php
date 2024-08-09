<?php

// In app/Http/Middleware/EnsureBoardOwnership.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Board;

class EnsureBoardOwnership
{
    public function handle(Request $request, Closure $next)
    {
        $board = Board::find($request->route('board'));

        if (!$board || $board->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
