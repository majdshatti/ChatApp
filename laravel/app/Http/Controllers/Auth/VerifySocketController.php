<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class VerifySocketController extends Controller
{
    /**
     * Verify connected user to the nodejs socketing server
     * and verify the user that is going to receive the message if does exist
     *
     * @param string $userSentToId the user supposed to be receiving message
     *
     * @return Response
     */
    public function index(string $userSentToId) {
        $userSentTo = User::where("_id", $userSentToId)->first();

        if (!$userSentTo){
            return badResponse(getResMessage("notExist", [
                "value" => $userSentToId
            ]), 401);
        }

        return okResponse([
            "data" => [
                "senderId" => Auth::user()->_id,
                "receiverId" => $userSentToId
            ]
        ]);
    }
}
