<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

class ExchangeController extends Controller
{
    public function exchange(Request $request)
    {
        try{
            Validator::make($request->all(), [
                'credit_card_number' => 'required_if:payment_type,cc',
                'credit_card_number' => 'required_if:payment_type,cc',
                'credit_card_number' => 'required_if:payment_type,cc',
            ], [], [
                'title'      => '來源幣別',
                'message'    => '目標幣別',
                'message'    => '金額數字',
            ]);
            return response()->json(['message' => '查詢成功', 'data' => $data]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()],422);
        }
    }
}
