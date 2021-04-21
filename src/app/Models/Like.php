<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Like
 *
 * @package App\Models
 * @mixin Builder
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $id
 * @property int $user_id
 * @property int $post_id
 * @method static \Database\Factories\LikeFactory factory(...$parameters)
 * @method static Builder|Like newModelQuery()
 * @method static Builder|Like newQuery()
 * @method static Builder|Like query()
 * @method static Builder|Like whereCreatedAt($value)
 * @method static Builder|Like whereId($value)
 * @method static Builder|Like wherePostId($value)
 * @method static Builder|Like whereUpdatedAt($value)
 * @method static Builder|Like whereUserId($value)
 */
class Like extends Model
{
    use HasFactory;
    /**
     * @var string
     */
    protected $table = 'likes';
    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'post_id'];
}