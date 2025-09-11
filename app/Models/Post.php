<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Reactable;


class Post extends Model
{
    use HasFactory;
    use Reactable;

    protected $fillable = [
        'title',
        'description',
        'image',
        'user_id'
    ];
    protected $appends = ['reaction_counts', 'total_reactions', 'user_reaction'];


    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    // app/Models/Post.php
public function reactions()
{
    return $this->hasMany(Reaction::class);
}
}
