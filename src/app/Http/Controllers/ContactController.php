<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Category;
use App\Models\Contact;
use App\Models\User;

class ContactController extends Controller
{
    public function index()
    {
        $users = User::all();
        $categories = Category::all();
        return view('index', compact('categories'));
    }

    public function showConfirmForm()
    {
        $categories = Category::all();
        return view('confirm', compact('categories'));
    }


    public function confirm(ContactRequest $request)
    {
        $validated = $request->validated();

        if ($request->has('back')) {
            return redirect()
                ->route('contact.form')
                ->withInput();
        }

        $genderMap = ['1' => '男性', '2' => '女性', '3' => 'その他'];
        $validated['gender_label'] = $genderMap[$validated['gender']] ?? '未選択';

        $validated['tel'] = $validated['tel1'] . $validated['tel2'] . $validated['tel3'];

        $validated['category_name'] = Category::find($validated['category_id'])->content;
        $inputs = $validated;
        return view('confirm', (compact('inputs')));
    }
}
