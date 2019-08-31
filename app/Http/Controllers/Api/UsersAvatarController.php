<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class UsersAvatarController extends Controller
{

    public function store()
    {
        \request()->validate([
            'avatar' => ['required', 'image'],
        ]);

        $imgPath = \request()->file('avatar')->store('avatars', 'public');

        $this->saveAvatarProfileImage($imgPath);

        auth()->user()->update([
            'avatar_path' => $imgPath,
        ]);

        return response()->json([], 204);
    }

    /**
     * @param $imgPath
     */
    private function saveAvatarProfileImage($imgPath): void
    {
        if (app()->environment() !== 'testing') {

            $avatar = Image::make(public_path('/storage/' . $imgPath))->resize(200, 200);
            $avatar->save('images/' . $imgPath);
        }
    }
}
