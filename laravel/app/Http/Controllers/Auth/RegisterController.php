<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function index(Request $request){
        $body = $request->validated();

        $body["password"] = bcrypt($body["password"]);

        $default = [
            "slug" => Str::slug($body["name"]),
            "uuid" => Str::orderedUuid()->getHex(),
        ];

        // Create user
        $user = User::create(array_merge($body, $default));

        // Return success response
        return (
            [
                "data" => $user,
                "user register"
            ]);
    }
}
