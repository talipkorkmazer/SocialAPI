<?php

namespace App\Http\Controllers;

use App\Helper\BaseHelper;
use App\Models\User;
use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class FollowerController
 * @package App\Http\Controllers
 */
class FollowerController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $currentUser = $this->helper->getCurrentUser();
        $userModel = User::find($currentUser->id);

        return $this->response($userModel->followers, 200, "Followed users successfully returned.");
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($id)
    {
        if (empty($id)) {
            return $this->response(null, 401, 'The given data was invalid.', [
                "id" => [
                    "Users can only updated their own data.",
                ],
            ]);
        }

        $followedUser = User::find($id);
        $currentUser = $this->helper->getCurrentUser();

        if ($id == $currentUser->id) {
            return $this->response(null, 404, 'The given data was invalid.', [
                "id" => [
                    "Can't follow yourself.",
                ],
            ]);
        }

        if (!$followedUser) {
            return $this->response(null, 404, 'The given data was invalid.', [
                "user_id" => [
                    "Requested user not found.",
                ],
            ]);
        }

        $doesUserAlreadyFollowed = Follower::where([
            'user_id' => $currentUser->id,
            'followed_user_id' => $id,
        ])->first();

        if ($doesUserAlreadyFollowed) {
            return $this->response(null, 401, 'The given data was invalid.', [
                "user_id" => [
                    "User already followed.",
                ],
            ]);
        }

        Follower::create([
            'user_id' => $currentUser->id,
            'followed_user_id' => $id,
        ]);

        return $this->response($followedUser, 201, __("User followed successfully."));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (empty($id)) {
            return $this->response(null, 401, 'The given data was invalid.', [
                "id" => [
                    "Users can only updated their own data.",
                ],
            ]);
        }

        $currentUser = $this->helper->getCurrentUser();

        if ($id == $currentUser->id) {
            return $this->response(null, 404, 'The given data was invalid.', [
                "id" => [
                    "Can't unfollow yourself.",
                ],
            ]);
        }

        $doesUserExists = User::find($id);

        if (!$doesUserExists) {
            return $this->response(null, 404, 'The given data was invalid.', [
                "id" => [
                    "Requested user not found.",
                ],
            ]);
        }

        $userFollowModel = Follower::where(['user_id' => $currentUser->id, 'followed_user_id' => $id])->first();

        if (!$userFollowModel) {
            return $this->response(null, 401, 'The given data was invalid.', [
                "id" => [
                    "You are not following the requested user.",
                ],
            ]);
        }

        $result = $userFollowModel->delete();
        if (!$result) {
            return $this->response(false, 500, 'Error while unfollowing user, please try again.');
        }
        return $this->response(true, 204);
    }
}
