<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('test1', function () {
    $time_start = microtime(true);

    $sql = 'SELECT count(*) as orderCount, property.name from property
    LEFT JOIN room on property.id = room.property_id
    LEFT JOIN orders on room.id = orders.room_id
    where MONTH(orders.created_at) = 2 and YEAR(orders.created_at) = 2021
    GROUP BY property.name
    ORDER BY orderCount desc
    LIMIT 10';

    $data = DB::select($sql);
    //取前 10 名的旅宿
    $answer = array_column($data, 'name');
    dump($answer);
    dd(microtime(true) - $time_start);
})->purpose('Display an inspiring quote');

Artisan::command('test2', function () {
    $time_start = microtime(true);

    //查詢 房間訂單數量及id
    $sql = 'SELECT count(*) as orderCount, room_id from orders
    where MONTH(created_at) = 2 and YEAR(created_at) = 2021
    GROUP BY room_id';

    $orders = DB::select($sql);
    $romm_arr = array_column($orders , 'orderCount' ,'room_id');

    //查詢 旅宿id及對應房間id
    $sql = 'SELECT property_id, id from room
    where id in ('. implode(',', array_keys($romm_arr)) .')';
    $room = DB::select($sql);

    //計算 旅宿 底下的訂單數量
    $data = [];
    foreach ($room as $key => $value) {
        if(empty($data[$value->property_id])){
            $data[$value->property_id] = [
                'orderCount' => 0,
                'property_id' => $value->property_id,
            ];
        } 
        $data[$value->property_id]['orderCount'] += $romm_arr[$value->id];
    }

    array_multisort(array_column($data, 'orderCount'), SORT_DESC, $data);
    
    //取前 10 名的旅宿
    $data = array_slice($data, 0, 10);

    $sql = 'SELECT id, name from property
    where id in ('. implode(',', array_column($data, 'property_id')) .')';

    $property = DB::select($sql);
    $property_arr = array_column($property , 'name' ,'id');
    
    foreach ($data as $key => &$item) {
        $item['name'] = $property_arr[$item['property_id']];
    }
    
    $answer = array_column($data, 'name');
    dump($answer);
    dd(microtime(true) - $time_start);
})->purpose('Display an inspiring quote');