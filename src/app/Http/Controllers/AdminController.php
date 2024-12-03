<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ContactsExport;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // クエリビルダーを初期化
        $query = Contact::query();

        // 検索条件を取得
        $keyword = $request->input('keyword');
        $gender = $request->input('gender');
        $category = $request->input('category');
        $date = $request->input('date');

        // keywordがあれば、last_name と first_name と email に対してLIKE検索を実施
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('last_name', 'like', '%' . $keyword . '%')
                    ->orWhere('first_name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            });
        }

        // 性別での検索
        if ($gender && $gender != '0') {
        $query->where('gender', $gender);
        }

        // お問い合せの種類での検索
        if ($category) {
            $query->where('category_id', $category);
        }

        // 日付での検索
        if ($date) {
            $query->whereDate('created_at', $date);
        }

        // ページネーションを追加
        $contacts = $query->paginate(7);

        // ビューにcontactsを渡す
        return view('admin', compact('contacts'));
    }
    
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return response()->json([
            'name' => $contact->last_name . ' ' . $contact->first_name,
            'email' => $contact->email,
            'gender' => $contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : 'その他'),
            'tel' => $contact->tel1 .' ' . $contact->tel2 . ' ' . $contact->tel3,
            'address' => $contact->address,
            'building' => $contact->building,
            'category' => $this->getCategoryName($contact->category_id),
            'detail' => $contact->detail
        ]);
    }

    private function getCategoryName($categoryId)
    {
        $categories = [
            1 => 'お問い合せの種類',
            2 => '商品のお届けについて',
            3 => '商品の交換について',
            4 => '商品トラブル',
            5 => 'ショップへのお問い合わせ',
            6 => 'その他'
        ];

        return $categories[$categoryId] ?? 'その他';
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);

        $contact->delete();

        return response()->json(['message' => '削除しました'], 200);
    }

    public function export(Request $request)
    {
        // 現在の検索条件をそのまま使ってエクスポートする
        $query = Contact::query();

        $keyword = $request->input('keyword');
        $gender = $request->input('gender');
        $category = $request->input('category');
        $date = $request->input('date');

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('last_name', 'like', '%' . $keyword . '%')
                    ->orWhere('first_name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            });
        }

        if ($gender && $gender != '0') {
            $query->where('gender', $gender);
        }

        if ($category) {
            $query->where('category_id', $category);
        }

        if ($date) {
            $query->whereDate('created_at', $date);
        }

        $contacts = $query->get();  // エクスポート用に全てのデータを取得

        return Excel::download(new ContactsExport($contacts), 'contacts.xlsx');
    }
}
