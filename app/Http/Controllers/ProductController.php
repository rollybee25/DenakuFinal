<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductCategory;
use DB;
use Auth;

class ProductController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function sampleCropper() {
        return view('modal.product.add');
    }

    public function getProductIndex(){
        $user = User::find( Auth::id() );
        $products = Product::all();
        $product_category = ProductCategory::where('status', 1)
        ->where('active', 1)
        ->get();

        return view('pages.product.index', compact('user', 'product_category', 'products'));
    }

    public function addProductView() {
        $user = User::find( Auth::id() );
        $products = Product::all();
        $product_category = ProductCategory::where('status', 1)
        ->where('active', 1)
        ->get();
        return view('partials.addProduct', compact('user', 'product_category', 'products'));
    }

    public function addProduct(Request $request){
        DB::beginTransaction();

        try {  

            $product = new Product();
            $product->code = $request->product_code;
            $product->name = $request->product_name;
            $product->category = $request->product_category;
            $product->details = $request->product_details;
            $product->stocks = $request->product_stocks;
            $product->save();

            DB::commit();
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Success'
                ]
            );

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(
                [
                    'success' => false,
                    'message' => $e->getMessage()
                ]
            );
        }
    }

    public function editProduct(Request $request){
        
    }

    public function deleteProduct(Request $request){
        
    }
}
