<?php

namespace App\Traits;

use App\Models\Reaction;

trait Reactable
{
    public function reactions()
    {
        return $this->morphMany(Reaction::class, 'reactable');
    }

    public function getReactionCountsAttribute()
    {
        return $this->reactions()
            ->selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type');
    }

    public function getTotalReactionsAttribute()
    {
        return $this->reactions()->count();
    }

    public function getUserReactionAttribute()
    {
        if (!auth()->check()) {
            return null;
        }

        $reaction = $this->reactions()
            ->where('user_id', auth()->id())
            ->first();

        return $reaction ? $reaction->type : null;
    }
}
