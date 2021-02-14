<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use App\Models\Follower;
use App\Models\Post;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class PostController
 * @package App\Http\Controllers
 */
class PostController extends Controller
{

    public function index()
    {
        $currentUser = $this->helper->getCurrentUser();
        $userModel = User::find($currentUser->id);
        $posts = $userModel->posts;

        foreach ($posts as $post) {
            $post->is_user_liked = $this->helper->getAndSaveUserPostLike($post->id);
        }

        return $this->response($posts->toArray(), 200, "Posts successfully returned.");
    }

    /**
     * @param  Request  $request
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->response(null, 422, 'The given data was invalid.', $validator->errors());
        }

        $imageName = time() . '.' . $request->photo->extension();

        $request->photo->move(public_path('posts'), $imageName);

        $post = Post::create([
            'user_id' => $this->helper->getCurrentUser()->id,
            'photo' => asset('/posts/' . $imageName),
            'like_count' => 0,
        ]);

        return $this->response($post, 201, 'Post created successfully.');
    }

    /**
     * @param $username
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $currentUser = $this->helper->getCurrentUser();
        $post = Post::find($id);

        $userFollowModel = Follower::where(['user_id' => $currentUser->id, 'followed_user_id' => $post->user_id])
            ->first();

        if (!$userFollowModel) {
            return $this->response(null, 401, 'The given data was invalid.', [
                "id" => [
                    "You are not following the requested user.",
                ],
            ]);
        }

        return $this->response($post, 200, "Post successfully returned.");

    }

    /**
     * @param $username
     * @return \Illuminate\Http\JsonResponse
     */
    public function list($username)
    {
        $currentUser = $this->helper->getCurrentUser();
        $user = User::getUserByUsername($username);
        if (!$user) {
            return $this->response(null, 404, 'The given data was invalid.', [
                "username" => [
                    "Requested user not found.",
                ],
            ]);
        }

        $userFollowModel = Follower::where(['user_id' => $currentUser->id, 'followed_user_id' => $user->id])->first();

        if (!$userFollowModel) {
            return $this->response(null, 401, 'The given data was invalid.', [
                "id" => [
                    "You are not following the requested user.",
                ],
            ]);
        }

        $posts = $user->posts;

        foreach ($posts as $post) {
            $post->is_user_liked = $this->helper->getAndSaveUserPostLike($post->id);
        }

        return $this->response($posts->toArray(), 200, "Posts successfully returned.");

    }

    public function destroy($id)
    {
        $currentUser = $this->helper->getCurrentUser();
        $post = Post::where(['id' => $id, 'user_id' => $currentUser->id])->first();

        if (!$post) {
            return $this->response(null, 404, 'The given data was invalid.', [
                "id" => [
                    "Post not found.",
                ],
            ]);
        }

        $postImageNameArray = explode('/', $post->photo);

        $postImageName = public_path('posts/' . end($postImageNameArray));

        File::delete($postImageName);

        Like::where('post_id', $id)->delete();

        $result = $post->delete();
        if (!$result) {
            return $this->response(false, 500, 'Error while deleting post, please try again.');
        }
        return $this->response(true, 204);


    }

    public function getPostLikeCount($postId)
    {
        $post = Post::find($postId);
        if (!$post) {
            return $this->response(null, 404, 'The given data was invalid.', [
                "post_id" => [
                    "Requested post not found.",
                ],
            ]);
        }

        return $this->response(Like::getPostLikesCount($postId), 200, "Post like count successfully returned.");
    }
}
