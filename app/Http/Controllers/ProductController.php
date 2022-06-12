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
        $products = DB::table('products')
        ->join('product_categories', 'product_categories.id', 'products.category')
        ->where('product_categories.status', '=', '1')
        ->where('product_categories.active', '=', '1')
        ->get();
        $product_category = ProductCategory::where('status', 1)
        ->where('active', 1)
        ->get();

        return view('pages.product.index', compact('user', 'product_category', 'products'));
    }

    public function addProductView() {
        $user = User::find( Auth::id() );
        $products = DB::table('products')
        ->join('product_categories', 'product_categories.id', 'products.category')
        ->where('product_categories.status', '=', '1')
        ->get();
        $product_category = ProductCategory::where('status', 1)
        ->where('active', 1)
        ->get();
        return view('partials.addProduct', compact('user', 'product_category', 'products'));
    }

    public function editProductView($id) {
        $user = User::find( Auth::id() );
        $products = Product::find($id);
        $product_category = ProductCategory::where('status', 1)
        ->where('active', 1)
        ->get();

        return view('partials.editProduct', compact('user', 'product_category', 'products'));
    }

    public function addProductStocks(Request $request) {
        DB::beginTransaction();
        try {
            $user = User::find( Auth::id() );
            if(!Hash::check($request->password, $user->password)) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Credentials not match'
                    ]
                );
            }


            $product = Product::find($request->id);
            $product->stocks = $product->stocks + $request->stocks;
            $product->update();

            $product_sale = new ProductSale();
            $product_sale->product_id = $product->id;
            $product_sale->product_qty = $request->stocks;
            $product_sale->status = 'Stocks In';
            $product_sale->save();

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

    public function addProduct(Request $request){
        DB::beginTransaction();

        try {
            
            $product = Product::where('code',$request->product_code)
            ->where('status','=','2')
            ->first();
            if( $product ) {
                $product->name = $request->product_name;
                $product->category = $request->product_category;
                $product->details = $request->product_details;
                $product->stocks = $request->product_stocks;
                $product->active = '1';
                $product->status = '1';
                $product->update();
            } else {
                $product = new Product();
                $product->code = $request->product_code;
                $product->name = $request->product_name;
                $product->category = $request->product_category;
                $product->details = $request->product_details;
                $product->stocks = $request->product_stocks;
                $product->save();
            }

            $product_sale = new ProductSale();
            $product_sale->product_id = $product->id;
            $product_sale->product_qty = $request->product_stocks;
            $product_sale->status = 'Stocks In';
            $product_sale->save();

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
        DB::beginTransaction();

        try {  

            $product = Product::find($request['id']);
            $product->code = $request['product_code'];
            $product->name = $request['product_name'];
            $product->category = $request['product_category'];
            $product->details = $request['product_details'];
            $product->stocks = $request['product_stocks'];
            $product->update();

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

    public function deleteProduct(Request $request){
        DB::beginTransaction();

        try {

            $product = Product::find($request->id);
            $product->status = 2;
            $product->update();

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
    
    public function productUpdateActive(Request $request) {
        $product = Product::find($request->id);
        $product->active = $request->active;
        $product->update();
    }

    public function productGetTableData(Request $request) {

        function active($active, $id) {
            $check = '';

            if( $active == 1 ) $check = "checked";
            
            return '
                <label class="switch">
                    <input type="checkbox" id="'.$id.'" class="checked-box" '.$check.'/>
                    <span class="slider round"></span>
                </label>
            ';
        }

        function button($type, $id, $label) {

            if( $type == 'add' ) {
                return '
                    <button type="button" id="'.$id.'" 
                    class="btn btn-info btn-sm product-add">'.$label.'</button>
                ';
            }

            if( $type == 'edit' ) {
                return '
                    <button type="button" id="'.$id.'" 
                    class="btn btn-success btn-sm product-update">'.$label.'</button>
                ';
            }
            if( $type == 'delete' ) {
                return '
                    <button type="button" id="'.$id.'" 
                    class="btn btn-danger btn-sm product-delete" 
                    data-toggle="modal" data-target="#delete_product_modal">'.$label.' 
                    
                    </button>
                ';
            }
        }


        $totalFilteredRecord = $totalDataRecord = $draw_val = "";
        $columns_list = array(
            0 => 'products.code',
            1 => 'products.name',
            2 => 'product_categories.category',
            3 => 'products.stocks'
        );
        
        $totalDataRecord = DB::table('products')
        ->join('product_categories', 'product_categories.id', 'products.category')
        ->where('product_categories.status', '=', '1')
        ->where('product_categories.active', '=', '1')
        ->where('products.status', '=', '1')
        ->count();

        
        $selected_item = ['products.id', 'products.code', 'products.name', 'product_categories.category', 'products.stocks', 'products.status', 'products.active'];
        
        $totalFilteredRecord = $totalDataRecord;
        
        $limit_val = $request->input('length');
        $start_val = $request->input('start');
        $order_val = $columns_list[$request->input('order.0.column')];
        $dir_val = $request->input('order.0.dir');
        
        if(empty($request->input('search.value')))
        {
            $post_data = DB::table('products')
            ->join('product_categories', 'product_categories.id', 'products.category')
            ->where('product_categories.status', '=', '1')
            ->where('product_categories.active', '=', '1')
            ->where('products.status', '=', '1')
            ->offset($start_val)
            ->limit($limit_val)
            ->orderBy($order_val,$dir_val)
            ->get($selected_item);
        }
        else {
            $search_text = $request->input('search.value');
            
            $post_data =  DB::table('products')
            ->join('product_categories', 'product_categories.id', 'products.category')
            ->where('product_categories.status', '=', '1')
            ->where('product_categories.active', '=', '1')
            ->where('products.status', '=', '1')
            ->where('products.code','LIKE',"%{$search_text}%")
            ->offset($start_val)
            ->limit($limit_val)
            ->orderBy($order_val,$dir_val)
            ->get($selected_item);
            
            $totalFilteredRecord =DB::table('products')
            ->join('product_categories', 'product_categories.id', 'products.category')
            ->where('product_categories.status', '=', '1')
            ->where('product_categories.active', '=', '1')
            ->where('products.status', '=', '1')
            ->where('products.code','LIKE',"%{$search_text}%")
            ->count();
        }
        
        $data_val = array();
        if(!empty($post_data))
        {
            // print_r($post_data);
            // print_r($post_data);
            foreach ($post_data as $post_val)
            {
                
                $postnestedData['code'] = $post_val->code;
                $postnestedData['name'] = $post_val->name;
                $postnestedData['category'] = $post_val->category;
                $postnestedData['stocks'] = $post_val->stocks;
                $postnestedData['status'] = active($post_val->active, $post_val->id);
                $postnestedData['action'] = button('add', $post_val->id, 'Add Stocks');
                $postnestedData['action'] .= button('edit', $post_val->id, 'Edit');
                $postnestedData['action'] .= button('delete', $post_val->id, 'Delete');
                $data_val[] = $postnestedData;
                
            }
        }

        $draw_val = $request->input('draw');
        $get_json_data = array(
        "draw"            => intval($draw_val),
        "recordsTotal"    => intval($totalDataRecord),
        "recordsFiltered" => intval($totalFilteredRecord),
        "data"            => $data_val,
        );
        
        echo json_encode($get_json_data);

        
    }
}
