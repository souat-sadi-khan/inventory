<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Products\Category;
use App\Models\Products\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.category.index');
    }

    // get_category
    public function get_category(Request $request) {
        $search = $request->search;

        if($search == ''){
            $categories = Category::where('status', '1')->orderby('category_name','asc')->select('id','category_name', 'status')->get();
        } else {
            $categories = Category::where('status', '1')->orderby('category_name','asc')->select('id','category_name', 'status')->where('category_name', 'like', '%' .$search . '%')->get();
        }

        $response = array();
        foreach($categories as $item){
            $response[] = array(
                "id"=>$item->id,
                "text"=>$item->category_name,
            );
        }
        echo json_encode($response);
        exit;
    }

    public function slug($old_slug, $row = Null)
    {
        if(!$row){
            $slug = $old_slug;
            $row = 0;
        }else{
            $slug = $old_slug . '-'.$row;
        }

        $check_res = Category::where('category_slug', $slug)->first();
        if($check_res) {
            $slug = $this->slug($old_slug, $row+1);
        }

        return $slug;
    }

    public function datatable() {
        if (request()->ajax()) {
            $ips = Category::all();

			return DataTables::of($ips)
                ->addIndexColumn()
                ->editColumn('products', function($model){
                    return 0;
                })
                ->editColumn('date', function($model){
                    return formatDate($model->created_at);
                })
                ->editColumn('parent', function($model){
                    $parent_id = $model->parent_id;
                    if($parent_id == 'x') {
                        return 'Parent';
                    } else {
                        $cat = Category::findOrFail($parent_id);
                        if($cat) {
                            return $cat->category_name;
                        }
                    }
                })
                ->editColumn('status', function($model){
                    if($model->status == 1) {
                        return '<span class="badge badge-primary">Active</span>';
                    } else {
                        return '<span class="badge badge-warning">Inactive</span>';
                    }
                })
                ->addColumn('image', function ($model) {
					if($model->category_image != '') {
                        return '<img src="'. asset('storage/images/product/category'. '/'. $model->category_image) .'" alt="Category Image" width="33px">';
                    } else {
                        return '<img src="'. asset('images/product.jpg') .'" alt="Category Image" width="33px">';
                    }
				})
                ->addColumn('action', function ($model) {
					return view('admin.product.category.action', compact('model'));
                })
				->rawColumns(['parent', 'products', 'date', 'status', 'image', 'view', 'sction'])->make(true);
		}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_image' => 'mimes:jpeg,bmp,png,jpg|max:500',
            'category_name' => 'required',
        ]);

        $slug = $this->slug(make_slug($request->category_name));

        $model = new Category;
        $model->category_name = $request->category_name;
        $model->category_slug = $slug;
        $model->parent_id = $request->parent_id;
        $model->status = $request->status;
        $model->category_details = $request->category_details;

        if($request->hasFile('category_image')) {

            $data = getimagesize($request->file('category_image'));
            $width = $data[0];
            $height = $data[0];

            if($width > 110 && $height > 110) {
                return response()->json(['success' => true, 'status' => 'danger', 'message' => 'Category Image Width and height is wrong']);
            }

            $storagepath = $request->file('category_image')->store('public/images/product/category');
            $fileName = basename($storagepath);

            $model->category_image = $fileName;
        }

        $model->save();

        \SadikLog::addToLog('Created a Category - ' . $request->category_name .'.');

        return response()->json(['status' => 'success', 'message' => 'New Category is stored successfully']);

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Category::findOrFail($id);
        return view('admin.product.category.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_image' => 'mimes:jpeg,bmp,png,jpg|max:500',
            'category_name' => 'required',
        ]);

        $slug = $this->slug(make_slug($request->category_name));

        $model = Category::findOrFail($id);
        $model->category_name = $request->category_name;
        $model->category_slug = $slug;
        $model->parent_id = $request->parent_id;
        $model->status = $request->status;
        $model->category_details = $request->category_details;

        if($request->hasFile('category_image')) {

            $data = getimagesize($request->file('category_image'));
            $width = $data[0];
            $height = $data[0];

            if($width > 110 && $height > 110) {
                return response()->json(['success' => true, 'status' => 'danger', 'message' => 'Category Image Width and height is wrong']);
            }

            $storagepath = $request->file('category_image')->store('public/images/product/category');
            $fileName = basename($storagepath);

            $model->category_image = $fileName;

            //if file chnage then delete old one
            $oldFile = $request->get('old_image','');
            if( $oldFile != ''){
                $file_path = "public/images/product/category/".$oldFile;
                Storage::delete($file_path);
            }
        }

        $model->save();

        \SadikLog::addToLog('Updated a Category - ' . $request->category_name .'.');

        return response()->json(['status' => 'success', 'message' => 'Category is updated successfully']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $count = Product::where('category_id', $id)->count();
          if ($count == 0) {
                   $model = Category::findOrFail($id);
                    \SadikLog::addToLog('Deleted a Category - ' . $model->category_name .'.');
                   $model->delete();
                   return response()->json(['status' => 'success', 'message' => 'Category is deleted successfully']);
                } else {
                    throw ValidationException::withMessages(['message' =>'Category Can not Deleted Because Product Exit This Category']);
            }  


    }
}
