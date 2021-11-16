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
    public function transformstock(Request $request)
    {
        $v = Validator::make($request->all(), [
            'magasin1' => 'required|max:255',
            'magasin2' => 'required|max:255',
            'fruit' => 'required|max:255',
            /*      'namecategory' => 'required|max:255',*/


            'nbretransorme' => 'required|int',


        ]);

        if ($v->fails()) {

            return response()->json([
                'status' => 'error',
                'errors' => $v->errors(),
            ], 422);
        }
        $stock1 = Stock::where('magasin', $request->magasin1)->first();
        $stock2 = Stock::where('magasin', $request->magasin2)->first();
        echo "before " . $stock1;
        echo "before2 " . $stock2;
        $t = [];
        // $stock2 = Stock::where('magasin',$request->magasin2)->first();
        foreach ($stock1->stock as $value) {
            if ($request->fruit == $value["key"]) {
                if ($request->nbretransorme > $value["value"]) {
                    $request->nbretransorme = $value["value"];
                    $value["value"] = $value["value"] -  $request->nbretransorme;
                    array_push($t, $value);
                } else {
                    $value["value"] = $value["value"] -  $request->nbretransorme;
                    array_push($t, $value);
                }
            } else {
                array_push($t, $value);
            }
        }
        $t2 = [];
        foreach ($stock2->stock as $value) {
            if ($request->fruit == $value["key"]) {
                $value["value"] = $value["value"] +  $request->nbretransorme;
                array_push($t2, $value);
            } else {
                array_push($t2, $value);
            }
        }
        $stock1->stock = $t;
        $stock2->stock = $t2;
        echo "after " . $stock1;
        echo "after2 " . $stock2;
    }
}
