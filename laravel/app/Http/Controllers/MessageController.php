<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
     /**
     * Display a list of messages
     *
     * @return Response
     */
    public function index(){
        return okResponse([
            "data" => Message::latest()
            ->filter(request(['search', 'user']))->get()
        ]);
    }

    /**
     * Store a message
     *
     * @param Request $request message body
     *
     * @return Response
     */
    public function store(Request $request){
        $attributes = $request->validate([
            "message" => "required|string|min:1",
            "from" => "required|string",
            "to" => "required|string"
        ]);

        /** Fetch sender and receiver private ids */
        //? NOTE that private ids is used for relations
        $userFromId = User::where("_id", $attributes["from"])->first()->id;
        $userToId = User::where("_id", $attributes["to"])->first()->id;

        /** Form message object */
        $message["_id"] = getUuid();
        $message["body"] = $attributes["message"];
        $message["sender_id"] = $userFromId;
        $message["receiver_id"] = $userToId;

        Message::create($message);

        return okResponse(["success" => true], 201);
    }
}
