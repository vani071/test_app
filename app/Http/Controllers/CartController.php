<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\OrderService;

class CartController extends Controller
{
    public function addProduct(Request $request,OrderService $orderService){
        $validator =  Validator::make($request->all(), [
            'sku' => 'required',
            'qty' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "status"=>401,
                    "message"=>$validator->errors()->toArray(),
                    "result"=>[]
                ], 400);
        }

        return response()->json($orderService->addToCart($request->all()));


    }
}
