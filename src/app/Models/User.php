<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * @package App\Models
 * @mixin Builder
 */
class User extends Authenticatable
{
    /**
     * @var string
     */
    protected $table = 'users';
    /**
     * @var bool
     */
    public $timestamps = true;

    use SoftDeletes, HasFactory, Notifiable;

    /**
     * @var string[]
     */
    protected $dates = ['deleted_at'];
    /**
     * @var string[]
     */
    protected $fillable = ['token', 'email', 'username', 'password', 'full_name', 'bio', 'profile_picture'];

    /**
     * @var string[]
     */
    protected $hidden = ['password', 'token'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id')->orderBy('created_at', 'ASC');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'followed_user_id')->withTimestamps();
    }

    public static function getLikedPosts($userId)
    {
        return Like::where('user_id', $userId)->get();
    }

    /**
     * @param $token
     * @return User|\Illuminate\Database\Eloquent\Model|object|null
     */
    public static function getUserByToken($token)
    {
        return self::where('token', $token)->first();
    }

    /**
     * @param $username
     * @return User|\Illuminate\Database\Eloquent\Model|object|null
     */
    public static function getUserByUsername($username)
    {
        return self::where('username', $username)->first();
    }

    /**
     * @param $email
     * @return mixed
     */
    public static function getUserByEmail($email)
    {
        return self::where('email', $email)->first();
    }

}