<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'bio',
        'profile_image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * علاقة البوستات
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    /**
     * علاقة الريأكشنز
     */
    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    /**
     * الناس اللي بيتابعوني
     */
    public function followers()
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'following_id',   // my id in pivot
            'follower_id'     // follower id in pivot
        )->withTimestamps();
    }

    /**
     * الناس اللي أنا متابعهم
     */
    public function following()
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'follower_id',    // my id in pivot
            'following_id'    // id of user I follow
        )->withTimestamps();
    }
}
