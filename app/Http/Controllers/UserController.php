<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Просмотр профиля пользователя
    public function show($id)
    {
        $user = User::with('articles')->findOrFail($id);
        return view('users.profile_page', compact('user'));
    }

    // Форма редактирования текущего пользователя
    public function edit()
    {
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

    // Сохранение изменений профиля (имя, аватар, about)
    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'about' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Обновление аватара
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('users.show', $user->id)->with('success', 'Профиль обновлён');
    }

    // Форма изменения email и пароля (Безопасность)
    public function security()
    {
        $user = Auth::user();
        return view('users.security', compact('user'));
    }

    // Сохранение изменений email и пароля
    public function updateSecurity(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Обновление email
        $user->email = $data['email'];

        // Обновление пароля, если введён
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('users.show', $user->id)->with('success', 'Настройки безопасности обновлены');
    }

    public function connections($id)
{
    $user = User::findOrFail($id);
    $followers = $user->followers()->paginate(10);
    $following = $user->following()->paginate(10);

    return view('users.connections', compact('user', 'followers', 'following'));
}
}
