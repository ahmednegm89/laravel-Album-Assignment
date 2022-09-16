<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Image;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::all();
        return view('album.index', compact('albums'));
    }


    public function move(Request $request)
    {
        $from_id = $request->from_album;
        $to_id = $request->album_id;

        $all_from_imgs = Image::where('album_id', $from_id)->get();
        foreach ($all_from_imgs as $all_from_img) {
            $all_from_img->album_id = $to_id;
            $all_from_img->save();
        }
        return redirect(route('album.delete', $from_id));
    }



    public function show($id)
    {
        $albums = Album::where('id', "!=", $id)->get();
        $album = Album::findOrFail($id);
        return view('album.show', compact('album', 'albums'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:albums',
            'cover' => 'required|image|mimes:jpeg,jpg,png|max:3072',
        ]);
        $img = $request->file('cover');
        $ext = $img->getClientOriginalExtension();
        $cover_name = "cover-" . uniqid() . ".$ext";
        $img->move(public_path('uploads/albums'), $cover_name);

        Album::create([
            'name' => $request->name,
            'cover' => $cover_name
        ]);

        return redirect(route('album.index'));
    }

    public function update(Request $request, $id)
    {
        $album = Album::findOrFail($id);
        $request->validate([
            'name' => "required|string|max:100|unique:albums,name,$id",
            'cover' => 'image|mimes:jpeg,jpg,png|max:3072',
        ]);

        $cover_name = $album->cover;
        if ($request->hasFile('cover')) {
            unlink(public_path('uploads/albums/') . $album->cover);
            $img = $request->file('cover');
            $ext = $img->getClientOriginalExtension();
            $cover_name = "cover-" . uniqid() . ".$ext";
            $img->move(public_path('uploads/albums'), $cover_name);
        }
        $album->update([
            'name' => $request->name,
            'cover' => $cover_name
        ]);
        return redirect(route('album.show', $id));
    }

    public function delete($id)
    {
        $album = Album::findOrFail($id);
        unlink(public_path('uploads/albums/') . $album->cover);
        $album->delete();
        return redirect(route('album.index'));
    }
}
