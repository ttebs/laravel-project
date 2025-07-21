<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserCart;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserCartController extends Controller
{
    // Upload and save user document (one document per user)
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|string|max:255',
        ]);

        // Check if user already has a document
        // $existingDoc = UserCart::where('user_id', $request->user_id)->first();
        // if ($existingDoc) {
        //     Storage::disk('public')->delete($existingDoc->document_path);
        //     $document = $existingDoc;
        // } else {
        //     $document = new UserCart();
        // }

        // Store new file
        // $path = $request->file('document_path')->store('user_documents', 'public');

        // Save or update document info

        $user_cart = UserCart::create([
            'user_id'     => $request->user_id,
            'product_id'     => $request->product_id,
        ]);

        return response()->json(['message' => 'User created successfully', 'user_cart' => $user_cart], 201);

    }

    // Get the document for a specific user
    public function show($userId)
    {
        // return response()->json(Product::with('seller')->get());
        $document = UserCart::with('product')->where('user_id', $userId)->get();

        if (!$document) {
            return response()->json(['message' => 'Document not found for this user.'], 404);
        }

        return response()->json($document);
    }

    public function deleteProductFromCart($userId, $productId)
    {
        $products = UserCart::where('user_id', $userId)
                                ->where('product_id', $productId)
                                ->get();

        if ($products->isEmpty()) {
            return response()->json(['message' => 'No products found for this seller.'], 404);
        }

        // Delete all the products
        UserCart::where('user_id', $userId)
        ->where('product_id', $productId)
        ->delete();

        return response()->json(['message' => 'All products for this seller have been deleted.']);
    }
}
