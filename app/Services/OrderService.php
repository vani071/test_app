<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;

class OrderService
{
    public function addToCart($request){

        $product = Product::where('sku','=',$request['sku'])->first();

        if(empty($product)) throw new Exception("product not found", 1);     

        if(isset($request['order_id'])){
            $order = Order::find($request['order_id']);
            $orderItem = OrderItem::where('order_id',$request['order_id'])
                         ->where('sku',$request['sku'])->first();

            if(empty($orderItem)){
                $orderItem = new OrderItem;
                $orderItem->order_id = $request['order_id'];
                $orderItem->sku = $request['sku'];
                $orderItem->qty = $request['qty'];
                $orderItem->price = $product->price;

                try {
                    $orderItem->save();
                } catch (\Exception $th) {
                    return ["status"=>500,
                    "message"=>"can't save order item".$request['sku'],
                    "result"=>[]
                    ];
                }

                try {
                    if(empty($product)){
                        return ["status"=>404,
                                "message"=>"product not found : ".$request['sku'],
                                "result"=>[]
                                ];
                
                    }elseif($product->reserved_qty == 0){
                        return ["status"=>404,
                                "message"=>"product stock empty: ".$request['sku'],
                                "result"=>[]
                                ];
                    }
                } catch (\Exception $th) {
                    return ["status"=>500,
                    "message"=>"can't save stock product :".$request['sku'],
                    "result"=>[]
                    ];
                }

            }else{
                $totalItem = $orderItem->qty + $request['qty'];

                if($totalItem > $product->reserved_qty) throw new Exception("Requested stock is more than limit", 1);
                
                $orderItem->qty = $totalItem;
                $orderItem->save();
            }

        }else{
            $order = new Order;
            $order->status = 'in_cart';
            $order->grand_total = $product->price;
            $order->created_at = date('Y-m-d H:i:s');
            $order->updated_at = date('Y-m-d H:i:s');
            $order->save();

            $orderItem = new OrderItem;
            $orderItem->order_id = $order->id;
            $orderItem->sku = $request['sku'];
            $orderItem->qty = $request['qty'];
            $orderItem->price = $product->price;
                
            try {
                $orderItem->save();
            } catch (\Exception $th) {
                return ["status"=>500,
                "message"=>"can't save order item".$request['sku'],
                "result"=>[]
                ];
            }

            try {
                if(empty($product)){
                    return ["status"=>404,
                            "message"=>"product not found : ".$request['sku'],
                            "result"=>[]
                            ];
            
                }elseif($product->reserved_qty == 0){
                    return ["status"=>404,
                            "message"=>"product stock empty: ".$request['sku'],
                            "result"=>[]
                            ];
                }
            } catch (\Exception $th) {
                return ["status"=>500,
                            "message"=>"can't save stock product",
                            "result"=>[]
                            ];
            }
            
        }
        
        $orderItems = $this->reTotalOrder($order);

        return ["status"=>200,
                "message"=>'Success Add '.$request['sku'],
                "result"=>[
                    "order_id"=>$order->id,
                    "grand_total"=>$order->grand_total,
                    "order_item"=> $orderItems
                    ]
                ];
    }

    public function reTotalOrder($order){
        $orderItems = OrderItem::where('order_id',$order->id)->get();
        $grandTotal = 0;

        foreach ($orderItems as $items) {
            $itemPrice = $items['price']*$items['qty'];
            $grandTotal =$grandTotal+ $itemPrice;
            $itemPrice = 0;
        }

        $order->grand_total = $grandTotal;
        $order->updated_at = date('Y-m-d H:i:s');
        $order->save();
        return $orderItems;
    }

    public function checkout($request){
        $order = Order::find($request['order_id']);

        $orderItems = OrderItem::where('order_id',$order->id)->get();

        foreach ($orderItems as $items) {
          
            $product = Product::where('sku','=',$items['sku'])->first();
            if($product->reserved_qty < $items['qty']){
                return ["status"=>401,
                        "message"=>"Requested stock for ".$items['sku']." is more than limit",
                        "result"=>[]
                ];
            } 
            
        }

        foreach ($orderItems as $items) {
            $product = Product::where('sku','=',$items['sku'])->first();
            $product->reserved_qty = $product->reserved_qty - $items['qty'];
            $product->save();
        }

        $order->status = 'pending_payment';
        $order->save();
        
        return ["status"=>200,
                "message"=>'Success create order ',
                "result"=>[
                    "order_id"=>$order->id,
                    "grand_total"=>$order->grand_total,
                    "order_status"=>$order->status,
                    "order_item"=> $orderItems
                    ]
                ];

    }

    public function cancel($request){
        $order = Order::find($request['order_id']);

        $orderItems = OrderItem::where('order_id',$order->id)->get();

        foreach ($orderItems as $items) {
            $product = Product::where('sku','=',$items['sku'])->first();
            $product->reserved_qty = $product->reserved_qty + $items['qty'];
            $product->save();
        }

        $order->status = 'cancel';
        $order->save();
        
        return ["status"=>200,
                "message"=>'Success cancel order ',
                "result"=>[
                    "order_id"=>$order->id,
                    "grand_total"=>$order->grand_total,
                    "order_status"=>$order->status,
                    "order_item"=> $orderItems
                    ]
                ];

    }

    public function paid($request){
        $order = Order::find($request['order_id']);

        $orderItems = OrderItem::where('order_id',$order->id)->get();

        foreach ($orderItems as $items) {
            $product = Product::where('sku','=',$items['sku'])->first();
            $product->qty = $product->qty - $items['qty'];
            $product->save();
        }

        $order->status = 'paid';
        $order->save();
        
        return ["status"=>200,
                "message"=>'Success pay order ',
                "result"=>[
                    "order_id"=>$order->id,
                    "grand_total"=>$order->grand_total,
                    "order_status"=>$order->status,
                    "order_item"=> $orderItems
                    ]
                ];

    }

}