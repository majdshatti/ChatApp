<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\FlareClient\Http\Exceptions\NotFound;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class LoginController extends Controller
{
    /**
     * Logins a user
     *
     * @param LoginRequest $request contains the verfied body
     *
     * @return ResponseFactory contains user's data and token
     */
    public function index(LoginRequest $request)
    {
        // Get validated body attributes
        $attributes = $request->validated();

        $user = User::where("username", $attributes["username"])->first();

        if (!$user) {
            throw new NotFoundHttpException(getResMessage("creds"));
        }

        // Check the matching of user's password with the given password in the body
        if (!Hash::check($attributes["password"], $user->password)) {
            throw new NotFoundHttpException(getResMessage("creds"));
        }

        // Creates a token registration in personal_access_token table
        $token = $user->createToken("usertoken")->plainTextToken;

        return okResponse([
            "user" => $user,
            "token" => $token
        ]);
    }
}
