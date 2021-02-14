<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Post
 * @package App\Models
 * @mixin Builder
 */
class Post extends Model
{
    /**
     * @var string
     */
    protected $table = 'posts';
    /**
     * @var bool
     */
    public $timestamps = true;

    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $dates = ['deleted_at'];
    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'photo', 'like_count'];

    /**
     * @param $userId
     * @return Post[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getUserPostsByUserId($userId)
    {
        return $this->where('user_id', $userId)->get();
    }

}