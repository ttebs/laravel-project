<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // Upload and save user document (one document per user)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'seller' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $document = new Product();

        // Store new file
        $path = $request->file('image')->store('products', 'public');

        // Save or update document info
        $document->name = $request->name;
        $document->price = $request->price;
        $document->seller = $request->seller;
        $document->image = $path;
        $document->save();

        return response()->json([
            'message' => 'Products saved successfully.',
            'document' => $document,
        ], 201);

    }

    // Get the document for a specific user
    public function show()
    {
        // $purchase = Product::with('seller')->first();

        return response()->json(Product::with('seller')->get());
    }

    public function productsByUser($id)
    {
        $document = Product::where('seller', $id)->get();

        // if (!$document) {
        //     return response()->json(['message' => 'Document not found for this user.'], 404);
        // }

        return response()->json($document);
    }

    public function deleteProductsBySeller($id)
    {
        $products = Product::where('id', $id)->get();

        if ($products->isEmpty()) {
            return response()->json(['message' => 'No products found for this seller.'], 404);
        }

        // Delete all the products
        Product::where('id', $id)->delete();

        return response()->json(['message' => 'All products for this seller have been deleted.']);
    }
}
