<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userList()
    {
        $user = User::where('role',2)->latest()->get();
        return view('admin.pages.user.index',compact('user'));
    }
}
