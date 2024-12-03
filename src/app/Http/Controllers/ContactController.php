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
        $contact = $request->only([
            'last_name', 'first_name', 'gender', 'email', 'tel1', 'tel2', 'tel3', 'address', 'building', 'category_id', 'detail'
        ]);

        $contact['gender'] = $this->getGenderId($contact['gender']);

        $categoryId = $this->getCategoryId($contact['category_id']);
        $contact['category_id'] = $categoryId;

        $contact['category_name'] = $this->getCategoryName($categoryId);

        $request->session()->put('contact', $contact);

        Contact::create($contact);


        return view('confirm', compact('contact'));

        // $categoryId = $request->session()->get('contact.category_id');
        // $contact['category_id'] = $categoryId;

        // if (!empty($contact['category_id'])) {
        //     $category = \App\Models\Category::find($contact['category_id']);
        //     $contact['category_name'] = $category ? $category->content : '';
        // }

        // return view('confirm', compact('contact'));
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

        Contact::create($contact);


        return view('confirm', compact('contact'));
    }

    private function getGenderId($gender)
    {
        switch ($gender) {
            case '男性':
                return 1;
            case '女性':
                return 2;
            case 'その他':
                return 3;
            default:
                return null;
        }
    }

    private function getCategoryId($categoryName)
    {
        $category = Category::where('content', $categoryName)->first();
        return $category ? $category->id : null;
    }
    public function getCategoryName($categoryId)
    {
        $category = Category::find($categoryId);
        return $category ? $category->content : 'カテゴリなし'; // カテゴリが見つからない場合は「カテゴリなし」を返す
    }


}