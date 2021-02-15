<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Follower
 * @package App\Models
 * @mixin Builder
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