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
    public function send(ContactRequest $request)
    {
        $validated = $request->validated();
        $validated['tel'] = $validated['tel1'] . $validated['tel2'] . $validated['tel3'];
        unset($validated['gender_label'], $validated['category_name']);
        Contact::create($validated);
        return redirect()->route('thanks');
    }
    public function thanks()
    {
        return view('thanks');
    }
    public function softDelete($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return redirect('/admin')->with('message', 'お問い合わせ情報を削除しました');
    }
}
