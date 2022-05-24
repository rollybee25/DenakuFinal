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
        ->get(['products.id', 'products.name', 'products.stocks', 'products.code', 'product_categories.category']);
        $product_category = ProductCategory::where('status', 1)->where('active', 1)->get();
        $client = Client::where('client_status', 1)->where('client_active', 1)->get();
        return view('pages.pos.index', compact('user', 'product_category', 'products', 'client'));
    }
}
