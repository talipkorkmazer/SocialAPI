<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Post
 * @package App\Models
 * @mixin Builder
 */
class Post extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'posts';
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
    protected $fillable = ['user_id', 'photo', 'like_count'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(Like::class, 'post_id', 'id');
    }

}