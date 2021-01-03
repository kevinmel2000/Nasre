<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TaxRate;
use App\Models\Currency;
use App\Models\ProductGroup;
use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $route_active = 'product';
        $user = Auth::user();
        $products = Product::orderby('id','desc')->get();
        $productGroups = ProductGroup::get();
        $product_ids = response()->json($products->modelKeys());
        $base_currency = Currency::where(['is_base_currency'=>'yes'])->first();
        return view('crm.product.index', compact(['route_active', 'products','productGroups','base_currency','product_ids']));        
    }

    /**
     *  GET - /product/import
     *  
     *  @return blade file
     */
    public function import()
    {
        $route_active = 'product';
        return view('crm.product.products_import', compact(['route_active']));
    }

    /**
     *  POST - /product/import
     *  
     *  @param - product fields
     *  
     *  @return - bulk import products
     */
    public function importStore(Request $request){
        $file = $request->file('file')->store('import');
        $import = new ProductsImport;
        $import->import($file);
        if(count($import->errors()) == 0){
            $notification = array(
                'message' => $import->getRowCount().' products imported successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->withErrors($import->errors());
        }
    }

    public function create()
    {
        $route_active = 'productCreate';
        $productGroups = ProductGroup::get();
        $taxrates = TaxRate::get();
        $base_currency = Currency::where(['is_base_currency'=>'yes'])->first();
        return view('crm.product.create', compact(['route_active','productGroups','base_currency','taxrates']));  
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'name'=>'required',
            'sku'=>'sometimes | unique:products'
        ]);
        if($validator){
            $user = Auth::user();
            Product::create([
                'name'=>$request->name,
                'product_group_id'=>$request->group_id,
                'sku'=>$request->sku,
                'price'=>$request->price,
                'discount'=>$request->discount,
                'units'=>$request->units,
                'tax_type_1'=>$request->tax_type_1,
                'tax_type_2'=>$request->tax_type_2,
                'tax_type_3'=>$request->tax_type_3,
                'short_description'=>$request->short_description,
                'long_description'=>$request->long_description,
                'created_by_id'=>$user->id
            ]);
            $notification = array(
                'message' => 'Product added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function edit(Product $product)
    {
        $route_active = 'productCreate';
        $productGroups = ProductGroup::get();
        $taxrates = TaxRate::get();
        $base_currency = Currency::where(['is_base_currency'=>'yes'])->first();
        return view('crm.product.edit', compact(['route_active','productGroups','base_currency','taxrates','product'])); 
    }

    public function update(Request $request, Product $product)
    {
        $validator = $request->validate([
            'name'=>'required',
            'sku'=>'sometimes | unique:products,sku,'.$product->id
        ]);
        if($validator){
            $product->name = $request->name;
            $product->product_group_id = $request->product_group_id;
            $product->sku = $request->sku;
            $product->price = $request->price;
            $product->discount = $request->discount;
            $product->units = $request->units;
            $product->tax_type_1 = $request->tax_type_1;
            $product->tax_type_2 = $request->tax_type_2;
            $product->tax_type_3 = $request->tax_type_3;
            $product->short_description = $request->short_description;
            $product->long_description = $request->long_description;
            $product->save();
            $notification = array(
                'message' => 'Product updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function destroy(Product $product)
    {
        if($product->delete()){
            $notification = array(
                'message' => 'Product deleted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Contact admin!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }
}
