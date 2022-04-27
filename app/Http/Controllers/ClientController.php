<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProductCategory;
use App\Models\Client;
use Auth;
use Exception;
use DB;

class ClientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getClientIndex(){
        $user = User::find( Auth::id() );
        return view('pages.client.index', compact('user'));
    }



    public function addClient(Request $request)
    {
        DB::beginTransaction();

        try {

            $client = Client::where('client_name',$request->client_name)
            ->where('client_address', $request->client_address)
            ->where('client_status','=','1')
            ->first();

            if($client) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Duplicate Entry for name '.$request->client_name.' and his/her address was located at '. $request->client_address
                    ]
                );
            }
            
            $client = Client::where('client_name',$request->client_name)
            ->where('client_address', $request->client_address)
            ->where('client_status','=','2')
            ->first();

            if($client) {
                $client->client_name = $request->client_name;
                $client->client_phone = $request->client_phone;
                $client->client_address = $request->client_address;
                $client->client_active = '1';
                $client->client_status = '1';
                $client->update();
            } else {
                $client = new Client();
                $client->client_name = $request->client_name;
                $client->client_phone = $request->client_phone;
                $client->client_address = $request->client_address;
                $client->save();
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

    public function editClient(Request $request) {
        DB::beginTransaction();

        try {

            $client = Client::where('client_name',$request->client_name)
            ->where('client_address', $request->client_address)
            ->where('client_status','=','1')
            ->first();

            if($client) {
                if($client->id != $request->id) {
                    return response()->json(
                        [
                            'success' => false,
                            'message' => 'Duplicate Entry for name '.$request->client_name.' and his/her address was located at '. $request->client_address
                        ]
                    );
                }
            }
            
            $client = Client::find($request->id);
            $client->client_name = $request->client_name;
            $client->client_phone = $request->client_phone;
            $client->client_address = $request->client_address;
            $client->update();

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

    public function deleteClient(Request $request) {
        DB::beginTransaction();

        try {

            $store = Client::find($request->id);
            $store->client_status = 2;
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

    public function clientUpdateActive(Request $request) {
        $client = Client::find($request->id);
        $client->client_active = $request->active;
        $client->update();
    }

    public function getClientTable(Request $request) {

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
                    class="btn btn-success btn-sm client-update" 
                    data-toggle="modal" 
                    data-target="#edit_client_modal">'.$label.'</button>
                ';
            }
            if( $type == 'delete' ) {
                return '
                    <button type="button" id="'.$id.'" 
                    class="btn btn-danger btn-sm client-delete" 
                    data-toggle="modal" 
                    data-target="#delete_client_modal">'.$label.'</button>
                ';
            }
        }

        $totalFilteredRecord = $totalDataRecord = $draw_val = "";
        $columns_list = array(
            0 => 'id',
            1 => 'client_name',
            2 => 'client_address',
            3 => 'client_phone',
        );
        
        $totalDataRecord = Client::where('client_status', '1')->count();
        
        $totalFilteredRecord = $totalDataRecord;
        
        $limit_val = $request->input('length');
        $start_val = $request->input('start');
        $order_val = $columns_list[$request->input('order.0.column')];
        $dir_val = $request->input('order.0.dir');
        
        if(empty($request->input('search.value')))
        {
        $post_data = Client::offset($start_val)
        ->where('client_status', '1')
        ->limit($limit_val)
        ->orderBy($order_val,$dir_val)
        ->get();
        }
        else {
        $search_text = $request->input('search.value');
        
        $post_data =  Client::where('client_name','LIKE',"%{$search_text}%")
        ->where('client_status', '1')
        ->offset($start_val)
        ->limit($limit_val)
        ->orderBy($order_val,$dir_val)
        ->get();
        
        $totalFilteredRecord = Client::where('client_name','LIKE',"%{$search_text}%")
            ->where('client_status', '1')
            ->count();
        }
        
        $data_val = array();
        if(!empty($post_data))
        {
            foreach ($post_data as $key => $post_val)
            {
                $postnestedData['id'] = $key + 1;
                $postnestedData['name'] = $post_val->client_name;
                $postnestedData['phone'] = $post_val->client_phone;
                $postnestedData['address'] = $post_val->client_address;
                $postnestedData['active'] = active($post_val->client_active, $post_val->id);
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
