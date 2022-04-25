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

    public function addStore(Request $request)
    {
        DB::beginTransaction();

        try {
            
            $store = Store::where('store_code',$request->store_code)
            ->where('store_status','=','2')
            ->first();
            if( $store ) {
                $store->store_name = $request->store_name;
                $store->store_phone = $request->store_phone;
                $store->store_address = $request->store_address;
                $store->store_active = '1';
                $store->store_status = '1';
                $store->update();
            } else {
                $store = new Store();
                $store->store_code = $request->store_code;
                $store->store_name = $request->store_name;
                $store->store_phone = $request->store_phone;
                $store->store_address = $request->store_address;
                $store->save();
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

    public function editStore(Request $request)
    {
        DB::beginTransaction();

        try {
            
            $store = Store::where('id',$request->id)->first();
            $store->store_code = $request->store_code;
            $store->store_name = $request->store_name;
            $store->store_phone = $request->store_phone;
            $store->store_address = $request->store_address;
            $store->update();
            

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

    public function deleteStore(Request $request) {
        DB::beginTransaction();

        try {

            $store = Store::find($request->id);
            $store->store_status = 2;
            $store->update();

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

    public function storeUpdateActive(Request $request) {
        $store = Store::find($request->id);
        $store->store_active = $request->active;
        $store->update();
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
                    class="btn btn-success btn-sm store-update" 
                    data-toggle="modal" 
                    data-target="#edit_store_modal">'.$label.'</button>
                ';
            }
            if( $type == 'delete' ) {
                return '
                    <button type="button" id="'.$id.'" 
                    class="btn btn-danger btn-sm store-delete" 
                    data-toggle="modal" 
                    data-target="#delete_store_modal">'.$label.'</button>
                ';
            }
        }

        $totalFilteredRecord = $totalDataRecord = $draw_val = "";
        $columns_list = array(
            0 => 'id',
            2 => 'store_code',
            3 => 'store_name',
            4 => 'store_address',
            5 => 'store_phone',
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
                $postnestedData['phone'] = $post_val->store_phone;
                $postnestedData['address'] = $post_val->store_address;
                $postnestedData['active'] = active($post_val->store_active, $post_val->id);
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
