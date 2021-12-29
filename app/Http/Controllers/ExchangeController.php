<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Validator;
use Illuminate\Validation\Rule;

class ExchangeController extends Controller
{
    public function index(Request $request)
    {
        $validator_currency = ['required', Rule::in(['TWD', 'JPY', 'USD'])];

        $rules =  [
            'source_currency' => $validator_currency,
            'target_currency' => $validator_currency,
            'amount' => ['required', 'numeric'],
        ];

        $messages = [];

        $attributes = [
            'source_currency'      => '來源幣別',
            'target_currency'    => '目標幣別',
            'amount'    => '金額數字',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            $errors = $validator->errors()->first();
            return response()->json(['message' => $errors], 422);

        }

        $change = [
            'currencies' => 
            [
                'TWD' => 
                [
                    'TWD' => 1,
                    'JPY' => 3.669,
                    'USD' => 0.03281,
                ],
                'JPY' => 
                [
                    'TWD' => 0.26956,
                    'JPY' => 1,
                    'USD' => 0.00885,
                ],
                'USD' => 
                [
                    'TWD' => 30.444,
                    'JPY' => 111.801,
                    'USD' => 1,
                ],
            ],
        ];
        $amount = $request->amount * $change['currencies'][$request->source_currency][$request->target_currency];
        $amount = number_format($amount, 2);
        return response()->json(['message' => '查詢成功', 'amount' => $amount]);
    }
}
