<?php
// 5. Reaction Controller - app/Http/Controllers/ReactionController.php
namespace App\Http\Controllers;

use App\Models\Reaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ReactionController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'reactable_type' => 'required|string|in:App\Models\Post,App\Models\Comment',
            'reactable_id' => 'required|exists:' . $this->getTableName($request->reactable_type) . ',id',
            'type' => 'required|in:like,love,laugh,angry,sad'
        ]);

        $userId = auth()->id();
        $reactableType = $request->reactable_type;
        $reactableId = $request->reactable_id;
        $type = $request->type;

        // Find existing reaction
        $existingReaction = Reaction::where([
            'user_id' => $userId,
            'reactable_type' => $reactableType,
            'reactable_id' => $reactableId,
        ])->first();

        if ($existingReaction) {
            if ($existingReaction->type === $type) {
                // Same reaction - remove it
                $existingReaction->delete();
                $action = 'removed';
            } else {
                // Different reaction - update it
                $existingReaction->update(['type' => $type]);
                $action = 'updated';
            }
        } else {
            // New reaction
            Reaction::create([
                'user_id' => $userId,
                'reactable_type' => $reactableType,
                'reactable_id' => $reactableId,
                'type' => $type,
            ]);
            $action = 'added';
        }

        // Get updated counts
        $reactable = $reactableType::find($reactableId);
        
        return response()->json([
            'success' => true,
            'action' => $action,
            'reaction_counts' => $reactable->reaction_counts,
            'total_reactions' => $reactable->total_reactions,
            'user_reaction' => $reactable->user_reaction,
        ]);
    }

    public function destroy(Request $request): JsonResponse
    {
        $request->validate([
            'reactable_type' => 'required|string',
            'reactable_id' => 'required|integer',
        ]);

        $deleted = Reaction::where([
            'user_id' => auth()->id(),
            'reactable_type' => $request->reactable_type,
            'reactable_id' => $request->reactable_id,
        ])->delete();

        if ($deleted) {
            $reactable = $request->reactable_type::find($request->reactable_id);
            
            return response()->json([
                'success' => true,
                'reaction_counts' => $reactable->reaction_counts,
                'total_reactions' => $reactable->total_reactions,
                'user_reaction' => null,
            ]);
        }

        return response()->json(['success' => false], 404);
    }

    private function getTableName($model): string
    {
        return match($model) {
            'App\Models\Post' => 'posts',
            'App\Models\Comment' => 'comments',
            default => 'posts'
        };
    }
}