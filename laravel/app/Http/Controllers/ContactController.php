<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\StoreContactRequest;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of contacts.
     *
     * @return Response
     */
    public function index()
    {
        return okResponse([
            "data" => Contact::all()
        ]);
    }

    /**
     * Store a newly created contact in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(StoreContactRequest $request)
    {
        // Get validated body attributes
        $attributes = $request->validated();

        // Fetch contact's user
        $contactOwner = User::where("phone_number", $attributes["phone_number"])->first();

        if(!$contactOwner) {
            return badResponse(getResMessage("notExist", [
                "value" => $attributes["phone_number"]
            ]));
        }

        // Get logged in user id
        $userId = Auth()->user()->id;

        if($contactOwner->id == $userId){
            return badResponse(getResMessage("selfAddContact"));
        }

        /** Make sure that contact is not already added */
        $isContactExist = Contact::where([
            ["user_id", '=', $userId],
            ["phone_number", '=', $attributes["phone_number"]],
        ])->first();

        if($isContactExist) {
            return badResponse(getResMessage("notUnique", [
                "path" => "contact",
                "field" => "user"
            ]));
        }

        $contact = Contact::create([
            "_id" => getUuid(),
            "user_id" => $userId,
            "name" => $contactOwner->username,
            "phone_number" => $attributes["phone_number"],
        ]);

        return okResponse([
            "data" => $contact,
            "message" => getResMessage("addContact",
                [ "value" => $contactOwner->username ]
            )
        ], 201);
    }

    /**
     * Display the specified contact.
     *
     * @param  uuid  $id
     * @return Response
     */
    public function show($id)
    {
        $contact = Contact::where("_id", $id)->first();

        if(!$contact) {
            return badResponse(getResMessage("notExist", [
                "value" => "id"
            ]));
        }

        return okResponse([
            "data" => $contact
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return Response
     */
    public function destroy($id)
    {
        $contact = Contact::where("_id", $id)->first();

        if(!$contact) {
            return badResponse(getResMessage("notExist", [
                "value" => "id"
            ]));
        }

        $contact->delete();

        return okResponse([
            "message" => getResMessage("deleted", [
                "path" => "contact"
            ])
        ], 202);
    }
}
