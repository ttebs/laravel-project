<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserPurchases;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserPurchaseController extends Controller
{
    // Upload and save user document (one document per user)
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string|max:255',
            'product_id' => 'required|string|max:255',
            'quantity' => 'required|string|max:255',
            'payment_method' => 'required|string|max:255',
            'delivery_address' => 'required|string|max:255'
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

        $user_cart = UserPurchases::create([
            'user_id'     => $request->user_id,
            'product_id'     => $request->product_id,
            'quantity'     => $request->quantity,
            'payment_method'     => $request->payment_method,
            'delivery_address'     => $request->delivery_address,
        ]);

        return response()->json(['message' => 'User purchase created successfully', 'purchases' => $user_cart], 201);

    }

    // Get the document for a specific user
    public function show($userId)
    {
        
        $productIds = Product::where('seller', $userId)->pluck('id');

        // if (!$document) {
        //     return response()->json(['message' => 'Document not found for this user.'], 404);
        // }

        // return response()->json($products);

        // $purchase = UserPurchases::with('product')
        //     ->where('user_id', $userId)
        //     ->get();

        $purchases = UserPurchases::with(['product', 'user'])
        ->whereIn('product_id', $productIds)
        ->get();

        // if (!$purchase) {
        //     return response()->json(['message' => 'Purchase not found.'], 404);
        // }
    
        return response()->json($purchases);
    }

    public function showAdmin()
    {
        // $productIds = Product::where('seller', $userId)->pluck('id');

        $purchases = UserPurchases::with(['product', 'user'])->get();
        return response()->json($purchases);
    }


     // Get the document for a specific user
     public function getUserOrders($userId)
     {
         $purchase = UserPurchases::with(['product', 'user'])
             ->where('user_id', $userId)
             ->get();
     
         if (!$purchase) {
             return response()->json(['message' => 'Purchase not found.'], 404);
         }
     
         return response()->json($purchase);
     }
}
