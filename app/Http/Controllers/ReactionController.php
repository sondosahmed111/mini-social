<?php
namespace App\Http\Controllers;

use App\Models\Reaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'reactable_type' => 'required|string|in:App\Models\Post,App\Models\Comment',
            'reactable_id'   => 'required|integer',
            'type'           => 'required|in:like,love,laugh,angry,sad',
        ]);

        $userId        = auth()->id();
        $reactableType = $request->reactable_type;
        $reactableId   = $request->reactable_id;

        // دور على الريأكشن القديم
        $reaction = Reaction::where([
            'user_id'        => $userId,
            'reactable_type' => $reactableType,
            'reactable_id'   => $reactableId,
        ])->first();

        if ($reaction) {
            if ($reaction->type === $request->type) {
                // نفس النوع موجود، ما نعملش حاجة
                $action = 'no_change';
            } else {
                $reaction->update(['type' => $request->type]);
                $action = 'updated';
            }
        } else {
            Reaction::create([
                'user_id'        => $userId,
                'reactable_type' => $reactableType,
                'reactable_id'   => $reactableId,
                'type'           => $request->type,
            ]);
            $action = 'added';
        }

        // بعد العملية حول المستخدم لصفحة البوستات
        return redirect()->route('posts.index')
            ->with('message', "Reaction {$action} successfully!");
    }

    public function destroy(Request $request): JsonResponse
{
    $request->validate([
        'reactable_type' => 'required|string|in:App\Models\Post,App\Models\Comment',
        'reactable_id'   => 'required|integer',
    ]);

    $userId = auth()->id();
    $reactableType = $request->reactable_type;
    $reactableId   = $request->reactable_id;

    // جلب الريأكشن أولًا
    $reaction = Reaction::where([
        'user_id'        => $userId,
        'reactable_type' => $reactableType,
        'reactable_id'   => $reactableId,
    ])->first();

    if ($reaction) {
        $reaction->delete();
        $deleted = true;
    } else {
        $deleted = false;
    }

    $reactable = $reactableType::find($reactableId);

    return response()->json([
        'success'         => $deleted,
        'reaction_counts' => $reactable ? $reactable->reaction_counts : [],
        'total_reactions' => $reactable ? $reactable->total_reactions : 0,
        'user_reaction'   => null,
    ]);
}

}
