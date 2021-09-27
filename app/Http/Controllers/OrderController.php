<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function cancel(Request $request,OrderService $orderService){
        $validator =  Validator::make($request->all(), [
            'order_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "status"=>401,
                    "message"=>$validator->errors()->toArray(),
                    "result"=>[]
                ], 400);
        }

        return response()->json($orderService->cancel($request->all()));

    }

    public function pay(Request $request,OrderService $orderService){
        $validator =  Validator::make($request->all(), [
            'order_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "status"=>401,
                    "message"=>$validator->errors()->toArray(),
                    "result"=>[]
                ], 400);
        }

        return response()->json($orderService->paid($request->all()));

    }
}