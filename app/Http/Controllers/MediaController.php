<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    // GET /api/media            -> daftar media (pagination)
    // GET /api/media?search=xxx -> cari berdasarkan judul
    public function index(Request $request)
    {
        $media = Media::query()
            ->when($request->query('search'), function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->orderBy('id')
            ->paginate(20)
            ->withQueryString();

        return MediaResource::collection($media);
    }

    // GET /api/media/{media} -> detail media + pengguna yang mengoleksi (eager loading)
    public function show(Media $media)
    {
        return new MediaResource($media->load('users'));
    }

    // POST /api/media -> 201 Created
    public function store(StoreMediaRequest $request)
    {
        $media = Media::create($request->validated());

        return (new MediaResource($media))
            ->response()
            ->setStatusCode(201);
    }

    // PATCH /api/media/{media}
    public function update(StoreMediaRequest $request, Media $media)
    {
        $media->update($request->validated());

        return new MediaResource($media);
    }

    // DELETE /api/media/{media}
    public function destroy(Media $media)
    {
        $media->delete(); // baris pivot ikut terhapus (cascadeOnDelete)

        return response()->json(['message' => 'Media berhasil dihapus']);
    }
}
