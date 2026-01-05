<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $categories = [
            1 => '商品について',
            2 => '配送について',
            3 => '返品・交換について',
            4 => 'その他',
        ];

        return view('index', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->only([
            'last_name',
            'first_name',
            'gender',
            'email',
            'tel',
            'address',
            'building',
            'category_id',
            'detail',
        ]);

        $categories = [
            1 => '商品について',
            2 => '配送について',
            3 => '返品・交換について',
            4 => 'その他',
        ];

        return view('confirm', compact('contact', 'categories'));
    }

    public function store(ContactRequest $request)
    {
        $contact = $request->only([
            'last_name',
            'first_name',
            'gender',
            'email',
            'tel',
            'address',
            'building',
            'category_id',
            'detail',
        ]);

        Contact::create($contact);

        return view('thanks');
    }
}
