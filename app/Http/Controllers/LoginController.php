<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function postlogin(Request $request) {

        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }

        //fungsi unset() adalah untuk tidak menunjukkan tabel database yang tidak diharapkan untuk dimunculkan
        unset($user->remember_token);
        unset($user->created_at);
        unset($user->updated_at);

        $user->tokens()->delete();
        $token = $user->createToken('login')->plainTextToken;
        $user->token = $token;
        return response(['data' => $user]);

    }

    public function me(Request $request) {

        return response(['data' => auth()->user()]);

    }

    public function logout() {

        $user = auth()->user();
        $user->tokens->delete();

        return response(['message' => 'logout success']);

    }

}
