<?php

namespace App\Http\Controllers;

use App\Models\Album;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::select('id', 'name')->latest()->get();
        return view('admin.albums.index', compact('albums'));
    }


    public function movePhotos(Request $request, Album $album)
    {
        $newAlbum = Album::whereId($request->new_album_id)->firstOrFail();

        foreach ($album->getMedia('images') as $mediaItem) {
            $mediaItem->move($newAlbum, 'images');
        }

        $album->delete();
        return response()->json([
            'success' => true,
            'message' => 'Album Moved successfully'
        ]);
    }


    public function albumsExcept(Request $request)
    {
        $albums = Album::select('id', 'name')->whereNot('id', $request->id)->get();
        return response()->json([
            'albums' => $albums->pluck('name', 'id')
        ]);
    }



    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
        ]);
        Album::create($validatedData);
        session()->flash('success', 'The data has been saved successfully');
        return redirect()->route('album.index');
    }

    public function addPic(Album $album)
    {
        return view('admin.albums.add_pic', compact('album'));
    }


    public function storePic(Request $request, Album $album)
    {
        foreach ($request->data as $image) {
            $file = $image['filepond'];

            if (Storage::exists($file)) {

                $album->addMediaFromDisk($file)->usingName($image['name'])->toMediaCollection('images');
                Storage::delete($file);
            }
        }
        session()->flash('success', 'The data has been saved successfully');

        return redirect()->route('album.index');
    }

    public function show(Album $album)
    {
        $albumName = $album->name;
        $media = $album->getMedia('images');

        return view('admin.albums.show', compact('album', 'media'));
    }


    public function create(Album $album)
    {
        return view('admin.albums.create', compact('album'));
    }


    public function edit(Album $album)
    {

        return view('admin.albums.edit', compact('album'));
    }


    public function update(Request $request, Album $album)
    {
        $album->update([
            'name' => $request->name
        ]);
        return redirect()->route('album.index');
    }

    public function destroy(Album $album)
    {
        if ($album->hasMedia('images')) {
            foreach ($album->getMedia('images') as $mediaItem) {
                $mediaItem->delete();
            }
        }

        if ($album->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Album deleted successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Album Not Deleted'
        ], 422);
    }
}
