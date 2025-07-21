<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserStore;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserStoreController extends Controller
{
    // Upload and save user document (one document per user)
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string|max:255',
            'store_name' => 'required|string|max:255',
            'store_address' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
        ]);

        // Check if user already has a document
        $existingDoc = UserStore::where('user_id', $request->user_id)->first();
        if ($existingDoc) {
            $document = $existingDoc;
            // Save or update document info
            $document->user_id = $request->user_id;
            $document->store_name = $request->store_name;
            $document->store_address = $request->store_address;
            $document->email = $request->email;
            $document->phone = $request->phone;
            $document->save();
            return response()->json(['message' => 'User store updated successfully', 'user_store' => $document], 201);

        } else {
            $user_cart = UserStore::create([
                'user_id'     => $request->user_id,
                'store_name'     => $request->store_name,
                'store_address'     => $request->store_address,
                'email'     => $request->email,
                'phone'     => $request->phone,
            ]);
            return response()->json(['message' => 'User store created successfully', 'user_store' => $user_cart], 201);
        }
       
    }

    // Get the document for a specific user
    public function show($userId)
    {
        $document = UserStore::where('user_id', $userId)->first();

        // if (!$document) {
        //     return response()->json(['message' => 'Store not found for this user.'], 404);
        // }

        return response()->json($document);
    }
}
