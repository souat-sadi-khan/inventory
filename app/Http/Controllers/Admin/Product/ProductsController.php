<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Admin\Account;
use App\Models\Admin\AccountTransaction;
use App\Models\Products\Box;
use App\Models\Products\Brand;
use App\Models\Products\Category;
use App\Models\Products\Product;
use App\Models\Products\TaxRate;
use App\Models\Products\Unit;
use App\Models\Supplier;
use App\Purchase;
use App\TransactionSellLine;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.product.index');
    }

    // add_category
    public function add_category() {
        return view('admin.product.product.add_category');
    }

    // save_category
    public function save_category(Request $request) {
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
                return response()->json(['status' => 'danger', 'message' => 'Category Image Width and height is wrong']);
            }

            $storagepath = $request->file('category_image')->store('public/images/product/category');
            $fileName = basename($storagepath);

            $model->category_image = $fileName;
        }

        $model->save();

        \SadikLog::addToLog('Created a Category - ' . $request->category_name .'.');

        return response()->json(['status' => 'success', 'id' => $model->id, 'text' => $model->category_name, 'message' => 'New Category is stored successfully']);

    }

    // make_slug
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

    // add_supplier
    public function add_supplier() {
        return view('admin.product.product.add_supplier');
    }

    // save_supplier
    public function save_supplier(Request $request) {
        $request->validate([
            'sup_name' => 'required',
            'code_name' => 'required',
            'sup_mobile' => 'required',
            'net_total' => 'nullable|numeric',
            'status' => 'required',
        ]);

        $model = new Supplier;
        $model->sup_name = $request->sup_name;
        $model->code_name = $request->code_name;
        $model->sup_mobile = $request->sup_mobile;
        $model->sup_email = $request->sup_email;
        $model->sup_address = $request->sup_address;
        $model->sup_city = $request->sup_city;
        $model->sup_state = $request->sup_state;
        $model->sup_country = $request->sup_country;
        $model->status = $request->status;
        $model->save();

        \SadikLog::addToLog('Created a Suppler - ' . $request->sup_name .'.');

        return response()->json(['status' => 'success', 'id' => $model->id, 'text' => $model->sup_name, 'message' => 'New Supplier is stored successfully']);

    }

    // add_brand
    public function add_brand() {
        return view('admin.product.product.add_brand');
    }

    // save_brand
    public function save_brand(Request $request) {
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

        return response()->json(['status' => 'success', 'id' => $model->id, 'text' => $model->brand_name, 'message' => 'New Brand is stored successfully']);

    }

    // add_box
    public function add_box() {
        return view('admin.product.product.add_box');
    }

    // save_box
    public function save_box(Request $request) {
        $request->validate([
            'box_name' => 'required',
            'status' => 'required',
        ]);

        $model = new Box;
        $model->box_name = $request->box_name;
        $model->box_code_name = $request->box_code_name;
        $model->status = $request->status;
        $model->box_details = $request->box_details;
        $model->save();

        \SadikLog::addToLog('Created a Product Box - ' . $request->box_name .'.');

        return response()->json(['status' => 'success', 'id' => $model->id, 'text' => $model->box_name, 'message' => 'New Box is stored successfully']);

    }

    // add_unit
    public function add_unit() {
        return view('admin.product.product.add_unit');
    }

    // save_unit
    public function save_unit(Request $request) {
        $request->validate([
            'unit_name' => 'required',
            'status' => 'required',
        ]);

        $model = new Unit;
        $model->unit_name = $request->unit_name;
        $model->unit_code_name = $request->unit_code_name;
        $model->unit_details = $request->unit_details;
        $model->status = $request->status;
        $model->save();

        \SadikLog::addToLog('Created a Unit - ' . $request->unit_name .'.');

        return response()->json(['status' => 'success', 'id' => $model->id, 'text' => $model->unit_name, 'message' => 'New Unit is stored successfully']);
    }

    // add_tax
    public function add_tax() {
        return view('admin.product.product.add_tax');
    }

    // tax_id
    public function save_tax(Request $request) {
        $request->validate([
            'tax_name' => 'required',
            'tax_rate' => 'required|numeric',
            'tax_rules' => 'required',
            'status' => 'required',
        ]);

        $model = new TaxRate;
        $model->tax_name = $request->tax_name;
        $model->tax_code_name = $request->tax_code_name;
        $model->tax_rate = $request->tax_rate;
        $model->tax_rules = $request->tax_rules;
        $model->status = $request->status;
        $model->save();

        \SadikLog::addToLog('Created a Tax - ' . $request->tax_name .'.');

        return response()->json(['status' => 'success', 'id' => $model->id, 'text' => $model->tax_name, 'message' => 'New Tax is stored successfully']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable(Request $request) {
        if (request()->ajax()) {

            $model = Product::query();

            if (request()->has('category_id')) {
                $category_id = request()->get('category_id');
                if (!empty($category_id)) {
                    $model=$model->where('category_id', $category_id);
                }
            }
             if (request()->has('brand_id')) {
                $brand_id = request()->get('brand_id');
                if (!empty($brand_id)) {
                    $model=$model->where('brand_id', $brand_id);
                }
            }
            if (request()->has('expense_category_id')) {
                $expense_category_id = request()->get('expense_category_id');
                if (!empty($expense_category_id)) {
                    $model=$model->where('expense_category_id', $expense_category_id);
                }
            }
        if (request()->has('product_code')) {
            $product_code = request()->get('product_code');
         if (!empty($product_code)) {

            $model =$model->where('product_code', 'like', '%' . $product_code . '%');

           }
         }
        $model=$model->get();

			return DataTables::of($model)
                ->addIndexColumn()
                ->editColumn('image', function($model){
                    return ($model->product_image != '' ? '<img src="'. asset('storage/images/product/product'. '/'. $model->product_image) .'" alter="Product Image" style="width:50px;">' :  '<img src="'. asset("images/product.jpg").'" alter="Product Image" style="width:50px;">');
                })
                ->editColumn('supplier', function($model){
                    return ($model->supplier_id != 0 ? $model->supplier->sup_name : 'No Supplier');
                })
                ->editColumn('stock', function($model){
                    return $model->stock;
                })
                ->editColumn('cost', function($model){
                    return '<span class="text-info">'. get_option('currency_symbol') . ''. number_format($model->product_cost, 2). '</span>';
                })
                ->editColumn('price', function($model){
                    return '<span class="text-success">'. get_option('currency_symbol') . ''. number_format($model->product_price, 2). '</span>';
                })
                ->editColumn('opening', function($model){
                    return $model->opening;
                })
                ->addColumn('action', function($model){
                    return view('admin.product.product.action', compact('model'));
                })
                ->setRowAttr([
                    'data-url' => function ($model) {
                            return  route('admin.products.products.show', [$model->id]) ;
                    }])
                // ->setRowClass('btn_modal')
				->rawColumns(['supplier', 'image', 'stock', 'cost', 'price', 'opening', 'action'])->make(true);
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
            'product_image' => 'mimes:jpeg,bmp,png,jpg|max:500',
            'product_name' => 'required',
            'product_code' => 'required',
            'product_cost' => 'required|numeric',
            'product_price' => 'required|numeric',
            'opening' => 'nullable|numeric',
        ]);

        $model = new Product;
        $model->product_name = $request->product_name;
        $model->product_code = $request->product_code;
        if(intval($request->product_category_id) != 0) {
            $model->category_id = intval($request->product_category_id);
        }

        if(intval($request->supplier_id) != 0) {
            $model->supplier_id = $request->supplier_id;
        }

        if(intval($request->brand_id) != 0) {
            $model->brand_id = $request->brand_id;
        }


        if(intval($request->box_id) != 0) {
            $model->box_id = $request->box_id;
        }

        if(intval($request->unit_id) != 0) {
            $model->unit_id = $request->unit_id;
        }

        $model->product_cost = $request->product_cost;
        $model->product_price = $request->product_price;
        $model->opening = $request->get('opening');
        $model->opening_price = $request->product_cost;
        $model->opening_value = $request->product_cost*$request->get('opening');
        $model->stock = $request->get('opening');

        $model->product_details = $request->product_details;

        if($request->hasFile('product_image')) {

            $data = getimagesize($request->file('product_image'));
            $width = $data[0];
            $height = $data[0];

            if($width > 1900 && $height > 1900) {
                return response()->json(['success' => true, 'status' => 'danger', 'message' => 'Category Image Width and height is wrong']);
            }

            $storagepath = $request->file('product_image')->store('public/images/product/product');
            $fileName = basename($storagepath);

            $model->product_image = $fileName;
        }

        $model->save();

        if($request->get('opening')){
            $ac = new AccountTransaction();
            $ac->account_id = Account::where('name', 'Product')->first()->id;
            $ac->type = 'Debit';
            $ac->amount = $request->product_cost*$request->get('opening');
            $ac->operation_date = date('Y-m-d');
            $ac->note = $request->product_name . 'Opening Stock Value';
            $ac->save();

            $ac = new AccountTransaction();
            $ac->account_id = Account::where('category', 'Cash_in_hand')->first()->id;
            $ac->type = 'Credit';
            $ac->amount = $request->product_cost*$request->get('opening');
            $ac->operation_date = date('Y-m-d');
            $ac->note = $request->product_name . 'Opening Stock Value';
            $ac->save();
        }

        \SadikLog::addToLog('Created a Product - ' . $request->product_name .'.');

        return response()->json(['status' => 'success', 'message' => 'New Product is stored successfully']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model =Product::find($id);
        return view('admin.product.product.show',compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model =Product::find($id);
        return view('admin.product.product.edit',compact('model'));
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
            'product_image' => 'mimes:jpeg,bmp,png,jpg|max:500',
            'product_name' => 'required',
            'product_code' => 'required',
            'product_cost' => 'required|numeric',
            'product_price' => 'required|numeric',
            'opening' => 'nullable|numeric',
        ]);

        $model = Product::find($id);
        $model_old_product_name = $model->product_name;
        $model->product_name = $request->product_name;
        $model->product_code = $request->product_code;
        if(intval($request->product_category_id) != 0) {
            $model->category_id = intval($request->product_category_id);
        }

        if(intval($request->supplier_id) != 0) {
            $model->supplier_id = $request->supplier_id;
        }

        if(intval($request->brand_id) != 0) {
            $model->brand_id = $request->brand_id;
        }


        if(intval($request->box_id) != 0) {
            $model->box_id = $request->box_id;
        }

        if(intval($request->unit_id) != 0) {
            $model->unit_id = $request->unit_id;
        }

        $model->product_cost = $request->product_cost;
        $model->product_price = $request->product_price;
                //opening stocks
        $current_stock = ($model->id) ? $model->stock : 0;
        $open= ($model->id) ? $model->opening : 0;
        $model->stock = $current_stock + $request->get('opening')-$open;
        $model->opening = $request->get('opening');
        $model->opening_price = $request->product_cost;
        $model->opening_value = $request->get('opening')*$request->product_cost;

        $model->product_details = $request->product_details;

        if($request->hasFile('product_image')) {

        if ($model->product_image) {
          $file_path = "public/images/product/product/" . $model->product_image;
           Storage::delete($file_path);
          }

            $data = getimagesize($request->file('product_image'));
            $width = $data[0];
            $height = $data[0];

            if($width > 1900 && $height > 1900) {
                return response()->json(['success' => true, 'status' => 'danger', 'message' => 'Image Width and height is wrong']);
            }

            $storagepath = $request->file('product_image')->store('public/images/product/product');
            $fileName = basename($storagepath);

            $model->product_image = $fileName;
        }
      else {
       $fileName= $model->product_image;
       $model->product_image = $fileName;
      }

        $model->save();

      AccountTransaction::where('note', $model_old_product_name . 'Opening Stock Value')->delete();

        if($request->get('opening')){
            $ac = new AccountTransaction();
         
            $ac->account_id = Account::where('name', 'Product')->first()->id;
            $ac->type = 'Debit';
            $ac->amount = $request->product_cost*$request->get('opening');
            $ac->operation_date = date('Y-m-d');
            $ac->note = $request->product_name . 'Opening Stock Value';
            $ac->save();

            $ac = new AccountTransaction();
            $ac->account_id = Account::where('category', 'Cash_in_hand')->first()->id;
            $ac->type = 'Credit';
            $ac->amount = $request->product_cost*$request->get('opening');
            $ac->operation_date = date('Y-m-d');
            $ac->note = $request->product_name . 'Opening Stock Value';
            $ac->save();
        }


        \SadikLog::addToLog('Update a Product - ' . $request->product_name .'.');

        return response()->json(['status' => 'success', 'message' => 'Product  Update successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $count1 = TransactionSellLine::where('product_id', $id)->count();
        $count2 = Purchase::where('product_id', $id)->count();
          if ($count1 == 0 || $count2==0) {
                   $model = Product::findOrFail($id);
                     if ($model->product_price) {
                        unlink('public/images/product/product/'.$model->product_image);
                        }
                    \SadikLog::addToLog('Deleted a Product - ' . $model->product_name .'.');
                   $model->delete();
                   return response()->json(['status' => 'success', 'message' => 'Product is deleted successfully']);
                } else {
                    throw ValidationException::withMessages(['message' =>'Product Can not Deleted Because Sale or Purchase Exit This Product']);
            }
    }

    public function product_filter()
    {
        $categories=Category::select('id','category_name')->get();
        $brands =Brand::select('id','brand_name')->get();
        return view('admin.product.product.filter',compact('categories','brands'));
    }
}
