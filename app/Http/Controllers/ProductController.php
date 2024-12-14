<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('product.index', ['products' => Product::all()]);
    }

    //method not used
    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        // return $request;
        // dd($request->all());
        $request->validate(
            [
                'name'        => 'required|unique:products,name',
                'description' => 'required',
                'price'       => 'required|numeric|min:0|max:999999.99',
                'image'       => 'nullable|mimes:png,jpg,jpeg',
            ]
        );

        $product= Product::addProduct($request);
        return response()->json($product);
    }

    public function show(Product $product)
    {
        return response()->json(['item'=>$product]);
    }

    public function edit(Product $product)
    {
        return response()->json(['item'=>$product]);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate(
            [
                'name'        => 'required|unique:products,name,' . $product->id,
                'description' => 'required',
                'price'       => 'required|numeric|min:0|max:999999.99',
                'image'       => 'nullable|mimes:png,jpg,jpeg',
            ]
        );

        $product= Product::updateProduct($request, $product);
        return response()->json($product);
    }

    public function destroy(Product $product)
    {

        // Check if image is not null and file exists before unlinking
        if ($product->image && file_exists($product->image)) {
            unlink($product->image);
        }

        $product->delete();
        return response()->json(['item'=>'product deleted successfully']);
    }
}
