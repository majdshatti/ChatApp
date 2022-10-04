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
        $contactOwner = User::where("_id", $attributes["contact_owner_id"])->first();

        if(!$contactOwner) {
            return badResponse(getResMessage("notExist", [
                "value" => "id"
            ]));
        }

        $contactOwnerId = $contactOwner->id;

        // Get logged in user id
        $userId = Auth()->user()->id;

        // Make sure that user not adding his contact
        if($userId === $contactOwnerId){
            return badResponse(getResMessage("selfAddContact"));
        }

        /** Make sure that contact is not already added */
        $isContactExist = Contact::where([
            ["owner_id", '=', $contactOwnerId],
            ["user_id", '=', $userId],
        ])->first();

        if($isContactExist) {
            return badResponse(getResMessage("notUnique", [
                "path" => "contact",
                "field" => "user"
            ]));
        }

        Contact::create([
            "_id" => getUuid(),
            "owner_id" => $contactOwnerId,
            "user_id" => $userId
        ]);

        return okResponse([
            "data" => $contactOwner,
            "message" => getResMessage("addContact",
                [ "value" => $contactOwner->username ]
            )
        ]);
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
        ]);
    }
}
