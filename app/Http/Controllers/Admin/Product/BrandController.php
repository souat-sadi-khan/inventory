<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Products\Brand;
use App\Models\Products\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.brand.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable() {
        if (request()->ajax()) {
            $ips = Brand::all();

			return DataTables::of($ips)
                ->addIndexColumn()
                ->editColumn('products', function($model){
                    return 0;
                })
                ->editColumn('date', function($model){
                    return formatDate($model->created_at);
                })
                ->editColumn('status', function($model){
                    if($model->status == 1) {
                        return '<span class="badge badge-primary">Active</span>';
                    } else {
                        return '<span class="badge badge-warning">Inactive</span>';
                    }
                })
                ->addColumn('image', function ($model) {
					if($model->brand_image != '') {
                        return '<img src="'. asset('storage/images/product/brand'. '/'. $model->brand_image) .'" alt="Category Image" width="33px">';
                    } else {
                        return '<img src="'. asset('images/product.jpg') .'" alt="Category Image" width="33px">';
                    }
				})
                ->addColumn('action', function ($model) {
                    return view('admin.product.brand.action', compact('model'));
                })
				->rawColumns(['products', 'date', 'status', 'image', 'action'])->make(true);
		}
    }

    public function slug($old_slug, $row = Null)
    {
        if(!$row){
            $slug = $old_slug;
            $row = 0;
        }else{
            $slug = $old_slug . '-'.$row;
        }

        $check_res = Brand::where('brand_slug', $slug)->first();
        if($check_res) {
            $slug = $this->slug($old_slug, $row+1);
        }

        return $slug;
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
            'brand_name' => 'required',
            'status' => 'required',
        ]);

        $slug = $this->slug(make_slug($request->brand_name));

        $model = new Brand;
        $model->brand_name = $request->brand_name;
        $model->brand_slug = $slug;
        $model->brand_code_name = $request->brand_code_name;
        $model->brand_details = $request->brand_details;
        $model->status = $request->status;

        if($request->hasFile('brand_image')) {

            $data = getimagesize($request->file('brand_image'));
            $width = $data[0];
            $height = $data[0];

            if($width > 110 && $height > 110) {
                return response()->json(['success' => true, 'status' => 'danger', 'message' => 'Brand Image Width and height is wrong']);
            }

            $storagepath = $request->file('brand_image')->store('public/images/product/brand');
            $fileName = basename($storagepath);

            $model->brand_image = $fileName;
        }

        $model->save();

        \SadikLog::addToLog('Created a Category - ' . $request->brand_name .'.');

        return response()->json(['status' => 'success', 'message' => 'New Brand is stored successfully']);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Brand::findOrFail($id);
        return view('admin.product.brand.edit', compact('model'));
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
            'brand_name' => 'required',
            'status' => 'required',
        ]);

        $slug = $this->slug(make_slug($request->brand_name));

        $model = Brand::findOrFail($id);
        $model->brand_name = $request->brand_name;
        $model->brand_slug = $slug;
        $model->brand_code_name = $request->brand_code_name;
        $model->brand_details = $request->brand_details;
        $model->status = $request->status;

        if($request->hasFile('brand_image')) {

            $data = getimagesize($request->file('brand_image'));
            $width = $data[0];
            $height = $data[0];

            if($width > 110 && $height > 110) {
                return response()->json(['success' => true, 'status' => 'danger', 'message' => 'Brand Image Width and height is wrong']);
            }

            $storagepath = $request->file('brand_image')->store('public/images/product/brand');
            $fileName = basename($storagepath);

            $model->brand_image = $fileName;

            //if file chnage then delete old one
            $oldFile = $request->get('old_image','');
            if( $oldFile != ''){
                $file_path = "public/images/product/brand/".$oldFile;
                Storage::delete($file_path);
            }
        }

        $model->save();

        \SadikLog::addToLog('Updated a Brand - ' . $request->brand_name .'.');

        return response()->json(['status' => 'success', 'message' => 'Brand is updated successfully']);

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
                   $model = Brand::findOrFail($id);
                    \SadikLog::addToLog('Deleted a Brand - ' . $model->v .'.');
                   $model->delete();
                   return response()->json(['status' => 'success', 'message' => 'Brand is deleted successfully']);
                } else {
                    throw ValidationException::withMessages(['message' =>'Brand Can not Deleted Because Product Exit This Brand']);
            }  

    }
}
