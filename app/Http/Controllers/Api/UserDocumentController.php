<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserDocument;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserDocumentController extends Controller
{
    // Upload and save user document (one document per user)
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'document_type' => 'required|string|max:255',
            'document_path' => 'required|image|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Check if user already has a document
        $existingDoc = UserDocument::where('user_id', $request->user_id)->first();
        if ($existingDoc) {
            Storage::disk('public')->delete($existingDoc->document_path);
            $document = $existingDoc;
        } else {
            $document = new UserDocument();
        }

        // Store new file
        $path = $request->file('document_path')->store('user_documents', 'public');

        // Save or update document info
        $document->user_id = $request->user_id;
        $document->document_type = $request->document_type;
        $document->document_path = $path;
        $document->save();

        return response()->json([
            'message' => 'User document saved successfully.',
            'document' => $document,
        ], 201);
    }

    // Get the document for a specific user
    public function show($userId)
    {
        $document = UserDocument::where('user_id', $userId)->first();

        if (!$document) {
            return response()->json(['message' => 'Document not found for this user.'], 404);
        }

        return response()->json($document);
    }
}
