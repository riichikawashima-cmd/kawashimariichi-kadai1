<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Models\Contact;

class FormController extends Controller
{
    // 入力ページ
    public function index()
    {
        $categories = [
            1 => '商品について',
            2 => '支払いについて',
            3 => 'サービスについて',
            4 => 'その他',
        ];

        return view('index', compact('categories'));
    }

    // 確認画面
    public function confirm(ContactFormRequest $request)
    {
        $contact = $request->all();

        $categories = [
            1 => '商品について',
            2 => '支払いについて',
            3 => 'サービスについて',
            4 => 'その他',
        ];

        return view('confirm', compact('contact', 'categories'));
    }

    // 保存処理
    public function store(ContactFormRequest $request)
    {
        $tel = $request->tel1 . $request->tel2 . $request->tel3;

        Contact::create([
            'last_name'   => $request->last_name,
            'first_name'  => $request->first_name,
            'gender'      => $request->gender,
            'email'       => $request->email,
            'tel'         => $tel,
            'address'     => $request->address,
            'building'    => $request->building,
            'category_id' => $request->category_id,
            'detail'      => $request->content,
        ]);

        return view('thanks');
    }
}
