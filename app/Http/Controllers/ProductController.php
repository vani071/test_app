<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class ProductController extends Controller
{
    public function getProductList(Request $request){

        return response()->json([
            "status"=>200,
            "message"=>"success",
            "result"=> Product::paginate(10)]
        );

    }
}