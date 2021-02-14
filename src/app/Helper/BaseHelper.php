<?php

namespace App\Helper;

use App\Models\Like;
use Illuminate\Support\Facades\Redis;

/**
 * Class BaseHelper
 * @package App\Helper
 */
class BaseHelper
{
    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getCurrentUser()
    {
        return auth()->getUser();
    }

    public function getAndSaveUserPostLike($postId)
    {
        $currentUser = $this->getCurrentUser();
        $userId = $currentUser->id;
        $key = $userId . '_' . $postId;

        if (Redis::get($key)) {
            return true;
        }

        $isUserLikedPost = Like::where(['post_id' => $postId, 'user_id' => $userId])->first();

        if (!$isUserLikedPost) {
            return false;
        }

        Redis::set($key, true);
        return true;
    }
}