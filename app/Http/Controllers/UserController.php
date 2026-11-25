<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCollectionRequest;
use App\Http\Resources\MediaResource;
use App\Http\Resources\UserResource;
use App\Models\Media;
use App\Models\User;

class UserController extends Controller
{
    // GET /api/users
    public function index()
    {
        return UserResource::collection(User::paginate(10));
    }

    // GET /api/users/{user} -> pengguna + koleksi medianya
    public function show(User $user)
    {
        return new UserResource($user->load('media'));
    }

    // GET /api/users/{user}/collection -> hanya daftar media milik pengguna
    public function collection(User $user)
    {
        return MediaResource::collection($user->media()->orderBy('title')->paginate(10));
    }

    // POST /api/users/{user}/collection  body: { "media_id": 1 }
    public function addToCollection(AddToCollectionRequest $request, User $user)
    {
        $mediaId = $request->validated()['media_id'];

        if ($user->media()->where('media_id', $mediaId)->exists()) {
            return response()->json(['message' => 'Media sudah ada di koleksi'], 409);
        }

        $user->media()->attach($mediaId);

        return response()->json([
            'message' => 'Media berhasil ditambahkan ke koleksi',
            'data'    => new UserResource($user->load('media')),
        ], 201);
    }

    // DELETE /api/users/{user}/collection/{media}
    public function removeFromCollection(User $user, Media $media)
    {
        if (! $user->media()->where('media_id', $media->id)->exists()) {
            return response()->json(['message' => 'Media tidak ada di koleksi'], 404);
        }

        $user->media()->detach($media->id);

        return response()->json(['message' => 'Media berhasil dihapus dari koleksi']);
    }
}
