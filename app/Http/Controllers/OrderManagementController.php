<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProductCategory;
use App\Models\Client;
use Auth;
use DB;
use Exception;

class OrderManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getOrderIndex() {

        $user = User::find( Auth::id() );
        $products = DB::table('products')
        ->join('product_categories', 'product_categories.id', 'products.category')
        ->where('product_categories.status', '=', '1')
        ->where('product_categories.active', '=', '1')
        ->get();
        $product_category = ProductCategory::where('status', 1)
        ->where('active', 1)
        ->get();

        return view('pages.order.index', compact('user', 'product_category', 'products'));
    }

    public function addOrderView() {
        $user = User::find( Auth::id() );
        $products = DB::table('products')
        ->join('product_categories', 'product_categories.id', 'products.category')
        ->where('product_categories.status', '=', '1')
        ->get();
        $product_category = ProductCategory::where('status', 1)->where('active', 1)->get();
        $client = Client::where('client_status', 1)->where('client_active', 1)->get();
        return view('partials.addOrder', compact('user', 'product_category', 'products', 'client'));
    }
}
