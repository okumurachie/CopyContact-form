<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Category;
use App\Models\Contact;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $categories = Category::all();
        $contacts = Contact::Paginate(7);
        return view('index', compact('categories'));
    }

    public function store(UserRequest $request)
    {
        $form = $request->all();
        $form['password'] = Hash::make($form['password']);
        User::create($form);

        return redirect('/')->with('message', '会員登録が完了しました');
    }
}
