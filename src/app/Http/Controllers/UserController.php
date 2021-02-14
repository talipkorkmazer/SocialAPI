<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Helper\BaseHelper;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $currentUser = $this->helper->getCurrentUser();

        if ($id == $currentUser->id) {
            return $this->response($currentUser, 200, "Account successfully returned.");
        }

        $user = User::find($id);

        if (!$user) {
            return $this->response(null, 404, 'The given data was invalid.', [
                "user_id" => [
                    "Requested user not found.",
                ],
            ]);
        }

        if (!Follower::doesUserFollowsUser($currentUser->id, $id)) {
            return $this->response(null, 401, 'The given data was invalid.', [
                "user_id" => [
                    "You are not following requested user.",
                ],
            ]);
        }

        return $this->response($user, 200, "Account successfully returned.");
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $currentUser = $this->helper->getCurrentUser();

        $userModel = User::find($currentUser->id);

        if ($request->has('token')) {
            return $this->response(null, 401, 'The given data was invalid.', [
                "token" => [
                    "Token field cannot be changed.",
                ],
            ]);
        }

        if ($request->has('email')) {
            return $this->response(null, 401, 'The given data was invalid.', [
                "email" => [
                    "Email cannot be changed.",
                ],
            ]);
        }

        if ($request->has('username')) {
            return $this->response(null, 401, 'The given data was invalid.', [
                "username" => [
                    "Username cannot be changed.",
                ],
            ]);
        }


        $input = $request->all();
        if ($request->has('password')) {
            $input = array_merge(
                $request->all(),
                ['password' => Hash::make($request->get('password'))]
            );
        }

        $userModel->update($input);

        return $this->response(true, 200, 'User successfully updated.');
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfilePicture(Request $request)
    {
        $currentUser = $this->helper->getCurrentUser();

        $validator = Validator::make($request->all(), [
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->response(null, 422, 'The given data was invalid.', $validator->errors());
        }

        $userModel = User::find($currentUser->id);

        $imageName = time() . '.' . $request->profile_picture->extension();
        $request->profile_picture->move(public_path('profile_pictures'), $imageName);

        $userModel->profile_picture = asset('/profile_pictures/' . $imageName);
        $userModel->save();

        return $this->response(true, 200, 'User profile picture updated successfully.');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy()
    {
        $currentUser = $this->helper->getCurrentUser();

        $userModel = User::find($currentUser->id);

        $result = $userModel->delete();
        if (!$result) {
            return $this->response(false, 500, 'Error while deleting user, please try again.');
        }
        return $this->response(true, 204);
    }
}
