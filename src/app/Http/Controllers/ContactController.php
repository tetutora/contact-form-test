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
        $contact['gender_name'] = $this->getGenderName($contact['gender']);

        $categoryId = $this->getCategoryId($contact['category_id']);
        $contact['category_id'] = $categoryId;

        $contact['category_name'] = $this->getCategoryName($categoryId);

        $request->session()->put('contact', $contact);

        return view('confirm', compact('contact'));
    }

    public function store(Request $request)
    {
        $contact = $request->session()->get('contact');

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

        return view('thanks', compact('contact'));
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

    private function getGenderName($genderId)
    {
        switch ($genderId) {
            case 1:
                return '男性';
            case 2:
                return '女性';
            case 3:
                return 'その他';
            default:
                return '不明';
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
        return $category ? $category->content : 'カテゴリなし';
    }

    public function thanks(){
        return view('thanks');
    }

}