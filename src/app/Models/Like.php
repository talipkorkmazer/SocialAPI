<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Like
 * @package App\Models
 * @mixin Builder
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