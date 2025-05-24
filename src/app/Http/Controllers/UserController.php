<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Category;
use App\Models\Contact;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{
    public function store(UserRequest $request)
    {
        $form = $request->all();
        $form['password'] = Hash::make($form['password']);
        User::create($form);

        return redirect('/admin')->with('message', '会員登録が完了しました');
    }
    public function showAdminForm(Request $request)
    {
        $genderMap = ['1' => '男性', '2' => '女性', '3' => 'その他'];
        $query = Contact::query();
        if ($request->filled('keyword')) {
            $rowInput = $request->keyword;
            $noSpaceInput = str_replace([' ', '　'], '', $rowInput);
            $query->where(function ($subQuery) use ($rowInput, $noSpaceInput) {
                $subQuery->where('last_name', 'like', '%' . $rowInput . '%')
                    ->orWhere('first_name', 'like', '%' . $rowInput . '%')
                    ->orWhere('email', 'like', '%' . $rowInput . '%')
                    ->orWhereRaw("REPLACE(REPLACE(CONCAT(last_name, first_name), ' ', ''), '　', '') LIKE ?", ['%' . $noSpaceInput . '%'])
                    ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ['%' . $rowInput . '%'])
                    ->orWhereRaw("CONCAT(last_name, '　', first_name) LIKE ?", ['%' . $rowInput . '%']);
            });
        }
        if ($request->filled('gender') && $request->gender !== 'all') {
            $query->where('gender', $request->gender);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('created_at')) {
            $query->whereDate('created_at', $request->created_at);
        }
        $contacts = $query->paginate(7);
        $contacts->getCollection()->transform(function ($contact) use ($genderMap) {
            $contact->gender = $genderMap[$contact->gender] ?? '不明';
            return $contact;
        });
        $categories = Category::all();

        $detailContact = null;
        if ($request->filled('detail')) {
            $detailContact = Contact::with('category')->find($request->detail);
        }

        return view('admin.admin', compact('contacts', 'categories', 'detailContact'));
    }
    public function search(Request $request)
    {
        $contacts = Contact::with('category')
            ->CategorySearch($request->category_id)
            ->KeywordSearch($request->keyword)
            ->GenderSearch($request->gender)
            ->DateSearch($request->created_at)
            ->paginate(7);

        $categories = Category::all();
        $detailContact = null;
        if ($request->filled('detail')) {
            $detailContact = Contact::with('category')->find($request->detail);
        }
        return view('admin.admin', compact('contacts', 'categories', 'detailContact'));
    }
}
