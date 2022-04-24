<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Store;
use DB;
use Auth;

class StoreManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getStoreIndex() {
        $user = User::find( Auth::id() );
        $products = DB::table('products')
        ->join('product_categories', 'product_categories.id', 'products.category')
        ->where('product_categories.status', '=', '1')
        ->where('product_categories.active', '=', '1')
        ->get();
        $product_category = ProductCategory::where('status', 1)
        ->where('active', 1)
        ->get();

        return view('pages.store.index', compact('user', 'product_category', 'products'));
    }

    public function storeGetTableData(Request $request) {

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

            if( $type == 'edit' ) {
                return '
                    <button type="button" id="'.$id.'" 
                    class="btn btn-success btn-sm category-update" 
                    data-toggle="modal" 
                    data-target="#edit_category_product_modal">'.$label.'</button>
                ';
            }
            if( $type == 'delete' ) {
                return '
                    <button type="button" id="'.$id.'" 
                    class="btn btn-danger btn-sm category-delete" 
                    data-toggle="modal" 
                    data-target="#delete_category_product_modal">'.$label.'</button>
                ';
            }
        }

        $totalFilteredRecord = $totalDataRecord = $draw_val = "";
        $columns_list = array(
            0 => 'id',
            1 => 'store_code',
        );
        
        $totalDataRecord = Store::where('store_status', '1')->count();
        
        $totalFilteredRecord = $totalDataRecord;
        
        $limit_val = $request->input('length');
        $start_val = $request->input('start');
        $order_val = $columns_list[$request->input('order.0.column')];
        $dir_val = $request->input('order.0.dir');
        
        if(empty($request->input('search.value')))
        {
        $post_data = Store::offset($start_val)
        ->where('store_status', '1')
        ->limit($limit_val)
        ->orderBy($order_val,$dir_val)
        ->get();
        }
        else {
        $search_text = $request->input('search.value');
        
        $post_data =  Store::where('store_code','LIKE',"%{$search_text}%")
        ->where('store_status', '1')
        ->offset($start_val)
        ->limit($limit_val)
        ->orderBy($order_val,$dir_val)
        ->get();
        
        $totalFilteredRecord = Store::where('store_code','LIKE',"%{$search_text}%")
            ->where('store_status', '1')
            ->count();
        }
        
        $data_val = array();
        if(!empty($post_data))
        {
            foreach ($post_data as $key => $post_val)
            {


            $postnestedData['id'] = $key + 1;
            $postnestedData['code'] = $post_val->store_code;
            $postnestedData['name'] = $post_val->store_name;
            $postnestedData['active'] = active($post_val->active, $post_val->id);
            $postnestedData['action'] = button('edit', $post_val->id, 'Edit');
            $postnestedData['action'] .= button('delete', $post_val->id, 'Delete');
            $data_val[] = $postnestedData;
            
            }
        }
        $draw_val = $request->input('draw');
        $get_json_data = array(
        "draw"            => intval($draw_val),
        "recordsTotal"    => intval($totalDataRecord),
        "recordsFiltered" => intval($totalFilteredRecord),
        "data"            => $data_val
        );
        
        echo json_encode($get_json_data);
    }
}
