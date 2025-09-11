<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

protected $fillable = ['title','description','image','user_id'];

    // نحمّل هذه العلاقات تلقائيًا
    protected $with = ['user', 'reactions', 'comments.user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function reactors()
    {
        return $this->belongsToMany(User::class, 'reactions')
                    ->withPivot('type')
                    ->withTimestamps();
    }
}
