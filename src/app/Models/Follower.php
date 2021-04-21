<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Follower
 *
 * @package App\Models
 * @mixin Builder
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $id
 * @property int $user_id
 * @property int $followed_user_id
 * @method static \Database\Factories\FollowerFactory factory(...$parameters)
 * @method static Builder|Follower newModelQuery()
 * @method static Builder|Follower newQuery()
 * @method static Builder|Follower query()
 * @method static Builder|Follower whereCreatedAt($value)
 * @method static Builder|Follower whereFollowedUserId($value)
 * @method static Builder|Follower whereId($value)
 * @method static Builder|Follower whereUpdatedAt($value)
 * @method static Builder|Follower whereUserId($value)
 */
class Follower extends Model
{
    use HasFactory;
    /**
     * @var string
     */
    protected $table = 'followers';
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
    protected $fillable = ['user_id', 'followed_user_id'];

    public static function doesUserFollowsUser($userId, $followedUserId)
    {
        return self::where(['user_id' => $userId, 'followed_user_id' => $followedUserId])->first();
    }
}