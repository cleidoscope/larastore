<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Http\Helpers;

class UserController extends Controller
{

    public function index()
    {
    	$users = User::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.user.index', compact('users'));
    }


    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.show', compact('user'));
    }

}