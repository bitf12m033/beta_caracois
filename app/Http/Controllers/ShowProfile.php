<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class ShowProfile extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id)
    {

        return view('dashboard.user.profile', ['user' => User::findOrFail($id)]);
    }
}
