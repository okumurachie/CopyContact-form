<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
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
        $inputs = $request->validated();

        if ($request->has('back')) {
            return redirect()
                ->route('contact.form')
                ->withInput();
        }

        $genderMap = ['1' => '男性', '2' => '女性', '3' => 'その他'];
        $inputs['gender_label'] = $genderMap[$inputs['gender']] ?? '未選択';

        $inputs['tel'] = $inputs['tel1'] . $inputs['tel2'] . $inputs['tel3'];

        $inputs['category_name'] = Category::find($inputs['category_id'])->content;
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
    public function export(Request $request)
    {
        $genderMap = ['1' => '男性', '2' => '女性', '3' => 'その他'];
        $contacts = Contact::with('category')
            ->CategorySearch($request->category_id)
            ->KeywordSearch($request->keyword)
            ->GenderSearch($request->gender)
            ->DateSearch($request->created_at)
            ->get();
        $query = Contact::query();
        if ($request->filled('keyword')) {
            $query->where(function ($subQuery) use ($request) {
                $fullName = $request->keyword;
                $subQuery->where('last_name', 'like', '%' . $fullName . '%')
                    ->orWhere('first_name', 'like', '%' . $fullName . '%')
                    ->orWhere('email', 'like', '%' . $fullName . '%')
                    ->orWhereRaw("REPLACE(CONCAT(last_name, first_name), ' ', '') LIKE ?", ['%' . str_replace(' ', '', $fullName) . '%'])
                    ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ['%' . $fullName . '%']);
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
        $contacts = $query->get();
        if ($contacts->isEmpty()) {
            return redirect()->back()->with('error', 'エクスポート対象のデータがありません。');
        }
        $csvHeader = ['ID', '氏名', '性別', 'メールアドレス', 'お問い合わせの種類', '登録日'];
        $csvData = $contacts->map(function ($contact) use ($genderMap) {
            return [
                $contact->id,
                $contact->last_name . ' ' . $contact->first_name,
                $contact->email,
                $genderMap[$contact->gender] ?? '不明',
                $contact->category->content ?? '',
                $contact->created_at->format('Y-m-d'),
            ];
        });
        $filename = 'contacts_' . now()->format('Ymd_His') . '.csv';

        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, $csvHeader);
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }
        rewind($handle);

        $content = stream_get_contents($handle);
        fclose($handle);

        return Response::make($content, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }
}
