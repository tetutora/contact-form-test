<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Category;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::with('category')->get();
        $categories = Category::all();

        return view('index',compact('contacts','categories'));
    }

    public function confirm(ContactRequest $request)
    {
        // $contact = $request->session()->get('contact');
        // dd($contact);

        $contact = $request->only([
            'last_name', 'first_name', 'gender', 'email', 'tel1', 'tel2', 'tel3', 'address', 'building', 'category_id', 'detail'
        ]);

        $categoryId = $request->session()->get('contact.category_id');
        $contact['category_id'] = $categoryId;

        if (!empty($contact['category_id'])) {
            $category = \App\Models\Category::find($contact['category_id']);
            $contact['category_name'] = $category ? $category->content : '';
        }

        return view('confirm', compact('contact'));
    }

    public function store(ContactRequest $request)
    {
        $contact = $request->only([
            'last_name', 'first_name', 'gender', 'email', 'tel1', 'tel2', 'tel3', 'address', 'building', 'category_id', 'detail'
        ]);

        $contact['gender'] = $this->getGenderId($contact['gender']);

        $categoryId = $this->getCategoryId($contact['category']);
        $contact['category_id'] = $categoryId;

        $contact['category_name'] = $this->getCategoryName($categoryId);

        $request->session()->put('contact', $contact);

        dd($request->session()->get('contact'));

        Contact::create([
            'last_name' => $contact['last_name'],
            'first_name' => $contact['first_name'],
            'gender' => $contact['gender'],
            'email' => $contact['email'],
            'tel1' => $contact['tel1'],
            'tel2' => $contact['tel2'],
            'tel3' => $contact['tel3'],
            'address' => $contact['address'],
            'building' => $contact['building'],
            'category_id' => $contact['category_id'],
            'detail' => $contact['detail'],
        ]);


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