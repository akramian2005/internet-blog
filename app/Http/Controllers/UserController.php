<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Просмотр профиля пользователя
    public function show($id)
    {
        $user = User::with('articles')->findOrFail($id);
        return view('profile_page', compact('user'));
    }

    // Форма редактирования текущего пользователя
    public function edit()
    {
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

    // Сохранение изменений профиля
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
                Storage::delete($user->avatar); // удаляем старый
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('users.show', $user->id)->with('success', 'Профиль обновлен');
    }
}
