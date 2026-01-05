<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contact;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition()
    {
        $details = [
            '商品の到着予定日について教えてください。',
            '注文内容を変更したいです。手続き方法を教えてください。',
            '届いた商品に不具合がありました。交換できますか？',
            '返品の手順を教えてください。',
            '支払い方法を変更できますか？',
            '領収書を発行してほしいです。',
            '会員情報の変更方法を教えてください。',
            '配送先住所を変更したいです。',
            'ポイントの使い方を教えてください。',
            'その他お問い合わせです。',
        ];

        return [
            'last_name'   => $this->faker->lastName(),
            'first_name'  => $this->faker->firstName(),
            'gender'      => $this->faker->numberBetween(1, 2),
            'email'       => $this->faker->unique()->safeEmail(),
            'tel'         => '090' . $this->faker->numberBetween(10000000, 99999999),
            // 郵便番号なし（都道府県+市区町村+番地）
            'address'     => $this->faker->prefecture() . $this->faker->city() . $this->faker->streetAddress(),
            'building'    => $this->faker->optional()->secondaryAddress(),
            'category_id' => $this->faker->numberBetween(1, 5),
            // 日本語の問い合わせ内容をランダム
            'detail'      => $this->faker->randomElement($details),
        ];
    }
}
