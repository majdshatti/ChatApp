<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
     /**
     * Registers a user
     *
     * @param RegisterRequest $request contains the verfied body
     *
     * @return ResponseFactory contains user's data a message
     */
    public function index(RegisterRequest $request)
    {
        // Get validated body attributes
        $attributes = $request->validated();

        $attributes["password"] = bcrypt($attributes["password"]);
        // Set user's default attributes
        $attributes["slug"] = slugify($attributes["username"]);
        $attributes["_id"] = getUuid();

        $user = User::create($attributes);

        // Return success response
        return okResponse([
            "data" => $user,
            "keyMessage" => "registered"
        ], 201);
    }
}
