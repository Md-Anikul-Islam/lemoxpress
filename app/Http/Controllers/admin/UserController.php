<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserHistory;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userList()
    {
        $user = User::where('role',2)->with('userHistory')->latest()->get();
        return view('admin.pages.user.index',compact('user'));
    }

    public function userHistpry($id)
    {
        $userHistpry = UserHistory::where('uid',$id)->latest()->get();
        return view('admin.pages.user.history',compact('userHistpry'));
    }
}
