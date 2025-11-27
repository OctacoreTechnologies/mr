<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Imports\ProductImport;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Supplier;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers=Supplier::where('status','active')->get();
        $category=Category::where('status','active')->get();
        $products=Product::get(['id', 'name', 'purchase_price', 'sales_price', 'unit', 'min_stock_qty', 'opening_stock', 'gst' ]);
        // dd();
        return view('product',['products'=>$products,'suppliers'=>$suppliers,'categories'=>$category]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        Product::create([
            'name'=>$request->name,
            'unit'=>$request->unit,
            'min_stock_qty'=>$request->min_stock_qty,
            'gst'=>$request->gst,
            'purchase_price'=>$request->purchase_price,
            'sales_price'=>$request->sales_price,
            'opening_stock'=>$request->opening_stock,
            'hsn_code'=>$request->hsn_code,
            'category_id'=>$request->category_id,
            'product_type'=>$request->product_type,
            'supplier_id'=>$request->supplier_id,
        ]);
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $suppliers=Supplier::where('status','active')->get();
        $categories=Category::where('status','active')->get();

        return view('product_edit',['product'=>$product, 'suppliers'=>$suppliers, 'categories'=>$categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->name=$request->name;
        $product->unit=$request->unit;
        $product->min_stock_qty=$request->min_stock_qty;
        $product->gst=$request->gst;
        $product->purchase_price=$request->purchase_price;
        $product->sales_price=$request->sales_price;
        $product->hsn_code=$request->hsn_code;
        $product->category_id=$request->category_id;
        $product->opening_stock=$request->opening_stock;
        $product->product_type=$request->product_type;
        $product->supplier_id=$request->supplier_id;
        
        $product->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return back();
    }


    public function export() 
    {
        return Excel::download(new ProductExport, 'product.xlsx');
    }

    public function import(Request $request) 
    {
        if ($request->hasFile('product')) {
            $file = $request->file('product');
        }
        Excel::import(new ProductImport, $file);
        return back()->with('success', 'All good!');
    }

    public function import_form(Request $request) 
    {
        return view('import_product');
    }


}
