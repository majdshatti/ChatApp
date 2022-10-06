<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     *
     * @return Response
     */
    public function index() {
        return okResponse([
            "data" => User::all()
        ]);
    }
}
