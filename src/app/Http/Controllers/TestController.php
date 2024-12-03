<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;


class TestController extends Controller
{
    public function test()
    {
        return view('test');
    }

    public function store(Request $request)
    {
        $contact = $request->only([
            'last_name', 'first_name', 'gender', 'email', 'tel1', 'tel2', 'tel3', 'address', 'building', 'category_id', 'detail'
        ]);

        $contact['gender'] = $this->getGenderId($contact['gender']);

        $categoryId = $this->getCategoryId($contact['category_id']);
$contact['category_id'] = $categoryId;
        

        Contact::create($contact);

        return redirect('/');
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
            return null; // デフォルト値を返す
    }
}
    private function getCategoryId($categoryName)
{
    $category = Category::where('content', $categoryName)->first();
    return $category ? $category->id : null;
}

}
