<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    // ログイン必須
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 管理画面トップ（一覧表示）
    public function index(Request $request)
    {
        // ページネーション付きで全件取得
        $contacts = Contact::paginate(7);

        return view('admin', compact('contacts'));
    }

    // 検索機能
    public function search(Request $request)
    {
        $query = Contact::query();

        // 名前検索（姓・名・フルネーム部分一致）
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('last_name', 'like', "%{$keyword}%")
                    ->orWhere('first_name', 'like', "%{$keyword}%")
                    ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ["%{$keyword}%"]);
            });
        }

        // メールアドレス検索（部分一致）
        if ($request->filled('email')) {
            $email = $request->input('email');
            $query->where('email', 'like', "%{$email}%");
        }

        // 性別検索
        if ($request->filled('gender') && $request->gender != '') {
            $query->where('gender', $request->gender);
        }

        // お問い合わせ種類検索
        if ($request->filled('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        // 日付検索
        if ($request->filled('date') && $request->date != '') {
            $query->whereDate('created_at', $request->date);
        }

        // ページネーション
        $contacts = $query->paginate(7)->withQueryString();

        return view('admin', compact('contacts'));
    }

    // リセット機能
    public function reset()
    {
        return redirect('/admin');
    }

    // 削除機能
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->back()->with('message', '削除しました');
    }

    public function export(Request $request)
    {
        // 検索条件を取得
        $query = Contact::query();

        if ($request->keyword) {
            $query->where(function ($q) use ($request) {
                $q->where('last_name', 'like', "%{$request->keyword}%")
                    ->orWhere('first_name', 'like', "%{$request->keyword}%")
                    ->orWhere('email', 'like', "%{$request->keyword}%");
            });
        }

        if ($request->gender) {
            $query->where('gender', $request->gender);
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        $contacts = $query->get();

        // CSV作成
        $csvHeader = ['名前', '性別', 'メールアドレス', '電話番号', '住所', '建物名', 'お問い合わせ種類', 'お問い合わせ内容'];
        $csvData = [];

        foreach ($contacts as $contact) {
            $csvData[] = [
                $contact->last_name . ' ' . $contact->first_name,
                $contact->gender === 1 ? '男性' : ($contact->gender === 2 ? '女性' : 'その他'),
                $contact->email,
                $contact->tel,
                $contact->address,
                $contact->building,
                match ($contact->category_id) {
                    1 => '商品のお届けについて',
                    2 => '商品の交換について',
                    3 => '商品トラブル',
                    4 => 'ショップへのお問い合わせ',
                    5 => 'その他',
                    default => '-',
                },
                $contact->content
            ];
        }

        // CSV出力
        $filename = 'contacts_' . date('Ymd_His') . '.csv';
        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, $csvHeader);

        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}"
        ]);
    }
}
