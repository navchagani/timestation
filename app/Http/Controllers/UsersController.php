<?php


namespace App\Http\Controllers;


use App\Models\User;

class UsersController extends Controller
{

    public function index()
    {

        return view('admin.users')->with('users', User::all());;

    }

}
