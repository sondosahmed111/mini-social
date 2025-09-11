<?php
// 2. Reaction Model - app/Models/Reaction.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reaction extends Model
{
    protected $fillable = ['user_id', 'reactable_id', 'reactable_type', 'type'];

    public function reactable(): MorphTo
    {
        return $this->morphTo();
    }

    // app/Models/Reaction.php
public function user()
{
    return $this->belongsTo(User::class);
}

public function post()
{
    return $this->belongsTo(Post::class);
}
}