<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->only([
            'last_name', 'first_name', 'gender', 'email', 'tel1', 'tel2', 'tel3', 'address', 'building', 'category_id', 'detail'
        ]);
        session(['contact' => $contact]);

        // カテゴリーIDからカテゴリー名を取得し、確認用にセット
        if (!empty($contact['category_id'])) {
            $category = \App\Models\Category::find($contact['category_id']);
            $contact['category_name'] = $category ? $category->content : '';
        }

        // 確認画面を表示
        return view('confirm', compact('contact'));
    }

    public function store(ContactRequest $request)
    {
    $contact = $request->only([
        'last_name', 'first_name', 'gender', 'email', 'tel1', 'tel2', 'tel3', 'address', 'building', 'category', 'detail'
    ]);

        // genderを文字列から数値に変換
        $contact['gender'] = $this->getGenderId($contact['gender']);

        // categoryの変換
        $categoryId = $this->getCategoryId($contact['category']);
        $contact['category_id'] = $categoryId;

        // category_nameの設定
        $contact['category_name'] = $this->getCategoryName($categoryId);

        // セッションに保存
        $request->session()->put('contact', $contact);

        // DBに保存
        Contact::create($contact);

        // 確認画面に遷移
        return view('confirm', compact('contact'));
    }

    // public function submit(Request $request)
    // {
    //     // セッションからデータを取得
    //     $contact = session('contact');

    //     // データベースに保存
    //     Contact::create([
    //         'last_name' => $contact['last_name'],
    //         'first_name' => $contact['first_name'],
    //         'gender' => $contact['gender'],
    //         'email' => $contact['email'],
    //         'tel1' => $contact['tel1'],
    //         'tel2' => $contact['tel2'],
    //         'tel3' => $contact['tel3'],
    //         'address' => $contact['address'],
    //         'building' => $contact['building'],
    //         'category_id' => $contact['category'],
    //         'detail' => $contact['detail'],
    //     ]);

    //     // セッションデータをクリア
    //     $request->session()->forget('contact');

    //     // 完了画面へリダイレクト
    //     return redirect()->route('thanks');
    // }

}
