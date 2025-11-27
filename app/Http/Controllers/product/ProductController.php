<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products=Product::all();
        return response()->view('products.index',[
            'products'=>$products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
          $data = $request->validated();
        //   if ($request->hasFile('image_url')) {
        //     $imagePath = $request->file('image_url')->store('images/machines', 'public');
        //     $data['image_url'] = $imagePath;
        // }
          Product::create($data);
          session()->flash('success','product is added successfully');
          return response()->redirectToRoute('product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product=Product::findOrFail($id);
        return response()->view('products.show',[
            "product"=>$product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product=Product::findOrFail($id);
        return response()->view('products.editold',[
            "product"=>$product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $product=Product::findOrFail($id);
        // $data = $request->validated();
        // if ($request->hasFile("image_url")){
        //           // Delete the old image if it exists
        //     $imagePath=public_path("storage/".$product->image_url);
        //     if(file_exists($imagePath)){
        //         @unlink($imagePath);
        //     }
        // }
        $product->update($request->validated());
        session()->flash('success','product is updated successfully');
        return response()->redirectToRoute("product.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product=Product::findOrFail($id);
        $product->delete();
        session()->flash('success','product is deleted successfully');

        return response()->redirectToRoute('product.index');
    }
}
