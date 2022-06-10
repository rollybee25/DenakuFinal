<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProductCategory;
use App\Models\Client;
use App\Models\Product;
use Auth;
use DB;
use Exception;


class PointOfSaleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getPOSView() {
        $user = User::find( Auth::id() );
        $products = DB::table('products')
        ->join('product_categories', 'product_categories.id', 'products.category')
        ->where('product_categories.status', '=', '1')
        ->where('products.stocks', '>', '0')
        ->orderBy('products.name')
        ->get(['products.id', 'products.name', 'products.stocks', 'products.code', 'product_categories.category']);
        $product_category = ProductCategory::where('status', 1)->where('active', 1)->get();
        $client = Client::where('client_status', 1)->where('client_active', 1)->get();
        return view('pages.pos.index', compact('user', 'product_category', 'products', 'client'));
    }

    public function addSale(Request $request) {
        
        DB::beginTransaction();

        try {

            $id = DB::table('sales')->insertGetId(
                [
                    'client_id' => $request->client_id,
                    'status' => 'Pending',
                ]
            );
            $order_list = json_decode($request->orders);
            $out_of_stock = array();

            foreach ($order_list as $key => $order) {

                $product = Product::find($order->id);

                if( $product->stocks < $order->stocks )
                {
                    $out_of_stock[] = $order->id;
                } else {
                    $product->stocks = $product->stocks - $order->stocks;
                    $product->update();
                }

                DB::table('product_sales')->insert([
                    'sales_id' => $id,
                    'product_id' => $order->id,
                    'product_qty' => $order->stocks,
                    'status' => 'Stocks Out'
                ]);
            }

            if( count($out_of_stock ) > 0 ) {
                DB::rollback();
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Out of Stocks',
                        'items' => $out_of_stock,
                    ]
                );
            }

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

    public function editSales(Request $request) {

    }

    public function returnItem(Request $request) {
        
    }

    public function cancelSales(Request $request) {
        
    }
}
