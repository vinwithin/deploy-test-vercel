<?php

namespace App\Http\Controllers;

use App\Models\Publikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class publikasiCOntroller extends Controller
{
    public function index()
    {
        return view('publikasi.create');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);
        $validateData['slug'] = Str::slug($request->title, '-');
        preg_match_all('/data:image[^>]+=/i', $validateData['content'], $matches);
        $imageTags = $matches[0];
        if (count($imageTags) > 0) {
            foreach ($imageTags as $tagImage) {
                $image = preg_replace('/^data:image\/\w+;base64,/', '', $tagImage);
                $extension = explode('/', explode(':', substr($tagImage, 0, strpos($tagImage, ';')))[1])[1];
                $allowedTypes = ['jpeg', 'jpg', 'png', 'gif'];
                if (!in_array($extension, $allowedTypes)) {
                    return response()->json([
                        'message' => 'Invalid image type. Allowed types: ' . implode(', ', $allowedTypes)
                    ], 422);
                }
                $imageName = Str::random(10) . '.' . $extension;
                Storage::disk('public')->put('media/' . $imageName, base64_decode($image));
                $validateData['content'] = str_replace($tagImage,  asset('/storage/media/' . $imageName), $validateData['content']);
            }
        }

        $result = Publikasi::create($validateData);
        if ($result) {
            return "Terimakasih Sudah Mengisi Data";
        } else {
            return redirect('/')->with("error", "Gagal menambahkan data! Mohon isi kembali");
        }
    }

}
