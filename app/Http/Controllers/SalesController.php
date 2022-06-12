<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductSale;
use App\Models\ProductCategory;


use DB;
use Auth;
use Hash;

class SalesController extends Controller
{
    public function getSalesView() {
        $user = User::find( Auth::id() );
        $products = DB::table('products')
        ->join('product_categories', 'product_categories.id', 'products.category')
        ->where('product_categories.status', '=', '1')
        ->where('product_categories.active', '=', '1')
        ->get();
        $product_category = ProductCategory::where('status', 1)
        ->where('active', 1)
        ->get();

        return view('pages.sales.index', compact('user', 'product_category', 'products'));
    }
}
