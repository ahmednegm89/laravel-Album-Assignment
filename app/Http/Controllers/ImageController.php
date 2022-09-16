<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:images',
            'img' => 'required|image|mimes:jpeg,jpg,png|max:3072',
        ]);
        $img = $request->file('img');
        $ext = $img->getClientOriginalExtension();
        $img_name = $request->name . ".$ext";
        $img->move(public_path('uploads/imgs'), $img_name);

        Image::create([
            'name' => $img_name,
            'album_id' => $request->album_id,
        ]);

        return redirect(route('album.show', $request->album_id));
    }
    public function delete($id)
    {
        $img = Image::findOrFail($id);
        unlink(public_path('uploads/imgs/') . $img->name);
        $img->delete();
        return back();
    }
}
