<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\Product;
use App\Models\Store;
use DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::find( Auth::id());
        $products = DB::table('products')
        ->join('product_categories', 'product_categories.id', 'products.category')
        ->where('products.status', '=', '1')
        ->where('products.active', '=', '1')
        ->where('product_categories.active', '=', '1')
        ->get();
        $stores = Store::where('store_status','=','1')->get();
        $clients = Client::where('client_status','=','1')->get();
        return view('pages/home/home', compact('user', 'clients', 'products', 'stores'));
    }
}
