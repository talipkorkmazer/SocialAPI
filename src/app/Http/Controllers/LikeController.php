<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\Post;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class LikeController
 * @package App\Http\Controllers
 */
class LikeController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $currentUser = $this->helper->getCurrentUser();
        $likedPosts = User::getLikedPosts($currentUser->id);

        return $this->response($likedPosts->toArray(), 200, "Liked posts successfully returned.");
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($id)
    {
        $currentUser = $this->helper->getCurrentUser();
        $post = Post::find($id);

        if (!$post) {
            return $this->response(null, 404, 'The given data was invalid.', [
                "id" => [
                    "Requested post not found.",
                ],
            ]);
        }
        
        $postUserId = $post->user_id;

        $userFollowModel = Follower::where(['user_id' => $currentUser->id, 'followed_user_id' => $post->user_id])
            ->first();

        if (!$userFollowModel && $currentUser->id != $postUserId) {
            return $this->response(null, 401, 'The given data was invalid.', [
                "id" => [
                    "You are not following the requested user.",
                ],
            ]);
        }

        $isUserAlreadyLikedPost = Like::where(['user_id' => $currentUser->id, 'post_id' => $id])->first();

        if ($isUserAlreadyLikedPost) {
            return $this->response(null, 401, 'The given data was invalid.', [
                "id" => [
                    "You already liked the post.",
                ],
            ]);
        }

        Like::create([
            'user_id' => $currentUser->id,
            'post_id' => $id,
        ]);

        $post->like_count = $post->like_count + 1;
        $post->save();

        return $this->response($post, 201, 'Post liked successfully.');
    }

    public function destroy($id)
    {
        $currentUser = $this->helper->getCurrentUser();
        $post = Post::find($id);

        if (!$post) {
            return $this->response(null, 404, 'The given data was invalid.', [
                "id" => [
                    "Requested post not found.",
                ],
            ]);
        }

        $isUserAlreadyLikedPost = Like::where(['user_id' => $currentUser->id, 'post_id' => $id])->first();

        if (!$isUserAlreadyLikedPost) {
            return $this->response(null, 401, 'The given data was invalid.', [
                "id" => [
                    "You did not liked the post yet.",
                ],
            ]);
        }

        $result = $isUserAlreadyLikedPost->forceDelete();
        if (!$result) {
            return $this->response(false, 500, 'Error while unliking post, please try again.');
        }

        $post->like_count = $post->like_count - 1;
        $post->save();

        return $this->response(true, 204);
    }
}
