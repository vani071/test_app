<?php

namespace App\Services;

class OrderService
{
    public function addToCart($request){
        return ["status"=>200,
                "message"=>'Success Add'.$request->sku,
                "result"=>[
                    "cart"=>["bla"]
                    ]];
    }
}