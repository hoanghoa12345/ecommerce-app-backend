<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::with(['category'])->latest()->get();
    }

    /**
     * Get list top product
     */

    public function getTop()
    {
        return Product::all()->slice(0, 4);
    }

    public function findBySlug($slug)
    {
        $product = Product::with(['category'])->where('slug', $slug)->first();
        $productsLike = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('slug', '!=', $slug)
            ->inRandomOrder()->take(4)->get();
        $product->relatedProduct = $productsLike;
        return $product;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $path = $request->image->store('upload');
        $product = new Product($request->all());
        $product->slug = Str::slug($product->name);
        $product->image = $path;
        return response($product->save(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return Product::with('category')->findOrFail($product->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $updateProduct = Product::find($product->id);
        $updateProduct->name = $request->name;
        $updateProduct->category_id = $request->category_id;
        $updateProduct->description = $request->description;
        $updateProduct->price = $request->price;
        $updateProduct->quantity = $request->quantity;
        $updateProduct->slug = Str::slug($request->name);
        if ($request->hasFile('image')) {
            $path = $request->image->store('upload');
            $updateProduct->image = $path;
        }
        return $updateProduct->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        return Product::destroy($product->id);
    }


    /**
     * Search product by name.
     * @param \Iluminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $name = $request->query('q');
        return Product::where('name', 'like', '%' . $name . '%')->get();
    }
}
