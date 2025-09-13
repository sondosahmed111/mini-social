<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReactionController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'reactable_type' => 'required|string',
                'reactable_id' => 'required|integer',
                'type' => 'required|in:like,love,haha,wow,sad,angry'
            ]);

            $reactableType = $request->reactable_type;
            $reactableId = $request->reactable_id;
            $type = $request->type;
            $userId = Auth::id();

            // البحث عن ريأكشن موجود
            $existingReaction = \DB::table('reactions')
                ->where('user_id', $userId)
                ->where('reactable_type', $reactableType)
                ->where('reactable_id', $reactableId)
                ->first();

            if ($existingReaction) {
                if ($existingReaction->type === $type) {
                    // إذا كان نفس النوع، احذفه
                    \DB::table('reactions')
                        ->where('id', $existingReaction->id)
                        ->delete();
                    
                    return response()->json([
                        'success' => true,
                        'message' => 'Reaction removed',
                        'reaction' => null
                    ]);
                } else {
                    // إذا كان نوع مختلف، حدثه
                    \DB::table('reactions')
                        ->where('id', $existingReaction->id)
                        ->update([
                            'type' => $type,
                            'updated_at' => now()
                        ]);
                    
                    return response()->json([
                        'success' => true,
                        'message' => 'Reaction updated',
                        'reaction' => [
                            'type' => $type,
                            'user_id' => $userId
                        ]
                    ]);
                }
            } else {
                // إنشاء ريأكشن جديد
                $reactionId = \DB::table('reactions')->insertGetId([
                    'user_id' => $userId,
                    'reactable_type' => $reactableType,
                    'reactable_id' => $reactableId,
                    'type' => $type,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Reaction added',
                    'reaction' => [
                        'type' => $type,
                        'user_id' => $userId
                    ]
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}