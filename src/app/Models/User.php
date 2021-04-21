<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 *
 * @package App\Models
 * @mixin Builder
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $token
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string|null $full_name
 * @property string|null $bio
 * @property string|null $profile_picture
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $followers
 * @property-read int|null $followers_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $posts
 * @property-read int|null $posts_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static Builder|User query()
 * @method static Builder|User whereBio($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereDeletedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereFullName($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereProfilePicture($value)
 * @method static Builder|User whereToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 */
class User extends Authenticatable
{
    use SoftDeletes, HasFactory, Notifiable;
    /**
     * @var string
     */
    protected $table = 'users';
    /**
     * @var bool
     */
    public $timestamps = true;

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