<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function storeproduct(Request $request)
    {
        $v = Validator::make($request->all(), [
            'magasin' => 'required|max:255',

            /*      'namecategory' => 'required|max:255',*/


            'stock' => 'required',


        ]);

        if ($v->fails()) {

            return response()->json([
                'status' => 'error',
                'errors' => $v->errors(),
            ], 422);
        }

        /*      $categroy = Category::where('name', $request->namecategory)->first();
        $subcategory = Category::where('name', $request->namesubcategory)->first();*/
        // $subcategory = Category::where("_id",$request->subcategory)->first();
        // $category= $subcategory->parent_id ;

        $stock = new Stock();
        $stock->magasin = $request->magasin;
        $stock->stock = $request->stock;

        $stock->save();
        return response()->json(['message' => 'data saved successfully'], 200);
    }
    public function getallstock()
    {
        $stock = Stock::all();
        return response()->json(['stock' => $stock], 200);
    }
}
