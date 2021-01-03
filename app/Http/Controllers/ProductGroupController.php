<?php

namespace App\Http\Controllers;

use App\Models\ProductGroup;
use Illuminate\Http\Request;

class ProductGroupController extends Controller
{
    public function index()
    {
        $route_active = 'productgroup';
        $productGroups = ProductGroup::get();
        $pg_ids = response()->json($productGroups->modelKeys());
        return view('crm.productgroup.index', compact(['route_active','productGroups','pg_ids']));    
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'name'=>'required | unique:product_groups'
        ]);
        if($validator){
            ProductGroup::create([
                'name'=>$request->name,
            ]);
            $notification = array(
                'message' => 'Product group added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function update(Request $request, ProductGroup $productGroup)
    {
        $validator = $request->validate([
            'name'=>'required | unique:product_groups,name,'.$productGroup->id
        ]);
       
        if($validator){
            $productGroup->name = $request->name;
            $productGroup->save();

            $notification = array(
                'message' => 'Product group updated successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            return back()->with($validator)->withInput();
        }
    }

    public function destroy(ProductGroup $productGroup)
    {
        if($productGroup->delete()){
            $notification = array(
                'message' => 'Product group deleted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Please refresh the page and try again!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }
}
