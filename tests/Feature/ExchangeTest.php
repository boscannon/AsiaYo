<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ExchangeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    //測試 路徑能否正常訪問 即回傳參數是否正常
    public function test_success()
    {
        $response = $this->post('/api/exchange', [
            'source_currency' => 'USD',
            'target_currency' => 'JPY',
            'amount' => 101.75,
        ]);

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json){
            $json->has('amount')->where('message', '查詢成功');
        });
    }


    //測試 錯誤狀態及回傳訊息
    public function test_error()
    {
        $response = $this->post('/api/exchange', [
            'source_currency' => 'USD11',
            'target_currency' => 'JPY11',
            'amount' => 101.75,
        ]);

        $response->assertStatus(422);
        $response->assertJson(function (AssertableJson $json){
            $json->has('message');
        });
    }

}
