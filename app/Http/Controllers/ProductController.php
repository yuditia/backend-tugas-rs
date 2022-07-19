<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::latest()->get();

        if ($request->ajax()) {
            $data = Product::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->product_id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editData"><i class="fa-regular fa-pen-to-square"></i> Edit</a>';
                           $btn.= '&nbsp;&nbsp';
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->product_id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteData"><i class="fa-solid fa-trash"></i> Delete</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('products.index',compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image'=>'mimes:png,jpg|max:3000',
            'name'=>'required',
            'stock'=>'required',
            'price'=>'required'
        ]);

        if($request->file('image')){
            $path  = $request->file('image')->store('image-product');
        }

        $id = IdGenerator::generate(['table' => 'products','field'=>'product_id', 'length' => 8, 'prefix' =>'PRD-']);

        $product = new Product();
        $product->product_id = $id;
        $product->name = $request->name;
        $product->stock = $request->stock;
        $product->image = $path;
        $product->price = $request->price;

        $product->save();
        Alert::success('Success Title', 'Success Message');


        return redirect('/products');
    }

    public function edit($product_id)
    {
      $where = array('product_id' => $product_id);
    //   dd($where);
      $products  = Product::where($where)->first();
        // dd($products);
      return response()->json($products);
    }

    public function update(Request $request,$product_id)
    {
        // dd($request);
        $rule = [
            'image'=>'mimes:png,jpg|max:3000',
            'name'=>'required',
            'stock'=>'required',
            'price'=>'required'
        ];

        $validator = $request->validate($rule);

        if($validator){
            $product = Product::where('product_id',$product_id);
            // dd($product);
            if($request->file('image')){
                if($request->oldImage){
                    Storage::delete($request->oldImage);
                }

                $path  = $request->file('image')->store('image-product');
            }else{
                $path = $request->oldImage;
            }


        $product->update([
            // 'product_id'=>$request->product_id,
            'name' => $request->name,
            'stock' => $request->stock,
            'price' => $request->price,
            'image'=>$path,
        ]);

        Alert::success('Success Title', 'Success Message');


        return redirect('/products');

        }
            return response()->json([
                'message'=>'update failed',
                'success'=>false
            ]);
    }
    public function destroy($product_id)
    {
        $user = Product::where('product_id',$product_id);
        $user->delete();
        return redirect('/products');
    }
}
