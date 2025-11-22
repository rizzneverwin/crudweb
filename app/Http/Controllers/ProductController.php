<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Validation\Rule;
use Validator;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.index');
    }

    // return all products as JSON (for frontend pagination)
    public function fetch()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:191',
            'details' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        Product::create([
            'name' => $request->name,
            'details' => $request->details,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return response()->json(['status' => 'success']);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string|max:191',
            'details' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'details' => $request->details,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return response()->json(['status' => 'updated']);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['status' => 'deleted']);
    }
}
