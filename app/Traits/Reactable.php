<?php
// 3. Add Reactable Trait - app/Traits/Reactable.php
namespace App\Traits;

use App\Models\Reaction;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Reactable
{
    public function reactions(): MorphMany
    {
        return $this->morphMany(Reaction::class, 'reactable');
    }

    public function getReactionCountsAttribute()
    {
        return $this->reactions()
            ->selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();
    }

    public function getTotalReactionsAttribute()
    {
        return $this->reactions()->count();
    }

    public function getUserReactionAttribute()
    {
        if (!auth()->check()) return null;
        
        return $this->reactions()
            ->where('user_id', auth()->id())
            ->first()?->type;
    }

    public function hasReactionFrom($userId = null): bool
    {
        $userId = $userId ?? auth()->id();
        return $this->reactions()->where('user_id', $userId)->exists();
    }
}
