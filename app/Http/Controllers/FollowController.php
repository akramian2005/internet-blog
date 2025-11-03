<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function toggle(User $user)
    {
        $authUser = auth()->user();

        if ($authUser->id === $user->id) {
            return back()->with('error', 'Нельзя подписаться на себя.');
        }

        if ($authUser->isFollowing($user)) {
            $authUser->following()->detach($user->id);
            return back()->with('success', 'Вы отписались от пользователя.');
        } else {
            $authUser->following()->attach($user->id);
            return back()->with('success', 'Вы подписались на пользователя.');
        }
    }

public function connections($id)
{
    $user = User::findOrFail($id);
    $followers = $user->followers()->paginate(10);
    $following = $user->following()->paginate(10);

    return view('users.connections', compact('user', 'followers', 'following'));
}


}
