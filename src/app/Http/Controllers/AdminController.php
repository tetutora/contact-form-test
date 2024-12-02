<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // 検索機能があれば、検索条件に基づいてフィルタリング
        $contacts = Contact::when($request->keyword, function($query, $keyword) {
            return $query->where('name', 'like', "%{$keyword}%")->orWhere('email', 'like', "%{$keyword}%");
        })
        ->paginate(7); // ページネーションを使用

        // ビューに contacts を渡す
        return view('admin', compact('contacts'));
    }

    public function search(Request $request)
    {
        // 検索条件を取得
        $keyword = $request->input('keyword');
        $gender = $request->input('gender');
        $category = $request->input('category');
        $date = $request->input('date');

        $query = Contact::query();

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('last_name', 'like', "%{$keyword}%")
                    ->orWhere('first_name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        if ($gender) {
            $query->where('gender', $gender);
        }

        if ($category) {
            $query->where('category_id', $category);
        }

        if ($date) {
            $query->whereDate('created_at', $date);
        }

        $contacts = $query->paginate(7);

        return view('admin', compact('contacts'));
    }
}
