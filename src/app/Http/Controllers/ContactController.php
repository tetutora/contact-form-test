<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contact = $request->session()->get('contact',[]);

        return view('index',compact('contact'));
    }

    public function store(Request $request)
    {
        // $contact = $request->only([
        // 'last_name', 'first_name', 'gender', 'email', 'tel1', 'tel2', 'tel3', 'address', 'building', 'category', 'detail'
        // ]);

        // $request->session()->put('contact', $contact);

        // Contact::create($contact);

        // return view('confirm', compact('contact'));

        // $contactData = session('contact');

        // if (!$contactData)
        // {
        //     return redirect('/')->with('error', 'セッションが無効です');
        // }

        // $contactData['gender'] = $this->getGenderId($contactData['gender']);

        // $contactData['category_id'] = $this->getCategoryId($contactData['category_name']);

        // try
        // {
        //     Contact::create($contactData);
        // }   catch (\Exception $e)
        // {
        //     return redirect('/')->with('error', 'データベース保存エラー: ' . $e->getMessage());
        // }

        // $request->session()->forget('contact');

        // return redirect('/thanks');

        // $contact = session('contact');
        // $contact = $request->only(['contact']);
        // Contact::create($contact);

        // session([
        //     'contact.category' => $request->category,
        // ]);


        // データベースに保存
        // Contact::create([
        //     'last_name' => $contact['last_name'],
        //     'first_name' => $contact['first_name'],
        //     'gender' => $this->getGenderId($contact['gender']),
        //     'email' => $contact['email'],
        //     'tel1' => $contact['tel1'],
        //     'tel2' => $contact['tel2'],
        //     'tel3' => $contact['tel3'],
        //     'address' => $contact['address'],
        //     'building' => $contact['building'],
        //     'category_id' => $this->getCategoryId($contact['category_name']),
        //     'detail' => $contact['detail'],
        // ]);

        // $contact['gender'] = $this->getGenderId($contact['gender']);

        // $categoryId = $this->getCategoryId($contact['category']);
        // $contact['category_id'] = $categoryId;

        // $contact['category_name'] = $this->getCategoryName($categoryId);

        // session([
        //     'contact.category' => $request->category,
        // ]);


        // $request->session()->forget('contact');

        // return redirect('/thanks');
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->only([
            'last_name', 'first_name', 'gender', 'email', 'tel1', 'tel2', 'tel3', 'address', 'building', 'category_id', 'detail'
        ]);
        session(['contact' => $contact]);

        if (!empty($contact['category_id'])) {
        $category = \App\Models\Category::find($contact['category_id']);
        $contact['category_name'] = $category ? $category->content : '';
        }

        return view('confirm', compact('contact'));
    }

    private function getGenderId($gender)
    {
        switch ($gender) {
            case '男性':
                return 1;
            case '女性':
                return 2;
            default:
                return 3; // その他
        }
    }

private function getCategoryId($category)
    {
        $categories = [
            '商品のお届けについて' => 1,
            '商品の交換について' => 2,
            '商品トラブル' => 3,
            'ショップへのお問い合わせ' => 4,
            'その他' => 5
        ];

        return $categories[$category] ?? 5; // その他
    }


}
