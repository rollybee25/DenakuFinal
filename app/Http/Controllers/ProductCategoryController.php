<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProductCategory;
use Auth;
use Exception;
use DB;

class ProductCategoryController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getCategoryIndex(){
        $user = User::find( Auth::id() );
        return view('pages.product.category', compact('user'));
    }

    public function updateActive(Request $request) {
        $category = ProductCategory::find($request->id);
        $category->active = $request->active;
        $category->update();
    }

    public function addCategory(Request $request){
        DB::beginTransaction();

        function unlinked($file) {
            $destination = public_path() . '/images/' . $file;
            unlink($destination);
        }

        try {

            //find if added already
            $category = ProductCategory::where('category',$request->category_name)
                ->where('status','=','2')
                ->first();

            

            if( $category ) {

                if ($_FILES['picture']['name']) {
                    if (!$_FILES['picture']['error']) {
                        $name = md5(rand(100, 200));
                        $ext = explode('.', $_FILES['picture']['name']);
                        $filename = $name . '.' . $ext[1];
                        $destination = public_path() . '/images/' . $filename;
                        $location = $_FILES["picture"]["tmp_name"];
                        move_uploaded_file($location, $destination);

                        $category = ProductCategory::where('category',$request->category_name)
                        ->where('status','=','2')
                        ->first();

                        $category->status = '1';
                        $old_photo = $category->images;
                        $category->images = $filename;
                        $category->update();

                        if($old_photo != null) {
                            unlinked($old_photo);
                        }
                    }
                }

                
            } else {

                if (!$_FILES['picture']['error']) {
                    $name = md5(rand(100, 200));
                    $ext = explode('.', $_FILES['picture']['name']);
                    $filename = $name . '.' . $ext[1];
                    $destination = public_path() . '/images/' . $filename;
                    $location = $_FILES["picture"]["tmp_name"];
                    move_uploaded_file($location, $destination);

                    $category = new ProductCategory();
                    $category->category = $request['category_name'];
                    $category->images = $filename;
                    $category->save();
                }
            }

            DB::commit();
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Success',
                    'category' => $category
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
    
    public function editCategory(Request $request){
        DB::beginTransaction();

        function unlinked($file) {
            $destination = public_path() . '/images/' . $file;
            unlink($destination);
        }

        // dd(request()->all());

        // dd($request->picture);

        

        try {

            $filename = '';

            if ($_FILES['picture']['name']) {
                if (!$_FILES['picture']['error']) {
                    $name = md5(rand(100, 200));
                    $ext = explode('.', $_FILES['picture']['name']);
                    $filename = $name . '.' . $ext[1];
                    $request->picture->move(public_path('images'), $filename);
                }
            }
            
            $category = ProductCategory::find($request['id-to-update']);
            $category->category = $request['category_name'];
            $old_photo = $category->images;
            if($filename != '') {
                $category->images = $filename;
                unlinked($old_photo);
            }
            $category->update();

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

    public function deleteCategory(Request $request){
        DB::beginTransaction();

        try {

            $category = ProductCategory::find($request->id);
            $category->status = 2;
            $category->update();

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

    public function getProductCategoryTable(Request $request) {

        function image($image) {

            $url = asset('images/'.$image);
            
            return '
                <img src="'.$url.'" border="0" width="40" height="40" class="img-rounded" align="center" />
            ';
        }

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
            1 => 'category',
        );
        
        $totalDataRecord = ProductCategory::where('status', '1')->count();
        
        $totalFilteredRecord = $totalDataRecord;
        
        $limit_val = $request->input('length');
        $start_val = $request->input('start');
        $order_val = $columns_list[$request->input('order.0.column')];
        $dir_val = $request->input('order.0.dir');
        
        if(empty($request->input('search.value')))
        {
        $post_data = ProductCategory::offset($start_val)
        ->where('status', '1')
        ->limit($limit_val)
        ->orderBy($order_val,$dir_val)
        ->get();
        }
        else {
        $search_text = $request->input('search.value');
        
        $post_data =  ProductCategory::where('category','LIKE',"%{$search_text}%")
        ->where('status', '1')
        ->offset($start_val)
        ->limit($limit_val)
        ->orderBy($order_val,$dir_val)
        ->get();
        
        $totalFilteredRecord = ProductCategory::where('category','LIKE',"%{$search_text}%")
            ->where('status', '1')
            ->count();
        }
        
        $data_val = array();
        if(!empty($post_data))
        {
            foreach ($post_data as $key => $post_val)
            {

                

            $postnestedData['id'] = $key + 1;
            $postnestedData['category'] = $post_val->category;
            $postnestedData['image'] = image($post_val->images);
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
